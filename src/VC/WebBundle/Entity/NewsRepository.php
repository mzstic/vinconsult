<?php

namespace VC\WebBundle\Entity;
use Doctrine\ORM\EntityRepository;


/**
 * Class NewsRepository
 * @author Martin Patera <mzstic@gmail.com>
 */
class NewsRepository extends EntityRepository
{
	public function getLatestNews()
	{
		$qb = $this->createQueryBuilder('n')->select('n');
		$qb->orderBy('n.date', 'DESC');

		return $qb;
	}
}