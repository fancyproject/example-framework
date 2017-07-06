<?php namespace Framework\Core\Controller;

use Framework\Core\Container;
use Framework\Core\DependencyInjection\ContainerAwareInterface;
use Framework\Core\DependencyInjection\ContainerTrait;
use Framework\Core\Template\Twig;

class AbstractController implements ContainerAwareInterface
{
    use ContainerTrait;

    /**
     * @param $name
     * @param array $params
     * @return Response
     */
    protected function render($name, $params = [])
    {
        $twig = $this->get(Twig::class);
        return $twig->render($name, $params);
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function get($name)
    {
        return $this->container->get($name);
    }
}