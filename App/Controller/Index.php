<?php

namespace App\Controller;

use Core\Context;
use App\Model\ModelUser;
use Core\Controller;

class Index extends Controller
{
    public function indexAction()
    {
        /*
        $user = new ModelUser();
        $user->getIdDb();
        */
        $users = ModelUser::getListMethod([1,2,3,4,5]);
        $this->view->users = $users;
        echo Context::i()->getDb()->getLogHTML();
    }

    public function testAction()
    {
        $db = Context::i()->getDb();
        $db->fetchAll('SELECT * FROM news', __METHOD__);

        $this->view->test = new ModelUser();
        var_dump($this->view->test);
    }


}