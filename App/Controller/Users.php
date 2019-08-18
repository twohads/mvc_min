<?php


namespace App\Controller;

use App\Models\Database;
use App\Models\File;
use App\Models\User;
use App\Models\Validation;
use Core\Controller;
use Src\ImagesLoad;
use Src\Mailer;

session_start();

class Users extends Controller
{
    public function accountAction()
    {
        new Database();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $image = $_FILES['accountfile']['tmp_name'];
            $imageName = $_FILES['accountfile']['name'];

            $check = new Validation();
            $check->fileExist('accountfile');
            $check->badName($imageName);

            $this->view->arrErr = $check->arrError;

            if (empty($check->arrError)) {
                $userId = $_SESSION['user_id'];
                $image = $_FILES['accountfile']['tmp_name'];
                $imageName = $_FILES['accountfile']['name'];

                $image1 = new ImagesLoad();
                $image1->secureLoadingImage($image, $imageName);
                $userFoto = File::createFile($userId, $imageName);

            }

        }


        $userId = $_SESSION['user_id'];
        $userBelong = File::getByRelations($userId);
        $this->view->userBelong = $userBelong;
    }

    public function crmAction()
    {

        new Database();
        $allUser = User::getAllUsersAgeSort('DESC');
        $this->view->allUser = $allUser;

    }

    public function crm2Action()
    {

        new Database();
        $allUser = User::getAllUsersAgeSort('ASC');
        $this->view->allUser = $allUser;

    }

    public function registrAction()
    {
        new Database();
        /*
        if (User::isUserAuthorizated()) {
            header('Location: login');
            die;
        }
        */

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dataCheck = new Validation();
            $name = htmlspecialchars($_POST['name']);
            $age = $_POST['age'];
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $dataCheck->checkNumber($age, "Возраст");
            $dataCheck->checkLength($name, 4, 50, "Имя");
            $dataCheck->checkEmail($email);
            $dataCheck->checkLength($password, 3, 50, "Пароль");
            $dataCheck->checkRegistr($name, $email);
            $dataCheck->checkLength($_FILES['file']['name'], 1, 50, "Изображение");
            $dataCheck->badName($_FILES['file']['name']);

            $this->view->dataCheck = $dataCheck->arrError;

            if (empty($dataCheck->arrError)) {
                $user = User::createUser();
                $insertedId = User::latestUser($user);
                $_SESSION['user_id'] = $insertedId;

                if ($_FILES['file']['name'] !== "") {
                    $image = $_FILES['file']['tmp_name'];
                    $imageName = $_FILES['file']['name'];
                    $image1 = new ImagesLoad();
                    $image1->secureLoadingImage($image, $imageName);
                    $user_foto = File::createFile($insertedId, $imageName);
                    $mail = new Mailer();
                    $mail->send($email, $imageName, $name);
                }

                header('Location: login');
                return;
            }
        }
    }

    public function loginAction()
    {
        new Database();
        /*
        if (!User::isUserAuthorizated()) {
            //header('Location: registr');
            //die;
            echo "Не авторизован";
        }*/


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dataCheck = new Validation();
            $dataCheck->checkLength($_POST['name'], 2, 255, "Имя");
            $dataCheck->checkLength($_POST['password'], 3, 255, "Пароль");
            $dataCheck->authMatch($_POST['name'], $_POST['password']);
            $this->view->dataCheck = $dataCheck->arrError;

            if (empty($dataCheck->arrError)) {
                $userCheсk = User::getNameAndPassword($_POST['name'], $_POST['password']);
                $_SESSION['user_id'] = $userCheсk[0]['id'];
                header('Location: account');
                return;
            }
        }
    }

    public function storageAction()
    {
        $this->render = false;
        new Database();

        // Авторизация
        if ($_POST['command'] == 'login') {

            $userCheсk = User::getNameAndPassword($_POST['name'], $_POST['password']);
            if ($userCheсk) {
                $_SESSION['user_id'] = $userCheсk[0]['id'];
                header('Location: account');
                return;
            }
            $_SESSION['context'] = 'wrong';
            header('Location: login');
            return;
        }

        // Регистрация
        if ($_POST['command'] == 'registr') {

            $userChek = User::getByNameAndEmail($_POST['name'], $_POST['email']);
            if (!$userChek) {
                $user = User::createUser();
                $insertedId = User::latestUser($user);
                $_SESSION['user_id'] = $insertedId;

                $image = $_FILES['file']['tmp_name'];
                $imageName = $_FILES['file']['name'];
                $image1 = new ImagesLoad();
                $image1->secureLoadingImage($image, $imageName);
                $user_foto = File::createFile($insertedId, $imageName);
                return;
            }

            //Добавление фото из личного кабинета
            if ($_POST['command'] == 'avatar') {
                echo "avarar";
                if (file_exists($image = $_FILES['accountfile']['tmp_name'])) {
                    $name = ($_FILES['accountfile']['name']);
                    if ($check = File::imageUniqName($name)) {

                    };
                }
                $userId = $_SESSION['user_id'];
                $image = $_FILES['file']['tmp_name'];
                $imageName = $_FILES['file']['name'];
                $fotoName = File::imageUniqName($imageName);
                $image1 = new ImagesLoad();
                $image1->secureLoadingImage($image, $imageName);
                $userFoto = File::createFile($userId, $fotoName);

                return;
            }

        }


    }
}