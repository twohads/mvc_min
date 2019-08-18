<?php

namespace App\Controller;

use App\Models\Database;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

use Src\ImagesLoad;
use Src\Mailer;


class Test extends \Core\Controller
{
    protected static $imagePath;

    public function preAction()
    {
        parent::preAction();
        $this->noRender();
        self::$_imagePath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'images/';
    }


    public function loadAction()
    {
        new Database();
        //$user = User::getByRelations(276);
        $user = File::getByRelations(276);
        $this->view->user = $user;
    }

    public function imageAction()
    {
        //$this->render = false;
        //$image = new ImagesLoad();
        //$image->test();

    }

    public function mailAction()
    {
        $this->render = false;
        $mail = new Mailer();
        var_dump($mail->send());
    }

    public function storageAction()
    {
        $this->render = false;
        $image = $_FILES['file']['tmp_name'];
        $imageName = $_FILES['file']['name'];
        $image1 = new ImagesLoad();
        $image1->secureLoadingImage($image, $imageName);
    }
}