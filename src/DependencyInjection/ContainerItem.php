<?php namespace Framework\Core\DependencyInjection;

class ContainerItem
{
    /**
     * @var object
     */
    protected $object;

    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * @var \ReflectionClass
     */
    protected $reflectionClass = null;

    /**
     * ContainerItem constructor.
     * @param string $class
     * @param array $arguments
     */
    public function __construct($class, array $arguments = [])
    {
        $this->object = new $class(...$arguments);
        $this->arguments = $arguments;
    }

    public function isMethodExist($method)
    {
        return $this->getReflectionClass()->hasMethod($method);
    }

    /**
     * @param string $method
     * @return \ReflectionMethod
     */
    public function getMethod($method)
    {
        return $this->getReflectionClass()->getMethod($method);
    }

    /**
     * @return \ReflectionClass
     */
    public function getReflectionClass()
    {
        if ($this->reflectionClass === null) {
            $this->reflectionClass = new \ReflectionClass($this->object);
        }
        return $this->reflectionClass;
    }

    public function getObject()
    {
        return $this->object;
    }
}