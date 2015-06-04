<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\ProductSale;
use AppBundle\Form\ProductSaleType;

use AppBundle\Entity\Product;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * ProductSale controller.
 *
 */
class ProductSaleController extends Controller
{

    /**
     * Lists all ProductSale entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:ProductSale')->findAll();

        return $this->render(
            'AppBundle:ProductSale:index.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }

    /**
     * Creates a new ProductSale entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ProductSale();
        $form   = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('productsale_show', array('id' => $entity->getId())));
        }

        return $this->render(
            'AppBundle:ProductSale:new.html.twig',
            array(
                'entity' => $entity,
                'form'   => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a ProductSale entity.
     *
     * @param ProductSale $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ProductSale $entity)
    {
        $form = $this->createForm(
            new ProductSaleType(),
            $entity,
            array(
                'action' => $this->generateUrl('productsale_create'),
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ProductSale entity.
     *
     */
    public function newAction()
    {
        $entity = new ProductSale();
        $form   = $this->createCreateForm($entity);

        return $this->render(
            'AppBundle:ProductSale:new.html.twig',
            array(
                'entity' => $entity,
                'form'   => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a ProductSale entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ProductSale')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductSale entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'AppBundle:ProductSale:show.html.twig',
            array(
                'entity'      => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing ProductSale entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ProductSale')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductSale entity.');
        }

        $editForm   = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'AppBundle:ProductSale:edit.html.twig',
            array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a ProductSale entity.
     *
     * @param ProductSale $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ProductSale $entity)
    {
        $form = $this->createForm(
            new ProductSaleType(),
            $entity,
            array(
                'action' => $this->generateUrl('productsale_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing ProductSale entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ProductSale')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductSale entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm   = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('productsale_edit', array('id' => $id)));
        }

        return $this->render(
            'AppBundle:ProductSale:edit.html.twig',
            array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a ProductSale entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em     = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:ProductSale')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ProductSale entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('productsale'));
    }

    /**
     * Creates a form to delete a ProductSale entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('productsale_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    public function searchByCodeAction(Request $request)
    {
        $code          = $request->get('term');
        $entityManager = $this->getDoctrine()->getManager();
        $repository    = $entityManager->getRepository(ProductSale::REPOSITORY);
        $queryBuilder  = $repository->createQueryBuilder('productSale');
        $products      = $queryBuilder->select('productSale')->where('product.code like :code')->andWhere('productSale.active=1')->innerJoin(
            Product::REPOSITORY,
            'product',
            Join::WITH,
            $queryBuilder->expr()->eq('product', 'productSale.product')
        )->setParameter('code', "$code%")->getQuery()->getResult();
        $response      = array();
        foreach ($products as $productSale) {
            $response[] = array(
                'id'    => $productSale->getId(),
                'code'  => $productSale->getProduct()->getCode(),
                'title' => $productSale->getProduct()->getTitle(),
                'price' => $productSale->getPrice(),
            );
        }

        return new JsonResponse($response);
    }
}
