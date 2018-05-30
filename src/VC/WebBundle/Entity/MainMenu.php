<?php

namespace VC\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Class MainMenu
 * @author Martin Patera <mzstic@gmail.com>
 *
 * @ORM\Entity(repositoryClass="MainMenuRepository")
 * @ORM\Table(name="main_menu"))
 */
class MainMenu
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
	 * @ORM\Column(type="string", length=50)
	 */
	private $title;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=50)
	 */
	private $url;




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
     * @return MainMenu
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
     * @return MainMenu
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
}
