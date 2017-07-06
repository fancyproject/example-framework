<?php namespace Framework\Core\Template;

use Symfony\Component\HttpFoundation\Response;

class Twig
{
    /**
     * @var \Twig_Environment
     */
    protected $twig;

    public function __construct()
    {
        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../../resources/views');
        $this->twig = new \Twig_Environment($loader, array(
            'cache' => __DIR__ . '/../../cache/twig',
        ));
    }

    /**
     * @param string $name
     * @param array $parameters
     * @return string
     */
    public function render($name, array $parameters = [])
    {
        $content = $this->twig->render($name, $parameters);
        return new Response($content);
    }
}