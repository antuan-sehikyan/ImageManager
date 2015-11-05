<?php

namespace ImageManager\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Commons\Entity\AbstractEntity;

/**
 * @ORM\Entity(repositoryClass="\ImageManager\Repository\ImageRepository")
 */
class Image{

	 use \ImageManager\Traits\ReadOnly;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $name;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
    protected $type;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
    protected $size;

	/**
     * @ORM\Column(type="string");
     */
    protected $tmp_name;     
    //protected $tmp_name = '/tmpuploads/avatar.png';

    public function getId(){
        return $this->id;
    }

    public function setName($name){
        $this->name = $name;
        return $this;
    }

    public function getName(){
        return $this->name;
	}

    public function setType($type){
        $this->type = $type;
        return $this;
    }

    public function getType(){
        return $this->type;
    }

    public function setSize($size){
        $this->size = $size;
        return $this;
    }

    public function getSize(){
        return $this->size;
    }

    public function setTmpName($tmp_name){
        $this->tmp_name = $tmp_name;
        return $this;
    }

    public function getTmpName(){
        return $this->tmp_name;
    }

}
