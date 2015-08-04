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
                'dp_use_current'        => true,
                'dp_use_seconds'        => false,
                'dp_language'           => 'fr',
                'format' => "YYYY-MM-DD H:m"
            ))
            ->add('starter', 'text', array('label' => 'Entrée'))
            ->add('maincourse', 'text', array('label' => 'Plat'))
            ->add('dessert', 'text', array('label' => 'Dessert'))
            ->add('formula_starter_maincourse', 'checkbox', array('label' => 'Entrée + plat', 'required' => false))
            ->add('formula_maincourse', 'checkbox', array('label' => 'Plat', 'required' => false))
            ->add('formula_maincourse_dessert', 'checkbox', array('label' => 'Plat + dessert', 'required' => false))
            ->add('formula_complete', 'checkbox', array('label' => 'Entrée + plat + dessert', 'required' => false))
            ->add('numberOfGuests', 'choice', array(
                'choices' => array(1 =>1, 2 =>2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10),
                'label' => "Nombre de convives"))
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
