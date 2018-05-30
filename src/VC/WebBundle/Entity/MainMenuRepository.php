<?php

namespace VC\WebBundle\Entity;
use Doctrine\ORM\EntityRepository;


/**
 * Class MainMenuRepository
 * @author Martin Patera <mzstic@gmail.com>
 */
class MainMenuRepository extends EntityRepository
{
	public function getMainMenu()
	{
		$query = $this->createQueryBuilder('m')
			->orderBy('m.id')
			->getQuery();
		return $query->getResult();
	}
}