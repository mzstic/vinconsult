<?php

namespace VC\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Photo
 *
 * @ORM\Table(name="photo")
 * @ORM\Entity
 */
class Photo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
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
     * @var Reference
     * @ORM\ManyToOne(targetEntity="Reference", inversedBy="photos")
     * @ORM\JoinColumn(name="reference_id", referencedColumnName="id")
     */
    private $reference;

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

    /**
     * @var string
     * @ORM\Column(name="thumb_path", type="string", length=255, nullable=true)
     */
    private $thumbPath;

    /**
     * @var UploadedFile
     */
    private $thumb;

    public function setThumbPath($path)
    {
        $this->thumbPath = $path;
    }

    public function getThumbWebPath()
    {
        return $this->path;
    }

    public function getWebPath()
    {
        return $this->path;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

	/**
	 * @param $description
	 * @return Photo
	 */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setOriginalName($name)
    {
        $this->originalName = $name;
        return $this;
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
     * @param \VC\WebBundle\Entity\Reference $reference
     * @return Photo
     */
    public function setReference(\VC\WebBundle\Entity\Reference $reference = null)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return \VC\WebBundle\Entity\Reference 
     */
    public function getReference()
    {
        return $this->reference;
    }
}
