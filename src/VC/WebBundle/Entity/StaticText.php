<?php

namespace VC\WebBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Text
 *
 * @ORM\Table(name="static_text")
 * @ORM\Entity
 */
class StaticText
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
	 * @ORM\Column(name="title", type="string", length=255)
	 */
	private $title;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="url", type="string", length=255)
	 */
	private $url;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="text", type="text")
	 */
	private $text;

	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="TextPhoto", mappedBy="text", cascade={"remove"})
	 * @ORM\OrderBy({"sort" = "ASC"})
	 */
	private $photos;


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
	 * @return Text
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
	 * Set url
	 *
	 * @param string $url
	 * @return Text
	 */
	public function setUrl($url)
	{
		$this->url = $url;

		return $this;
	}

	/**
	 * Get url
	 *
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * Set text
	 *
	 * @param string $text
	 * @return Text
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
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add photos
     *
     * @param \VC\WebBundle\Entity\TextPhoto $photos
     * @return StaticText
     */
    public function addPhoto(\VC\WebBundle\Entity\TextPhoto $photos)
    {
        $this->photos[] = $photos;

        return $this;
    }

    /**
     * Remove photos
     *
     * @param \VC\WebBundle\Entity\TextPhoto $photos
     */
    public function removePhoto(\VC\WebBundle\Entity\TextPhoto $photos)
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
}
