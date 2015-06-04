<?php

namespace Mamidi\ClassifiedBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MealType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('time', 'sonata_type_datetime_picker', array(
                'label' => "Date",
                'dp_side_by_side'       => true,
                'dp_use_current'        => false,
                'dp_use_seconds'        => false,
                'format' => "YYYY-MM-DD H:m"
            ))
            ->add('starter', 'text', array('label' => 'Entrée'))
            ->add('maincourse', 'text', array('label' => 'Plat'))
            ->add('dessert', 'text', array('label' => 'Dessert'))
            ->add('numberOfGuests', 'integer', array('label' => "Nombre de convives"))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mamidi\ClassifiedBundle\Entity\Meal'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mamidi_classifiedbundle_meal';
    }
}
