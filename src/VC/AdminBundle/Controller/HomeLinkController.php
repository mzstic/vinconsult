<?php
namespace VC\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use VC\WebBundle\Entity\HomeLink;
use VC\WebBundle\Entity\News;
use VC\WebBundle\Entity\Reference;

/**
 * @author Martin Patera <mzstic@gmail.com>
 *
 */
class HomeLinkController extends Controller
{

	public function editLinksAction(Request $request)
	{
		/** @var Reference[] $references */
		$references = $this->getDoctrine()->getRepository('VCWebBundle:Reference')->findAll();
		/** @var News[] $news */
		$news = $this->getDoctrine()->getRepository('VCWebBundle:News')->findAll();
		/** @var HomeLink[] $homeLinks */
		$homeLinks = $this->getDoctrine()->getRepository('VCWebBundle:HomeLink')->findAll();

		$choices = [
			"news" => [],
			"references" => [],
		];
		foreach ($references as $reference) {
			$choices["references"]["reference-" . $reference->getId()] = $reference->getTitle();
		}

		foreach ($news as $new) {
			$choices["news"]["news-" . $new->getId()] = $new->getTitle();
		}


		$formBuilder = $this->createFormBuilder();

		foreach ($homeLinks as $homeLink) {
			$formBuilder->add(
				"reference-" . $homeLink->getId(),
				"choice",
				[
					"choices" => $choices
				]
			);
			$formBuilder->add(
				"news-" . $homeLink->getId(),
				"choice",
				[
					"choices" => $choices
				]
			);
		}


		$form = $formBuilder->getForm();

		return $this->render('VCAdminBundle:HomeLink:edit.html.twig', [
			'news' => $news,
			'references' => $references,
			'form' => $form->createView(),
		]);
	}
}
