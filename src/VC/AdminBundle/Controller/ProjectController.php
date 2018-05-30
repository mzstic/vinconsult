<?php

namespace VC\AdminBundle\Controller;

use Ddeboer\DataImport\Reader\CsvReader;
use Doctrine\ORM\Id\AssignedGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use VC\AdminBundle\Form\Type\ReferenceFormType;
use VC\WebBundle\Entity\Category;
use VC\WebBundle\Entity\Photo;
use VC\WebBundle\Entity\Reference;

/**
 * Class ProjectController
 * @author Martin Patera <mzstic@gmail.com>
 */
class ProjectController extends Controller
{

    public function listAction()
    {
        $repository = $this->getDoctrine()->getRepository('VCWebBundle:Reference');
        $references = $repository->findBy([
            'category' => null
        ]);

        return $this->render('VCAdminBundle:Project:list.html.twig', [
            'references' => $references
        ]);

    }

    public function editAction(Request $request, $referenceId)
    {
        $repository = $this->getDoctrine()->getRepository('VCWebBundle:Reference');
        $reference = $repository->findOneBy(['id' => $referenceId]);
        if ($reference === null) {
            $reference = new Reference();
        }

        $form = $this->createForm(new ReferenceFormType(), $reference);
        $form->remove('category');
        $form->remove('important');
        $form->remove('hip');
        $form->remove('commission_number');


        $form->handleRequest($request);
        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($reference);
            $em->flush();

            return $this->redirectToRoute('vc_admin_project_edit', ['referenceId' => $referenceId]);
        }

        return $this->render('VCAdminBundle:Project:edit.html.twig', [
            'reference' => $reference,
            'form' => $form->createView()
        ]);
    }

    public function photosAction(Request $request, $referenceId)
    {
        $repository = $this->getDoctrine()->getRepository('VCWebBundle:Reference');
        $reference = $repository->findOneBy(['id' => $referenceId]);

        $formData = [];
        foreach ($reference->getPhotos() as $photo) {
            $formData['photo' . $photo->getId()] = $photo->getDescription();
        }

        $builder = $this->createFormBuilder($formData)
            ->add('sort', 'hidden')
            ->add('delete', 'hidden')
            ->add('savePhotos', 'submit', ['label' => 'Uložit změny']);

        foreach ($reference->getPhotos() as $photo) {
            $builder->add('photo' . $photo->getId(), 'text');
        }

        $form = $builder->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $photoRepository = $this->getDoctrine()->getRepository('VCWebBundle:Photo');
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
            $this->addFlash('success', 'Pořadí fotek bylo uloženo fotek bylo smazáno');

            return $this->redirectToRoute('vc_admin_project_photos', ['referenceId' => $referenceId]);
        }

        return $this->render('VCAdminBundle:Project:photos.html.twig', [
            'reference' => $reference,
            'form' => $form->createView()

        ]);
    }

    public function uploadAction(Request $request, $referenceId)
    {
        $repository = $this->getDoctrine()->getRepository('VCWebBundle:Reference');
        $reference = $repository->findOneBy(['id' => $referenceId]);

        if ($request->isXmlHttpRequest()) {
            /** @var UploadedFile $file */
            $file = $request->files->get('file');
            $em = $this->getDoctrine()->getManager();


            $photo = new Photo();
            $photo->setReference($reference);
            $photo->setOriginalName($file->getClientOriginalName());
            $photo->setDescription($file->getClientOriginalName());
            $photo->setSort($reference->getPhotos()->count());
            $em->persist($photo);
            $em->flush();

            $fileName = $referenceId . '_' . $photo->getId() . '.' . $file->getClientOriginalExtension();

            $photoFolder = __DIR__ . '/../../../../web/reference';

            $file->move($photoFolder, $fileName);

            $photo->setPath($fileName);
            $photo->setThumbPath($fileName);
            $em->persist($photo);
            $em->flush();

            dump($fileName);

            exit;
        }

        return $this->render('VCAdminBundle:Project:upload.html.twig', [
            'reference' => $reference
        ]);
    }



}