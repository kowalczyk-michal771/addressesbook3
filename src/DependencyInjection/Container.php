<?php

namespace Src\DependencyInjection;

class Container
{
    /**
     * @var array Instances
     */
    protected array $instances = [];

    /**
     * Sets the instance
     * @param string $abstract
     * @param object $concrete
     */
    public function set(string $abstract, object $concrete): void
    {
        $this->instances[$abstract] = $concrete;
    }

    /**
     * Gets the instance
     * @param string $abstract
     * @return object
     * @throws \Exception
     */
    public function get(string $abstract): object
    {
        if (!isset($this->instances[$abstract])) {
            throw new \Exception("There is no instance " . $abstract);
        }

        return $this->instances[$abstract];
    }
}