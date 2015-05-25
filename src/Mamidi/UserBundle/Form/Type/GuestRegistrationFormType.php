<?php
/**
 * Created by IntelliJ IDEA.
 * User: henri
 * Date: 22/05/15
 * Time: 16:18
 */

namespace Mamidi\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GuestRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // add your custom field
        $builder->add('phone', null, array('label' => 'form.phone', 'translation_domain' => 'MamidiUserBundle'));
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'mamidi_guest_registration';
    }
}
