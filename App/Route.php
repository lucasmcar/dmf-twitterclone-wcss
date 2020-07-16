<?php

namespace App;

use DiamondFramework\Init\Bootstrap;

class Route extends Bootstrap
{
    
    /**
     * Method that initializes routes
     */
    public function initRoutes()
    {
        
        $routes['home'] = array(
            'route' => '/',
            'controller' => 'indexController',
            'action' => 'index'
        );
        
        $routes['inscreverse'] = array(
            'route' => '/inscreverse',
            'controller' => 'indexController',
            'action' => 'inscreverse'
        );
        
        $routes['registrar'] = array(
            'route' => '/registrar',
            'controller' => 'indexController',
            'action' => 'registrar'
        );

        $routes['autenticar'] = array(
            'route' => '/autenticar',
            'controller' => 'authController',
            'action' => 'autenticar'
        );

        $routes['sair'] = array(
            'route' => '/sair',
            'controller' => 'authController',
            'action' => 'sair'  
        );

        $routes['timeline'] = array(
            'route' => '/timeline',
            'controller' => 'appController',
            'action' => 'timeline'
        );

        $routes['tweet'] = array(
            'route' => '/tweet',
            'controller' => 'appController',
            'action' => 'tweet'
        );
        
        $this->setRoutes($routes);
    }
  
}