<?php

namespace Core;

class View
{
    protected $data;

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        if(isset($this->data[$name])){
            return $this->data[$name];
        }
        else {
            return "";
        }
    }

    public function render($tpl)
    {
        ob_start();
        include $tpl;
        return ob_get_clean();
    }

}