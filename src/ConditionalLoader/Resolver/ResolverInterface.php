<?php

namespace ConditionalLoader\Resolver;

interface ResolverInterface
{
    /**
     * Resolves the modules list that ModuleManager should load based on conditions
     *
     * @param mixed $modules array or Traversable of module names
     *
     * @return mixed $modules array or Traversable of already filtered module names
     */
    public function resolve($modules);
}
