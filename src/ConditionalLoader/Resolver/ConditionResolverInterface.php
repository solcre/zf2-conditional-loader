<?php

namespace ConditionalLoader\Resolver;

interface ConditionResolverInterface
{
    /**
     * Returns true if the module must be loaded
     *
     * @return boolean
     */
    public function resolve();
}
