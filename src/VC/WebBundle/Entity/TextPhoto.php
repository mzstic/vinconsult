<?php

namespace VC\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TextPhoto
 * @author Martin Patera <mzstic@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="text_photo")
 */
class TextPhoto
{
	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $path;

	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 */
	private $sort;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	private $description;

	/**
	 * @var StaticText
	 * @ORM\ManyToOne(targetEntity="StaticText", inversedBy="photos")
	 */
	private $text;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	private $originalName;



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
     * @return TextPhoto
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

	public function getWebPath()
	{
		return 'texts/' . $this->getPath();
	}

    /**
     * Set sort
     *
     * @param integer $sort
     * @return TextPhoto
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
     * Set text
     *
     * @param string $text
     * @return TextPhoto
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set originalName
     *
     * @param string $originalName
     * @return TextPhoto
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;

        return $this;
    }

    /**
     * Get originalName
     *
     * @return string 
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return TextPhoto
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}
