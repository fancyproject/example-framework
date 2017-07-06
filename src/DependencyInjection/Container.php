<?php namespace Framework\Core\DependencyInjection;

use InvalidArgumentException;

class Container
{
    private $container;

    /**
     * @param string $class
     * @return ContainerItem
     */
    protected function getContainerItem($class)
    {
        if (!isset($this->container[$class])) {
            $reflection = new \ReflectionClass($class);
            $constructor = $reflection->getConstructor();
            $arguments = [];

            if ($constructor && $constructor->getParameters()) {
                $arguments = $this->prepareParameters($constructor->getParameters());
            }
            $this->container[$class] = new ContainerItem($class, $arguments);
        }

        return $this->container[$class];
    }

    /**
     * @param string $class
     */
    public function get($class)
    {
        return $this->getContainerItem($class)->getObject();
    }

    /**
     * @param string $class
     * @param string $method
     * @param array $customParameters
     * @return mixed
     */
    public function call($class, $method, $customParameters = [])
    {
        $containerItem = $this->getContainerItem($class);
        if (!$containerItem->isMethodExist($method)) {
            throw new InvalidArgumentException("Method not exist $method in $class");
        }

        $parameters = $this->prepareParameters($containerItem->getMethod($method)->getParameters(), $customParameters);

        if ($containerItem->getObject() instanceof ContainerAwareInterface) {
            $containerItem->getObject()->setContainer($this);
        }

        return $containerItem->getMethod($method)->invokeArgs($containerItem->getObject(), $parameters);
    }

    /**
     * @param array|\ReflectionParameter[] $reflectionParameters
     * @param array $customParameters
     * @return array
     */
    private function prepareParameters($reflectionParameters = [], $customParameters = [])
    {
        $parameters = [];
        foreach ($reflectionParameters as $parameter) {

            if ($parameter->getClass()) {
                $parameters[] = $this->get($parameter->getClass()->getName());
            } elseif (isset($customParameters[$parameter->getName()])) {
                $parameters[] = $customParameters[$parameter->getName()];
            } elseif (!$parameter->isOptional()) {
                throw new InvalidArgumentException('Dependency injection param error');
            }
        }
        return $parameters;
    }
}