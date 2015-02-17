<?php

namespace ConditionalLoader\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Service\ModuleManagerFactory as ZendModuleManagerFactory;
use ConditionalLoader\Resolver\ConditionResolverInterface;

class ModuleManagerFactory extends ZendModuleManagerFactory
{
    /**
     * {@inheritDoc}
     *
     * @return ModuleManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $configuration    = $serviceLocator->get('ApplicationConfig');

        $conditionResolvers = array();

        if (isset($configuration['modules_condition_resolvers'])) {
            $conditionResolvers  = $configuration['modules_condition_resolvers'];
        }

        $moduleManager = parent::createService($serviceLocator);

        $modules = $moduleManager->getModules();

        foreach($conditionResolvers as $module => $conditionResolver) {
            if (!in_array($module, $modules)) {
                continue;
            }

            $resolver = $serviceLocator->get($conditionResolver);
            if (!$resolver instanceof ConditionResolverInterface) {
                continue;
            }
            
            if (!$resolver->resolve()) {
                unset($modules[array_search($module, $modules)]);
            }
        }

        $moduleManager->setModules($modules);

        return $moduleManager;
    }

}
