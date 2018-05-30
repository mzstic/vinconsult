<?php

namespace VC\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class HomeBox
 * @author Martin Patera <mzstic@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="home_box")
 */
class HomeBox
{

	const TARGET_REFERENCE = 'reference';

	const TARGET_TEXT = 'text';

	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=100)
	 */
	private $title;

	/**
	 * @var string
	 * @ORM\Column(type="text")
	 */
	private $subtitle;

	/**
	 * @var UploadedFile
	 */
	private $photo;

	/**
	 * @var string
	 * @ORM\Column(type="string", name="photo_path", length=255, nullable=true)
	 */
	private $photoPath;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return HomeBox
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

	/**
	 * @return string
	 */
	public function getSubtitle()
	{
		return $this->subtitle;
	}

	/**
	 * @param string $subtitle
	 * @return self
	 */
	public function setSubtitle($subtitle)
	{
		$this->subtitle = $subtitle;
		return $this;
	}

    /**
     * Set photoPath
     *
     * @param string $photoPath
     * @return HomeBox
     */
    public function setPhotoPath($photoPath)
    {
        $this->photoPath = $photoPath;

        return $this;
    }

    /**
     * Get photoPath
     *
     * @return string 
     */
    public function getPhotoPath()
    {
        return $this->photoPath;
    }

	public function getPhotoWebPath()
	{
		return 'home/' . $this->getPhotoPath();
	}

}
