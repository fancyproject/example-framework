<?php namespace Framework\Core\DependencyInjection;

interface ContainerAwareInterface
{
    /**
     * @param Container $container
     */
    public function setContainer(Container $container);
}