<?php

namespace VC\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class SecurityController
 * @author Martin Patera <mzstic@gmail.com>
 */
class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('VCAdminBundle:Security:login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);

    }

    public function loginCheckAction()
    {
        echo "XX";exit;
    }
}