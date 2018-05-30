<?php

namespace VC\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class StaticTextController
 * @author Martin Patera <mzstic@gmail.com>
 */
class StaticTextController extends Controller
{
	public function detailAction($name)
	{
		/** @var StaticTextManager $repository */
		$repository = $this->getDoctrine()->getRepository('VCWebBundle:StaticText');
		$text = $repository->findOneByUrl($name);

		if ($text === null) {
			$template = 'VCWebBundle:StaticText:missingText.html.twig';

			return $this->render($template, [
				'url' => $name
			]);
		}

		$template = 'VCWebBundle:StaticText:detail.html.twig';

		return $this->render($template, [
			'text' => $text
		]);
	}
}