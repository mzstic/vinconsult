<?php
namespace VC\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author Martin Patera <mzstic@gmail.com>
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
		$homeBoxes = $this->getDoctrine()->getRepository('VCWebBundle:HomeBox')->findAll();
        return $this->render('VCWebBundle:Default:index.html.twig', [
			'homeBoxes' => $homeBoxes,
		]);
    }

    public function mainMenuAction()
    {
        return $this->render('VCWebBundle:Default:mainMenu.html.twig', []);
    }

	public function newsAction($id)
	{
		$new = $this->getDoctrine()->getRepository('VCWebBundle:News')->findOneBy(['id' => $id]);
		if (! $new) {
			return $this->createNotFoundException('Tato novinka bohužel neexistuje');
		}
		return $this->render('VCWebBundle:Default:news.html.twig', [
			'new' => $new
		]);
	}

	public function aboutUsAction()
	{
		return $this->render('VCWebBundle:Default:aboutUs.html.twig', []);
	}

	public function contactAction()
	{
		return $this->render('VCWebBundle:Default:contact.html.twig', []);
	}

	public function careerAction()
	{
		return $this->render('VCWebBundle:Default:career.html.twig', []);
	}

	public function historyAction()
	{
		return $this->render('VCWebBundle:Default:history.html.twig', []);
	}

	public function bimAction()
	{
		return $this->render('VCWebBundle:Default:bim.html.twig', []);
	}

}
