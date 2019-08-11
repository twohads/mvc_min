<?php

namespace App\Controller;
use App\Model\ModelUser;

class Test extends \Core\Controller
{

    public function TestAction()
    {
        $this->render = false;
        echo "Тестовый модуль";

    }
    //TODO Халтурный метод, нужно принять данные через массив

    public function loadNewsAction()
    {
        $this->render = false;
        $data['title'] = $_GET['title'] ?? '';
        $data['content'] = $_GET['content'] ?? '';

        $model = new ModelUser();
        $model->loadData($data);

        if(!$model->check($error)){
            echo $error;
            return;
        }

        if($model->save($data)){
            echo "Ok";
            return;
        }else{
            echo "Не Ok";
        }


    }
}