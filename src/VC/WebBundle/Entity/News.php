<?php

namespace VC\WebBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class News
 * @author Martin Patera <mzstic@gmail.com>
 *
 * @ORM\Entity(repositoryClass="NewsRepository")
 * @ORM\Table(name="news")
 */
class News
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
	 * @ORM\Column(type="string", length=100)
	 */
	private $title;

	/**
	 * @var string
	 * @ORM\Column(type="text")
	 */
	private $annotation;

	/**
	 * @var string
	 * @ORM\Column(type="text")
	 */
	private $text;

	/**
	 * @ORM\OneToMany(targetEntity="NewsPhoto", mappedBy="new", cascade={"remove"})
	 * @ORM\OrderBy({"sort" = "ASC"})
	 * @var ArrayCollection
	 */
	private $photos;

	/**
	 * @var DateTime
	 * @ORM\Column(type="date")
	 */
	private $date;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return News
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
     * Set annotation
     *
     * @param string $annotation
     * @return News
     */
    public function setAnnotation($annotation)
    {
        $this->annotation = $annotation;

        return $this;
    }

    /**
     * Get annotation
     *
     * @return string 
     */
    public function getAnnotation()
    {
        return $this->annotation;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return News
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
     * Add photos
     *
     * @param \VC\WebBundle\Entity\NewsPhoto $photos
     * @return News
     */
    public function addPhoto(\VC\WebBundle\Entity\NewsPhoto $photos)
    {
        $this->photos[] = $photos;

        return $this;
    }

    /**
     * Remove photos
     *
     * @param \VC\WebBundle\Entity\NewsPhoto $photos
     */
    public function removePhoto(\VC\WebBundle\Entity\NewsPhoto $photos)
    {
        $this->photos->removeElement($photos);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return News
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
}
