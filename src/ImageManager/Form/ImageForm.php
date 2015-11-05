<?php
namespace ImageManager\Form;

use Zend\InputFilter;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class ImageForm extends Form{

	public function __construct(){
		parent::__construct('image-form');
		$this->setHydrator(new ClassMethodsHydrator(false))
			->setInputFilter(new InputFilter\InputFilter());

		$this->setAttribute('class', 'form-horizontal');
		$this->addElements();
		$this->addInputFilter();
	}

	public function addElements(){
		$file = new Element\File('image-file');
		$file->setLabel('Edit Your Image')
			->setAttribute('id', 'image-file')
			->setAttribute('multiple', true);
		$this->add($file);

		$submit = new Element\Submit('submit');
		$submit->setValue('Validation');
		$submit->setAttribute('class', 'btn btn-primary');
		$submit->setAttribute('id', 'submit');		
		$this->add($submit);
	}

	public function addInputFilter(){
		$inputFilter = new InputFilter\InputFilter();
		$fileInput = new InputFilter\FileInput('image-file');
		$fileInput->setRequired(true);

		$fileInput->getFilterChain()->attachByName(
			'filerenameupload',
			array(
				'target'    => __DIR__ . '/../../../public/tmpuploads',
				'randomize' => false,
				'use_upload_name' => true
			)
		);

		$inputFilter->add($fileInput);
		$this->setInputFilter($inputFilter);
	}

}
