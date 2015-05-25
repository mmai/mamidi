<?php
/**
 * Created by IntelliJ IDEA.
 * User: henri
 * Date: 22/05/15
 * Time: 16:46
 */

namespace Mamidi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GuestRegistrationController extends Controller
{
    public function registerAction()
    {
        return $this->container
            ->get('pugx_multi_user.registration_manager')
            ->register('Mamidi\UserBundle\Entity\GuestUser');
    }
}
