<?php

namespace App\Controller;

use App\Model\TestModel;
use Symfony\Component\HttpFoundation\Response;
use Framework\Core\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @param TestModel $model
     * @param $age
     * @return mixed
     */
    public function indexAction(TestModel $model, $age)
    {
        dump($model->getInjection()->getTest());
        return $this->render('index.html.twig', array('name' => $age));
    }
}