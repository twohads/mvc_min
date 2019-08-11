<?php


namespace App\Controller;


class User extends \Core\Controller
{
    public function indexAction()
    {
        $this->render = false;
        echo "Тестовый модуль";
    }

    public function loginAction()
    {
        $this->render = false;//TODO убрать повторения
        echo __METHOD__;
    }

    public function registrAction()
    {
        $this->render = false;//TODO убрать повторения
        echo __METHOD__;
    }
}