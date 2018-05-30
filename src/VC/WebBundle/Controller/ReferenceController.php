<?php
namespace VC\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ReferenceController
 * @author Martin Patera <mzstic@gmail.com>
 */
class ReferenceController extends Controller
{

    public function listAction(Request $request, $categoryUrl)
    {
        $session = $request->getSession();

        $sortByQuery = $request->query->get('sort');
        $displayQuery = $request->query->get('display');

	    $selectedYear = $request->get("year");
	    $selectedCountry = $request->get("country");

        if ($sortByQuery !== null) {
            if ($sortByQuery == 'year') {
	            $session->set('sortBy', 'year');
            } elseif ($sortByQuery == 'default') {
	            $session->set('sortBy', 'default');
            } else {
                $session->set('sortBy', 'name');
            }
        }

        if ($displayQuery !== null) {
            if ($displayQuery == 'list') {
                $session->set('display', 'list');
            } else {
                $session->set('display', 'grid');
            }
        }
        if ($displayQuery !== null || $sortByQuery !== null) {
            return $this->redirectToRoute(
            	'vc_web_references',
	            [
            	    'categoryUrl' => $categoryUrl,
		            'year' => $selectedYear,
		            'country' => $selectedCountry
                ]
            );
        }
        $sortBy = $session->get('sortBy', 'default');
        $display = $session->get('display', 'grid');

	    $categories = $this->getDoctrine()->getRepository('VCWebBundle:Category')->findAll();
        $repository = $this->getDoctrine()->getRepository('VCWebBundle:Reference');
        if ($categoryUrl !== null) {
	        $category = $this->getDoctrine()->getRepository('VCWebBundle:Category')->findOneBy(['url' => $categoryUrl]);
        } else {
	        $category = null;
        }


        $references = $repository->getReferencesByCategory(
            $category,
            $selectedYear,
            $selectedCountry,
            $sortBy,
            $display
        );

	    $years = $repository->getYears();
	    $countries = $repository->getCountries();
	    $selectedCategoryUrl = $category ? $category->getUrl() : null;

        return $this->render('VCWebBundle:Reference:list.html.twig', [
            'references' => $references,
            'categories' => $categories,
            'countries' => $countries,
            'years' => $years,
            'display' => $display,
	        'selectedYear' => $selectedYear,
	        'selectedCountry' => $selectedCountry,
	        'selectedCategoryUrl' => $selectedCategoryUrl
        ]);

    }

    public function detailAction($referenceId)
    {
        $reference = $this->getDoctrine()->getRepository('VCWebBundle:Reference')->find($referenceId);
        $categories = $this->getDoctrine()->getRepository('VCWebBundle:Category')->findAll();

        if (! $reference) {
            return $this->createNotFoundException("Reference s tímto ID neexistuje.");
        }

        return $this->render('VCWebBundle:Reference:detail.html.twig', [
            'reference' => $reference,
            'categories' => $categories
        ]);
    }
}