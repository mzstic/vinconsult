<?php

namespace VC\AdminBundle\Controller;
use Ddeboer\DataImport\Reader\CsvReader;
use Ddeboer\DataImport\Writer\CsvWriter;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\Date;
use VC\AdminBundle\Form\Type\ReferenceFormType;
use VC\WebBundle\Entity\Category;
use VC\WebBundle\Entity\Photo;
use VC\WebBundle\Entity\Reference;
use VC\WebBundle\VCWebBundle;


/**
 * Class ReferenceController
 * @author Martin Patera <mzstic@gmail.com>
 */
class ReferenceController extends Controller
{

    public function listAction()
    {
        $repository = $this->getDoctrine()->getRepository('VCWebBundle:Reference');
        $references = $repository->createQueryBuilder('r')->where('r.category IS NOT NULL')->getQuery()->getResult();

        return $this->render('VCAdminBundle:Reference:list.html.twig', [
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

        $form->handleRequest($request);
        if ($form->isValid()) {
	        // @TODO ulozit!!!

            return $this->redirectToRoute('vc_admin_reference_edit', ['referenceId' => $referenceId]);
        }

        return $this->render('VCAdminBundle:Reference:edit.html.twig', [
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
            $this->addFlash('success', 'Pořadí fotek bylo uloženo');

            return $this->redirectToRoute('vc_admin_reference_photos', ['referenceId' => $referenceId]);
        }

        return $this->render('VCAdminBundle:Reference:photos.html.twig', [
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

            $photoFolder = __DIR__ . '/../../../../web/projekty/uploaded';

            $file->move($photoFolder, $fileName);

            $photo->setPath('projekty/uploaded/' . $fileName);
            $photo->setThumbPath('projekty/uploaded/' . $fileName);
            $em->persist($photo);
            $em->flush();
        }

        return $this->render('VCAdminBundle:Reference:upload.html.twig', [
            'reference' => $reference
        ]);
    }

    public function importAction(Request $request)
    {

        $form = $this->createFormBuilder([])
            ->add('file', 'file', ['label' => 'CSV Soubor'])
            ->add('import', 'submit', ['label' => 'Importovat'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->export();

            $data = $form->getData();
            /** @var UploadedFile $file */
            $file = $data['file'];

            $em = $this->getDoctrine()->getManager();
            $refMetadata = $em->getClassMetadata('\VC\WebBundle\Entity\Reference');
            $refMetadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            $refMetadata->setIdGenerator(new AssignedGenerator());
            $photoMetadata = $em->getClassMetadata('\VC\WebBundle\Entity\Photo');
            $photoMetadata->setIdGenerator(new AssignedGenerator());
            $categoryRepository = $this->getDoctrine()->getRepository('VCWebBundle:Category');

            $referenceRepository = $this->getDoctrine()->getRepository('VCWebBundle:Reference');

            $refCount = 0;
            $photoCount = 0;
            $categories = [];
            $existingIds = [];

	        $handle = fopen($file->getPathname(), "r");


            while ($row = fgetcsv($handle, 0, ",", '"')) {
            	if ($row[0] == "ID" || $row[0] === "Název" || empty($row[0])) {
            		// skip header row
            		continue;
	            }

                /** @var Reference $reference */
                $title = $row[0];
                $reference = $referenceRepository->findOneBy(['title' => $title]);

                if ($reference === null) {
                    $reference = new Reference();
                }
                $reference->setTitle($row[0]);
                $reference->setBuilding($row[1]);

                $reference->setCountry($row[2]);
                $reference->setCity($row[3]);

                $reference->setInvestor($row[4]);
                $reference->setPerformances($row[6]);
                $reference->setRealization($row[7]);
                $reference->setInvestment($row[8]);

				$reference->setYear($row[10]);

                if (isset($categories[$row[13]])) {
                    $category = $categories[$row[13]];
                } else {
                    $category = $categoryRepository->findOneBy(['csvIdent' => $row[13]]);
                    if ($category === NULL) {

                        $category = new Category();
                        $category->setTitle($row[13]);
                        $category->setUrl($row[13]);
	                    $category->setCsvIdent($row[13]);
                        $em->persist($category);
                        $categories[$row[13]] = $category;
                    }
                }

                $reference->setCategory($category);

                $reference->setImportant($row[14] === '1');
                $reference->setPublish(true);

                $sort = $reference->getPhotos()->count();
                if ($row[15] !== '-') {
	                $finder = new Finder();
	                $directoryExists = true;
	                try {
		                $finder->in("projekty/" . $row[13] . "/" . $row[15]);
	                } catch (\Exception $e) {
	                    $directoryExists = false;
	                }

	                if ($directoryExists) {
		                $finder->name("*.jpg");

		                foreach ($finder as $file) {
			                foreach ($reference->getPhotos() as $existingPhoto) {
				                if ($existingPhoto->getOriginalName() == $file->getFilename()) {
					                continue 2;
				                }
			                }
			                $sort = intval(substr($file->getFilename(), 0, 2));

			                $photo = new Photo();
			                $photo->setSort($sort)
				                ->setPath($file->getPathname())
				                ->setDescription($file->getFilename())
				                ->setOriginalName($file->getFilename());
			                $photo->setReference($reference);
			                $em->persist($photo);
			                $sort++;
		                }
	                }

                }

                $em->persist($reference);
				$em->flush();


	            $existingIds[] = $reference->getId();
            }
            $em->flush();
            $deleteRefs = $referenceRepository->getComplement($existingIds);
            foreach ($deleteRefs as $ref) {
                $em->remove($ref);
            }
            $em->flush();

            $this->addFlash('success', "Bylo naimportováno " . $refCount . " referencí.");
            return $this->redirectToRoute('vc_admin_reference_list');
        }

        return $this->render('VCAdminBundle:Reference:import.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function exportAction()
    {
        $file = $this->export();
        return $this->redirectToRoute('vc_admin_reference_export_list');
    }

    public function exportListAction()
    {
        $files = glob('exports/*');
        return $this->render('@VCAdmin/Reference/exportList.html.twig', [
            'files' => $files
        ]);
    }

	public function pdfAction()
	{
		$references = $this->getDoctrine()->getRepository('VCWebBundle:Reference')->getReferences('building');
		$html = $this->render('VCAdminBundle:Reference:pdf.html.twig', [
			'references' => $references
		]);
		$html = iconv('utf-8', 'utf-8', $html);

		$mpdfService = $this->get('tfox.mpdfport');
		$mpdfService->setAddDefaultConstructorArgs(false);
		$response = $mpdfService->generatePdfResponse($html, [
			'constructorArgs' => [
				'utf-8',
				'A4-L',
			]
		]);
		return $response;
	}


    private function export()
    {
        $references = $this->getDoctrine()->getRepository('VCWebBundle:Reference')->getReferences();
        $writer = new CsvWriter();

        $filename = 'exports/vinconsult_export_'.date('Y_m_d__H_i').'.csv';
        $writer->setStream(fopen($filename, 'w'));

        $writer->writeItem([
            'ID',
            'Název',
            'Stavba',
            'Země',
            'Město',
            'Investor',
            'Klient',
            'Rozsah služby',
            'Realizace',
            'Stavební náklady',
            'Popis',
            'Rok',
            'Č.zak.',
            'HIP',
            'Menu',
            'VR',
        ]);
        foreach ($references as $reference) {
        	/** @var Reference $reference */
            $writer->writeItem([
                $reference->getId(),
                $reference->getTitle(),
                $reference->getBuilding(),
                $reference->getInvestor(),
                $reference->getClient(),
                $reference->getPerformances(),
                $reference->getRealization(),
                $reference->getInvestment(),
                $reference->getDescription(),
                $reference->getYear(),
                $reference->getCommissionNumber(),
                $reference->getHip(),
                $reference->getCategory()->getUrl(),
                $reference->isImportant() ? '1' : ''
            ]);
        }
        $writer->finish();
        return $filename;
    }

    private function urlExists($url)
    {
        $headers = @get_headers($url);
        if ($headers[0] == 'HTTP/1.1 404 Not Found') {
            return false;
        }
        return true;
    }

}