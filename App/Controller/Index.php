<?php


class Index
{
    public $view;

    public function indexAction()
    {
        include '../Model/ModelUser.php';
        $this->view->modalUser = new ModelUser();
    }

    public function testAction()
    {
        echo 'Мы попали в контроллер: '.__CLASS__.' и вызываем экшн ' . __METHOD__ ;
    }
}