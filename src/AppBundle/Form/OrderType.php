<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderType extends AbstractType
{
    /** * @param FormBuilderInterface $builder * @param array $options */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('customer')->add(
            'productLines',
            new OrderProductLineEmbeddableType(),
            array(
                'title' => 'products',
                'route' => 'productsale_search_by_code',
                'columns' => array('code', 'title', 'price', 'quantity'),
                'search' => 'code'
            )
        );
    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\Order'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_order';
    }
}
