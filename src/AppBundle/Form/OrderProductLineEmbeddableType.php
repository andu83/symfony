<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderProductLineEmbeddableType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['title'] = $options['title'];
        $view->vars['route'] = $options['route'];
        $view->vars['columns'] = $options['columns'];
        $view->vars['search'] = $options['search'];
    }

    /**     * @param OptionsResolverInterface $resolver */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => null, 'title' => null, 'route' => null, 'columns' => array(), 'search' => null, 'itemsPerPage' => 10)
        );
    }

    /**     * @return string */
    public function getName()
    {
        return 'appbundle_orderproductline_embeddable';
    }
}