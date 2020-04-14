<?php
namespace VC\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Martin Patera <mzstic@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="home_link")
 */
class HomeLink
{

	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var Reference
	 * @ORM\ManyToOne(targetEntity="Reference")
	 * @ORM\JoinColumn(name="reference_id", referencedColumnName="id")
	 */
	private $reference;

	/**
	 * @var Reference
	 * @ORM\ManyToOne(targetEntity="News")
	 * @ORM\JoinColumn(name="news_id", referencedColumnName="id")
	 */
	private $news;

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
	 * @param Reference $reference
	 * @return HomeLink
	 */
	public function setReference(Reference $reference = null)
	{
		$this->reference = $reference;

		return $this;
	}

	/**
	 * Get reference
	 *
	 * @return Reference
	 */
	public function getReference()
	{
		return $this->reference;
	}

	/**
	 * @param News $news
	 * @return HomeLink
	 */
	public function setNews(News $news = null)
	{
		$this->news = $news;

		return $this;
	}

	/**
	 * Get news
	 *
	 * @return News
	 */
	public function getNews()
	{
		return $this->news;
	}
}
