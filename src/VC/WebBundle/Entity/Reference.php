<?php

namespace VC\WebBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reference
 *
 * @ORM\Table(name="reference")
 * @ORM\Entity(repositoryClass="VC\WebBundle\Entity\ReferenceRepository")
 */
class Reference
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
     * @ORM\Column(name="building", type="string", length=255, nullable=true)
     */
    private $building;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="country", type="string", length=255, nullable=true)
	 */
    private $country;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="city", type="string", length=255, nullable=true)
	 */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="investor", type="string", length=50, nullable=true)
     */
    private $investor;

    /**
     * @var string
     *
     * @ORM\Column(name="client", type="string", length=255, nullable=true)
     */
    private $client;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="realization", type="string", length=50, nullable=true)
     */
    private $realization;

    /**
     * @var string
     *
     * @ORM\Column(name="investment", type="string", length=50, nullable=true)
     */
    private $investment;

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer", nullable=true)
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="hip", type="string", length=50, nullable=true)
     */
    private $hip;

    /**
     * @var integer
     *
     * @ORM\Column(name="sort", type="smallint", nullable=true)
     */
    private $sort;

    /**
     * @var string
     *
     * @ORM\Column(name="commission_number", type="string", length=20, nullable=true)
     */
    private $commissionNumber;

    /**
     * @var boolean
     *
     * @ORM\Column(name="important", type="boolean", nullable=true)
     */
    private $important;

    /**
     * @var boolean
     *
     * @ORM\Column(name="publish", type="boolean", nullable=true)
     */
    private $publish;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="references")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="reference", cascade={"remove"})
     * @ORM\OrderBy({"sort" = "ASC"})
     */
    private $photos;

    /**
     * @var string
     * @ORM\Column(name="performances", type="string", length=255)
     */
    private $performances;

    public function setId($id)
    {
        $this->id = $id;
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
     * @return Reference
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
     * Set building
     *
     * @param string $building
     * @return Reference
     */
    public function setBuilding($building)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get building
     *
     * @return string 
     */
    public function getBuilding()
    {
        return $this->building;
    }

	/**
	 * @return string
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * @param string $country
	 * @return self
	 */
	public function setCountry($country)
	{
		$this->country = $country;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * @param string $city
	 * @return self
	 */
	public function setCity($city)
	{
		$this->city = $city;
		return $this;
	}

    /**
     * Set investor
     *
     * @param string $investor
     * @return Reference
     */
    public function setInvestor($investor)
    {
        $this->investor = $investor;

        return $this;
    }

    /**
     * Get investor
     *
     * @return string 
     */
    public function getInvestor()
    {
        return $this->investor;
    }

    /**
     * Set client
     *
     * @param string $client
     * @return Reference
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return string 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Reference
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

    /**
     * Set realization
     *
     * @param string $realization
     * @return Reference
     */
    public function setRealization($realization)
    {
        $this->realization = $realization;

        return $this;
    }

    /**
     * Get realization
     *
     * @return string 
     */
    public function getRealization()
    {
        return $this->realization;
    }

    /**
     * Set investment
     *
     * @param string $investment
     * @return Reference
     */
    public function setInvestment($investment)
    {
        $this->investment = $investment;

        return $this;
    }

    /**
     * Get investment
     *
     * @return string 
     */
    public function getInvestment()
    {
        return $this->investment;
    }

    /**
     * Set year
     *
     * @param int
     * @return Reference
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set hip
     *
     * @param string $hip
     * @return Reference
     */
    public function setHip($hip)
    {
        $this->hip = $hip;

        return $this;
    }

    /**
     * Get hip
     *
     * @return string 
     */
    public function getHip()
    {
        return $this->hip;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     * @return Reference
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
     * Set commissionNumber
     *
     * @param string $commissionNumber
     * @return Reference
     */
    public function setCommissionNumber($commissionNumber)
    {
        $this->commissionNumber = $commissionNumber;

        return $this;
    }

    /**
     * Get commissionNumber
     *
     * @return string 
     */
    public function getCommissionNumber()
    {
        return $this->commissionNumber;
    }

    /**
     * Set important
     *
     * @param boolean $important
     * @return Reference
     */
    public function setImportant($important)
    {
        $this->important = $important;

        return $this;
    }

    /**
     * Get important
     *
     * @return boolean 
     */
    public function isImportant()
    {
        return $this->important;
    }

    /**
     * Set publish
     *
     * @param boolean $publish
     * @return Reference
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;

        return $this;
    }

    /**
     * Get publish
     *
     * @return boolean 
     */
    public function getPublish()
    {
        return $this->publish;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    /**
     * Set category
     *
     * @param Category $category
     * @return Reference
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add photos
     *
     * @param Photo $photos
     * @return Reference
     */
    public function addPhoto(Photo $photos)
    {
        $this->photos[] = $photos;

        return $this;
    }

    /**
     * Remove photos
     *
     * @param Photo $photos
     */
    public function removePhoto(Photo $photos)
    {
        $this->photos->removeElement($photos);
    }

    /**
     * Get photos
     *
     * @return Collection
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set performances
     *
     * @param string $performances
     * @return Reference
     */
    public function setPerformances($performances)
    {
        $this->performances = $performances;

        return $this;
    }

    /**
     * Get performances
     *
     * @return string 
     */
    public function getPerformances()
    {
        return $this->performances;
    }
}
