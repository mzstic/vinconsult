<?php
namespace VC\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use VC\WebBundle\Entity\HomeBox;

/**
 * @author Martin Patera <mzstic@gmail.com>
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('VCAdminBundle:Default:index.html.twig', []);
    }

	public function listAction()
	{
		$boxes = $this->getDoctrine()->getRepository('VCWebBundle:HomeBox')->findAll();

		return $this->render('VCAdminBundle:Default:list.html.twig', [
			'boxes' => $boxes
		]);
	}

	public function editAction(Request $request, $id)
	{
		if ($id !== 0) {
			$box = $this->getDoctrine()->getRepository('VCWebBundle:HomeBox')->findOneBy(['id' => $id]);
		} else {
			$box = new HomeBox();
		}

		$fb = $this->createFormBuilder($box);
		$fb->add('title', 'text', [
			'label' => 'Nadpis'
		]);
		$fb->add('subtitle', 'text', [
			'label' => 'Podnadpis'
		]);
		$fb->add('image', 'file', [
			'label' => 'Fotka',
			'required' => false,
			'mapped' => false
		]);

		$fb->add('save', 'submit', [
			'label' => 'Uložit',
			'attr' => ['class' => 'btn btn-success'],
		]);

		$form = $fb->getForm();
		$form->handleRequest($request);
		if ($form->isValid()) {

			$em = $this->getDoctrine()->getManager();
			if (! $box->getId()) {
				$em->persist($box);
				$em->flush();
			}
			/** @var UploadedFile $file */
			$file = $form['image']->getData();
			if ($file !== null) {
				$fileName = $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension();
				$photoFolder = __DIR__ . '/../../../../web/home';
				$file->move($photoFolder, $fileName);
				$box->setPhotoPath($fileName);
			}
			$em->persist($box);
			$em->flush();
			$this->addFlash('success', 'Data byla v pořádku uložena.');
			return $this->redirectToRoute('vc_admin_home_boxes');
		}

		return $this->render('VCAdminBundle:Default:edit.html.twig', [
			'form' => $form->createView(),
			'box' => $box
		]);
	}

}
