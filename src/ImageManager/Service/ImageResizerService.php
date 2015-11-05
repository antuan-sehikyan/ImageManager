<?php
namespace ImageManager\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ImageResizerService implements ServiceLocatorAwareInterface{

	protected $serviceLocator;

	public function setServiceLocator(ServiceLocatorInterface $serviceLocator){
		$this->serviceLocator = $serviceLocator;
	}

	public function getServiceLocator(){
		return $this->serviceLocator;
	}

	public function createThumb($image){
		$thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
		foreach($image['image-file'] as $k=>$v) $imagePath = $v['tmp_name'];

		$thumb = $thumbnailer->create($imagePath, $options = array(), $plugins = array());
		$thumb->adaptiveResize(600, 750);
		//$thumb->resize(600);		
		$thumb->save($imagePath);
	}

}
