<?php

namespace App\Controller;
class Test extends \Core\Controller
{

    public function TestAction()
    {
        $this->render = false;
        echo "Тестовый модуль";

    }
}