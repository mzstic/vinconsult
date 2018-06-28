<?php
namespace VC\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VC\WebBundle\Entity\StaticText;
use VC\WebBundle\Entity\TextPhoto;

/**
 * @author Martin Patera <mzstic@gmail.com>
 */
class StaticTextController extends Controller
{
	public function adminAction()
	{

		$texts = $this->getDoctrine()
			->getRepository('VCWebBundle:StaticText')
			->findAll();

		$data = [
			'texts' => $texts,
		];

		return $this->render('VCAdminBundle:StaticText:admin.html.twig', $data);
	}

	public function editAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$text = $em->getRepository('VCWebBundle:StaticText')->find($id);
		if ($text === null) {
			$text = new StaticText();
		}

		$form = $this->createFormBuilder($text)
			->add('url', 'text')
			->add('title', 'text')
			->add('text', 'textarea', ['required' => false, 'attr' => ['class'=>'rich']])
			->add('save', 'submit', ['label' => 'Uložit text', 'attr' => ['class' => 'btn btn-success'],])
			->getForm();

		$form->handleRequest($request);

		if ($form->isValid()) {
			$em->persist($text);

			$em->flush();
			return $this->redirect($this->generateUrl('vc_admin_static_text_list'));
		}
		return $this->render('VCAdminBundle:StaticText:edit.html.twig', [
			'form' => $form->createView(),
			'text' => $text,
		]);
	}


	public function photosAction(Request $request, $id)
	{
		$repository = $this->getDoctrine()->getRepository('VCWebBundle:StaticText');
		$text = $repository->findOneBy(['id' => $id]);

		$formData = [];
		foreach ($text->getPhotos() as $photo) {
			$formData['photo' . $photo->getId()] = $photo->getDescription();
		}

		$builder = $this->createFormBuilder($formData)
			->add('sort', 'hidden')
			->add('delete', 'hidden')
			->add('savePhotos', 'submit', ['label' => 'Uložit změny', 'attr' => ['class' => 'btn btn-success'],]);

		foreach ($text->getPhotos() as $photo) {
			$builder->add('photo' . $photo->getId(), 'text');
		}

		$form = $builder->getForm();

		$form->handleRequest($request);
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$photoRepository = $this->getDoctrine()->getRepository('VCWebBundle:TextPhoto');
			$data = $form->getData();

			$sortIds = explode(',', $data['sort']);
			$sort = 0;
			foreach ($sortIds as $id) {
				$photo = $photoRepository->findOneBy(['id' => $id]);
				$photo->setSort($sort++);

				$photo->setDescription($data['photo'.$id]);

				$em->persist($photo);
				$em->flush();
			}

			if ($data['delete'] !== null) {
				$deleteIds = explode(',', $data['delete']);
				foreach ($deleteIds as $id) {
					$photo = $photoRepository->findOneBy(['id' => $id]);

					$em->remove($photo);
					$em->flush();
				}

				if (count($deleteIds) > 0) {
					$this->addFlash('success', count($deleteIds) . ' fotek bylo smazáno');
				}
			}
			$this->addFlash('success', 'Pořadí fotek bylo uloženo');

			return $this->redirectToRoute('vc_admin_static_text_photos', ['id' => $id]);
		}

		return $this->render('VCAdminBundle:StaticText:photos.html.twig', [
			'text' => $text,
			'form' => $form->createView()

		]);
	}

	public function uploadAction(Request $request, $id)
	{
		$repository = $this->getDoctrine()->getRepository('VCWebBundle:StaticText');
		$text = $repository->findOneBy(['id' => $id]);

		if ($request->isXmlHttpRequest()) {
			/** @var UploadedFile $file */
			$file = $request->files->get('file');
			$em = $this->getDoctrine()->getManager();


			$photo = new TextPhoto();
			$photo->setText($text);
			$photo->setOriginalName($file->getClientOriginalName());
			$photo->setDescription($file->getClientOriginalName());
			$photo->setSort($text->getPhotos()->count());
			$em->persist($photo);
			$em->flush();

			$fileName = $id . '_' . $photo->getId() . '.' . $file->getClientOriginalExtension();

			$photoFolder = __DIR__ . '/../../../../web/texts';

			$file->move($photoFolder, $fileName);

			$photo->setPath($fileName);
			$em->persist($photo);
			$em->flush();
			exit;
		}

		return $this->render('VCAdminBundle:StaticText:upload.html.twig', [
			'text' => $text
		]);
	}
}