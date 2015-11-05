<?php
namespace ImageManager\Repository;

use Doctrine\ORM\EntityRepository;
use ImageManager\Entity\Image;

class ImageRepository extends EntityRepository{

	public function create(Image $image){
		$this->_em->persist($user);
		$this->_em->flush($user);
		return $user;
	}

	public function saveToDb($data){
		$em = $this->getEntityManager();
		$image = new Image();
		$image->setName($data['name']);
		$image->setEmail($data['email']);
		$em->persist($image);
		//$em->flush();
	}

	public function updateDb($data){
		$em = $this->getEntityManager();
		$image = new Image();
		$em->persist($image);
		$em->flush();
	}

	public function updateImage(Image $image){
		$this->_em->persist($image);
		$this->_em->flush($image);
		return $image;
	}
	
	public function getImageId($id){
		$em = $this->getEntityManager();
		$imageId = $em->createQuery("SELECT n FROM ImageManager\Entity\Image n WHERE n.id = :id");
		$imageId->setParameter('id', $id);
		$imageId->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		return $imageId->getArrayResult();
	}

}
