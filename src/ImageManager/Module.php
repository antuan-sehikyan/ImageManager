<?php
namespace ImageManager;

class Module{
	
    public function getServiceConfig(){
        return array(
            'invokables' => array(
                'ImageResizer' => 'ImageManager\Service\ImageResizerService',
            ),
        );
    }	
    
    public function getConfig(){
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getAutoloaderConfig(){
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/../../src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
