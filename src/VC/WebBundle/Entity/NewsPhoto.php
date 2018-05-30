<?php

namespace VC\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Photo
 *
 * @ORM\Table(name="news_photo")
 * @ORM\Entity
 */
class NewsPhoto
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\ID
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="path", type="string", length=255, nullable=true)
	 */
	private $path;

	/**
	 * @var UploadedFile
	 */
	private $photo;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="sort", type="smallint")
	 */
	private $sort;

	/**
	 * @var News
	 * @ORM\ManyToOne(targetEntity="News", inversedBy="photos")
	 * @ORM\JoinColumn(name="news_id", referencedColumnName="id")
	 */
	private $new;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	private $description;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	private $originalName;

	public function getWebPath()
	{
		return 'news/' . $this->path;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function setOriginalName($name)
	{
		$this->originalName = $name;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getOriginalName()
	{
		return $this->originalName;
	}

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
	 * Set path
	 *
	 * @param string $path
	 * @return Photo
	 */
	public function setPath($path)
	{
		$this->path = $path;

		return $this;
	}

	/**
	 * Get path
	 *
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * Set sort
	 *
	 * @param integer $sort
	 * @return Photo
	 */
	public function setSort($sort)
	{
		$this->sort = $sort;

		return $this;
	}

	/**
	 * Get sort
	 *
	 * @return integer
	 */
	public function getSort()
	{
		return $this->sort;
	}

	/**
	 * Set reference
	 *
	 * @param \VC\WebBundle\Entity\News $new
	 * @return Photo
	 */
	public function setNew(\VC\WebBundle\Entity\News $new = null)
	{
		$this->new = $new;

		return $this;
	}

	/**
	 * Get reference
	 *
	 * @return \VC\WebBundle\Entity\News
	 */
	public function getNew()
	{
		return $this->new;
	}
}
