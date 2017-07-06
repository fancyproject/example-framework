<?php namespace App\Model;
/**
 * Created by PhpStorm.
 * User: jakub
 * Date: 29/06/2017
 * Time: 15:48
 */
class TestModel
{
    /**
     * @var InjectionModel
     */
    private $injection;

    /**
     * TestModel constructor.
     * @param InjectionModel $injection
     * @param int $x
     */
    public function __construct(InjectionModel $injection, $x = 1)
    {
        $this->injection = $injection;
    }

    /**
     * @return InjectionModel
     */
    public function getInjection()
    {
        return $this->injection;
    }


}