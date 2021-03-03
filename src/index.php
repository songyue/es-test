<?php

/**
 * File Name: src/index.php
 * Author: songyue
 * mail: songyue118@gmail.com
 * Created Time: Wed Mar  3 16:11:48 2021
 */

use Core\Application;

require 'vendor/autoload.php';

$application = (new Application());
$application->run();

