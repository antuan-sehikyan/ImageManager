<?php

namespace ImageManager\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineModule\Validator\ObjectExists;
use ImageManager\Entity\Image;
use ImageManager\Form\ImageForm;

class IndexController extends AbstractActionController {

	protected $em;

	public function getEntityManager(){
		if($this->em == null){
			$this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}
		return $this->em;
	}
	
	public function getImageRepository(){
		$em = $this->getEntityManager();
		return $em->getRepository('ImageManager\Entity\Image');
	}	

	public function indexAction(){
		
		$id = $this->getEvent()->getRouteMatch()->getParam('id');
        		
		$view = new ViewModel();
		$images = $this->getImageRepository()->findAll();
		
		$imageForm = $this->forward()->dispatch('\ImageManager\Controller\Index', array(
			'action' => 'add'
		));
		$view->addChild($imageForm, 'imageForm');
		
		$view->setVariables(array(
			'images' => $images,
			'id' => $id	
		));
	
		return $view;
	}

	public function viewAction(){
		$em = $this->getEntityManager();
		$id = $this->getEvent()->getRouteMatch()->getParam('id');
		$entity = $em->find('ImageManager\Entity\Image', $id);
		$image = __DIR__ . '/../../../public/tmpuploads/' . $entity->getTmpName();
		
		//var_dump($image);die;
		$view = new ViewModel(array(
			'id' => $id,
			'image' => $this->getEntityManager()->find('ImageManager\Entity\Image', $id),
		));
		$view->setTerminal(true);
		return $view;	
	}

	public function addAction(){
		
		$em = $this->getEntityManager();
		$form = new ImageForm($em);
		
		$request = $this->getRequest();
		if($request->isPost()){
			$post = array_merge_recursive(
				$request->getPost()->toArray(),
				$request->getFiles()->toArray()
			);
			
			$filename = $post["image-file"][0]["name"];
			$validator = new ObjectExists(array(
				'object_repository' => $this->getImageRepository(),
				'fields' => 'name'
			));
			if($validator->isValid($filename) === true){
				$this->getResponse()->setStatusCode(404);
				return;
			}
			$form->setData($post);
			
			if($form->isValid()){
				$image = new Image();				
				$data = $form->getData();
				
				foreach($data['image-file'] as $k => $v){
					$image->setName($v['name']);
					$image->setType($v['type']);
					$image->setSize($v['size']);
					$image->setTmpName(basename($v['tmp_name']));								
				}
				
				$em->persist($image);
				$em->flush();	
				$imageResizer = $this->getServiceLocator()->get('ImageResizer');
				$imageResizer->createThumb($data);
				$this->redirect()->toRoute('image');	
			}
		}
		return new ViewModel(array(
			'form' => $form
		));
	}

 	public function editAction(){
		
		$id = $this->getEvent()->getRouteMatch()->getParam('id');
		if (!$id) {
            return $this->redirect()->toRoute('image');
        }	
        	
		$em = $this->getEntityManager();
		$entity = $em->find('ImageManager\Entity\Image', $id);

		$old_image = __DIR__ . '/../../../public/tmpuploads/' . $entity->getTmpName();
		$form = new \ImageManager\Form\ImageForm($em);
		
		$request = $this->getRequest();
		if($request->isPost()){
			$post = array_merge_recursive(
				$request->getPost()->toArray(),
				$request->getFiles()->toArray()
			);
			
			$form->setData($post);

			if($form->isValid()){
				$data = $form->getData();				
				foreach($data['image-file'] as $k => $v){
					$entity->setName($v['name']);
					$entity->setType($v['type']);
					$entity->setSize($v['size']);
					$entity->setTmpName(basename($v['tmp_name']));
				}
				$em->persist($entity);				
				$em->flush();
				$imageResizer = $this->getServiceLocator()->get('ImageResizer');
				$imageResizer->createThumb($data);
				
				unlink($old_image);
			}
		}
		return new ViewModel(array(
			'form' => $form,
            'id' => $id,
            'image' => $this->getEntityManager()->find('ImageManager\Entity\Image', $id),			
		));
	}
	
	public function deleteAction(){
		
		$id = $this->getEvent()->getRouteMatch()->getParam('id');
		if (!$id) {
            return $this->redirect()->toRoute('image');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
			$del = $request->getPost()->get('del', 'No');
			if ($del == 'Yes') {
				$id = (int)$request->getPost()->get('id');
				$entity = $this->getEntityManager()->find('ImageManager\Entity\Image', $id);
				$image = __DIR__ . '/../../../public/tmpuploads/' . $entity->getTmpName();
				
				if ($entity) {
                    $this->getEntityManager()->remove($entity);
                    $this->getEntityManager()->flush();
                }
                
                unlink($image);
                return $this->redirect()->toRoute('image');
                
			}
		}
		return array(
            'id' => $id,
            'image' => $this->getEntityManager()->find('ImageManager\Entity\Image', $id),
        );
	}
}





























