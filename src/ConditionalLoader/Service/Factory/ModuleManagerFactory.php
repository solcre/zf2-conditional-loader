<?php

namespace ConditionalLoader\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Service\ModuleManagerFactory;

class ModuleManagerFactory extends ModuleManagerFactory
{
    /**
     * {@inheritDoc}
     *
     * @return ModuleManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $configuration    = $serviceLocator->get('ApplicationConfig');
        $conditionalResolvers  = $configuration['modules_conditional_resolvers'];

        $moduleManager = parent::createService($serviceLocator);

        $moduleManager->getModules();

        return $moduleManager;
    }
}
