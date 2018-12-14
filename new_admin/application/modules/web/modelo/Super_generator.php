<?php
defined('BASEPATH') or exit('No direct script access allowed');


use Doctrine\ORM\Id\AbstractIdGenerator;

class Super_generator extends AbstractIdGenerator
{
	public function generate(\Doctrine\ORM\EntityManager $em, $entity)
	{
		$nombreClase = get_class($entity);
		$dbConnection = $em->getConnection();
		$query = 'select max(c.id) from '.$nombreClase.' c';
		$newId = $em->createQuery($query)->getSingleScalarResult();
		return ++$newId;
	}
}