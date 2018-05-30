<?php

namespace VC\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class MainMenuController
 * @author Martin Patera <mzstic@gmail.com>
 */
class MainMenuController extends Controller
{

	public function listAction()
	{
		$repository = $this->getDoctrine()->getRepository('VCWebBundle:MainMenu');
		$menuItems = $repository->findAll();

		return $this->render('VCAdminBundle:MainMenu:list.html.twig', [
			'menuItems' => $menuItems
		]);
	}

	public function editAction(Request $request, $id)
	{
		$repository = $this->getDoctrine()->getRepository('VCWebBundle:MainMenu');
		$menuItem = $repository->findOneBy(['id' => $id]);

		$fb = $this->createFormBuilder($menuItem);
		$fb->add('title', 'text', [
			'label' => 'text'
		]);

		$fb->add('save', 'submit', [
			'label' => 'uložit'
		]);

		$form = $fb->getForm();
		$form->handleRequest($request);
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($menuItem);
			$em->flush();
			$this->addFlash('success', 'Položka hlavního menu byla změněna.');
			return $this->redirectToRoute('vc_admin_mainmenu_list');
		}

		return $this->render('VCAdminBundle:MainMenu:edit.html.twig', [
			'form' => $form->createView()
		]);
	}
}