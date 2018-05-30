<?php

namespace VC\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VC\WebBundle\Entity\News;
use VC\WebBundle\Entity\NewsPhoto;


/**
 * Class NewsController
 * @author Martin Patera <mzstic@gmail.com>
 */
class NewsController extends Controller
{
	public function listAction()
	{
		$news = $this->getDoctrine()->getRepository('VCWebBundle:News')->getLatestNews()->getQuery()->getResult();


		return $this->render('@VCAdmin/News/list.html.twig', [
			'news' => $news
		]);
	}

	public function editAction(Request $request, $id)
	{
		$newsRepository = $this->getDoctrine()->getRepository('VCWebBundle:News');
		if ($id == 0) {
			$new = new News();
		} else {
			$new = $newsRepository->findOneBy(['id' => $id]);
		}

		$fb = $this->createFormBuilder($new);
		$fb->add('title', 'text', [
			'label' => 'Titulek'
		]);

		$fb->add('date', 'date', [
			'label' => 'Datum'
		]);

		$fb->add('annotation', 'textarea', [
			'label' => 'Anotace (200 zn.)',
			'required' => false
		]);

		$fb->add('text', 'textarea', [
			'label' => 'Text',
			'required' => false,
			'attr' => [
				'class' => 'rich'
			]
		]);

		$fb->add('save', 'submit', [
			'label' => 'Uložit'
		]);

		$form = $fb->getForm();
		$form->handleRequest($request);
		if ($form->isValid()) {

			$em = $this->getDoctrine()->getManager();
			$em->persist($new);
			$em->flush();
			$this->addFlash('success', 'Aktualita byla vpořádku uložena.');
			return $this->redirectToRoute('vc_admin_news_list');
		}

		return $this->render('@VCAdmin/News/edit.html.twig', [
			'form' => $form->createView(),
			'new' => $new
		]);
	}

	public function photosAction(Request $request, $newsId)
	{
		$repository = $this->getDoctrine()->getRepository('VCWebBundle:News');
		$new = $repository->findOneBy(['id' => $newsId]);

		$formData = [];
		foreach ($new->getPhotos() as $photo) {
			$formData['photo' . $photo->getId()] = $photo->getDescription();
		}

		$builder = $this->createFormBuilder($formData)
			->add('sort', 'hidden')
			->add('delete', 'hidden')
			->add('savePhotos', 'submit', ['label' => 'Uložit změny']);

		foreach ($new->getPhotos() as $photo) {
			$builder->add('photo' . $photo->getId(), 'text');
		}

		$form = $builder->getForm();

		$form->handleRequest($request);
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$photoRepository = $this->getDoctrine()->getRepository('VCWebBundle:NewsPhoto');
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

			return $this->redirectToRoute('vc_admin_news_photos', ['newsId' => $newsId]);
		}

		return $this->render('VCAdminBundle:News:photos.html.twig', [
			'new' => $new,
			'form' => $form->createView()

		]);
	}

	public function uploadAction(Request $request, $newsId)
	{
		$repository = $this->getDoctrine()->getRepository('VCWebBundle:News');
		$new = $repository->findOneBy(['id' => $newsId]);

		if ($request->isXmlHttpRequest()) {
			/** @var UploadedFile $file */
			$file = $request->files->get('file');
			$em = $this->getDoctrine()->getManager();


			$photo = new NewsPhoto();
			$photo->setNew($new);
			$photo->setOriginalName($file->getClientOriginalName());
			$photo->setDescription($file->getClientOriginalName());
			$photo->setSort($new->getPhotos()->count());
			$em->persist($photo);
			$em->flush();

			$fileName = $newsId . '_' . $photo->getId() . '.' . $file->getClientOriginalExtension();

			$photoFolder = __DIR__ . '/../../../../web/news';

			$file->move($photoFolder, $fileName);

			$photo->setPath($fileName);
			$em->persist($photo);
			$em->flush();
			exit;
		}

		return $this->render('VCAdminBundle:News:upload.html.twig', [
			'new' => $new
		]);
	}
}