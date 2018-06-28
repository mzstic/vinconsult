<?php
namespace VC\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author Martin Patera <mzstic@gmail.com>
 */
class NewsController extends Controller
{

	public function listAction()
	{
		$news = $this->getDoctrine()->getRepository('VCWebBundle:News')->findAll();
		return $this->render('VCWebBundle:News:list.html.twig', [
			'news' => $news,
		]);
	}

	public function detailAction($id)
	{
		$newItem = $this->getDoctrine()->getRepository('VCWebBundle:News')->findOneBy(['id' => $id]);
		if (!$newItem) {
			return $this->createNotFoundException('Tato novinka bohužel neexistuje');
		}
		return $this->render(
			'VCWebBundle:News:detail.html.twig',
			[
				'newItem' => $newItem,
			]
		);
	}
}
