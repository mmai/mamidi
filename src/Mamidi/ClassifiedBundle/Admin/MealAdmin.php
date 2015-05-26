<?php
/**
 * Created by IntelliJ IDEA.
 * User: henri
 * Date: 25/05/15
 * Time: 17:52
 */

namespace Mamidi\ClassifiedBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MealAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('time', 'datetime', array('label' => 'Date'))
            ->add('host', 'entity', array('class' => 'Mamidi\UserBundle\Entity\HostUser'))
            ->add('starter')
            ->add('maincourse')
            ->add('dessert')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('host')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('time')
            ->add('host')
            ->add('maincourse')
        ;
    }
}