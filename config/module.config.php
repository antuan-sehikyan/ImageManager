<?php

namespace ImageManager;

return array(
    'controllers' => array(
        'invokables' => array(
            'ImageManager\Controller\Index' => 'ImageManager\Controller\IndexController',
//            'ImageManager\Controller\Thumb' => 'ImageManager\Controller\ThumbController',
        ),
    ),
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                'ImageManager' => __DIR__ . '/../public',
            ),
        ),
    ),
    //'assetic_configuration' => array(
        //'debug' => true,
        //'buildOnRequest' => true,

        //'webPath' => realpath('public/assets'),
        //'basePath' => 'assets',

        //'routes' => array(
            //'image' => array(
                //'@base_js',
                //'@base_css',
            //),
        //),

        //'modules' => array(
            //'image' => array(
                //'root_path' => __DIR__ . '/../assets',
                //'collections' => array(

                    //'base_images' => array(
                        //'assets' => array(
                            //'tmpuploads/*.png',
                            //'tmpuploads/*.jpg',                            
                            //'tmpuploads/*.ico',
                        //),
                        //'options' => array(
                            //'move_raw' => true,
                        //)
                    //),
                //),
            //),
        //),
    //),    
    'router' => array(
        'routes' => array(
            'image' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/image[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        //'name' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ImageManager\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
//            'imageManager' => 'ImageManager\Service\ManagerService',
//            'miniManager' => 'ImageManager\Service\MiniService',
        ),
    ),
//    'htimg' => array(
//        'filters' => array(
//            'my_thumb' => array(
//                'type' => 'thumbnail',
//                'options' => array(
//                    'width' => 200,
//                    'height' => 200
//                )
//            ),
//        )
//    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
//    'module_config' => array(
//        'image_location' => __DIR__ . '/../data/images',
//    ),
    'doctrine' => array(
        'driver' => array(
            'Image_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/ImageManager/Entity'),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'ImageManager\Entity' => 'Image_driver',
                ),
            ),
        ),
    ),
);
