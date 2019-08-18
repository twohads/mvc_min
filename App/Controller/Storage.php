<?php


namespace App\Controller;


class Storage
{
    public $image;
    public function __construct()
    {
        $this->image = $_FILES['file']['tmp_name'];
        var_dump($this->image);
    }

    public function test()
    {
        $image = $_FILES['file']['tmp_name'];
    }
}