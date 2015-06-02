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
            ->add('time')
            ->add('starter')
            ->add('maincourse')
            ->add('dessert')
            ->add('numberOfGuests')
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
