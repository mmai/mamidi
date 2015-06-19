<?php
/**
 * Created by IntelliJ IDEA.
 * User: henri
 * Date: 22/05/15
 * Time: 16:47
 */

namespace Mamidi\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class HostRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // add your custom field
        $builder
            ->add('firstname', null, array('label' => 'form.firstname', 'translation_domain' => 'MamidiUserBundle'))
            ->add('lastname', null, array('label' => 'form.lastname', 'translation_domain' => 'MamidiUserBundle'))
            ->add('address', null, array('label' => 'form.address', 'translation_domain' => 'MamidiUserBundle'))
            ->add('zip', null, array('label' => 'form.zip', 'translation_domain' => 'MamidiUserBundle'))
            ->add('city', null, array('label' => 'form.city', 'translation_domain' => 'MamidiUserBundle'))
            ->add('save', 'submit', array('label' => 'form.save', 'translation_domain' => 'MamidiUserBundle'))
        ;
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'mamidi_host_registration';
    }
}