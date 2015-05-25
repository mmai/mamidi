<?php
/**
 * Created by IntelliJ IDEA.
 * User: henri
 * Date: 22/05/15
 * Time: 16:47
 */

namespace Mamidi\UserBundle\Form\Type;


class HostRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // add your custom field
        $builder->add('address');
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