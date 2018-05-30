<?php

namespace VC\WebBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="VC\WebBundle\Entity\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="title", type="string", length=50)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=50)
     */
    private $url;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="csv_ident", type="string", length=50)
	 */
	private $csvIdent;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Reference", mappedBy="category")
     */
    private $references;

    public function __construct()
    {
        $this->references = new ArrayCollection();
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
     * @return Category
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
     * @return Category
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
     * Add references
     *
     * @param Reference $references
     * @return Category
     */
    public function addReference(Reference $references)
    {
        $this->references[] = $references;

        return $this;
    }

    /**
     * Remove references
     *
     * @param Reference $references
     */
    public function removeReference(Reference $references)
    {
        $this->references->removeElement($references);
    }

    /**
     * Get references
     *
     * @return Collection
     */
    public function getReferences()
    {
        return $this->references;
    }

	/**
	 * @return string
	 */
	public function getCsvIdent()
	{
		return $this->csvIdent;
	}

	/**
	 * @param string $csvIdent
	 * @return self
	 */
	public function setCsvIdent($csvIdent)
	{
		$this->csvIdent = $csvIdent;
		return $this;
	}

}
