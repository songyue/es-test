<?php
/**
 * File Name: src/Core/Application.php
 * Author: songyue
 * mail: songyue118@gmail.com
 * Created Time: Wed Mar  3 16:11:48 2021
 */
namespace Core;

use Core\EsDemo;

class Application
{
    public $defaultAction = 'index';

    protected $esDemo;

    public function __construct()
    {
        $this->esDemo = new EsDemo();
    }

    public function run()
    {
        $action = $this->getAction();
        $this->{$action};
    }

    public function getAction()
    {
        $argv = $_SERVER['argv'];
        if (count($argv) == 1) {
            $action = $this->defaultAction;
        } else {
            $action = $argv[1];
        }

        return ucfirst($action);
    }

    public function __get($val)
    {
        $this->esDemo->{'action' . $val}();
    }
}

