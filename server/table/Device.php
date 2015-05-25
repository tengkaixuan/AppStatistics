<?php
/**
 * Created by PhpStorm.
 * User: kaixuan.teng
 * Date: 2015/5/24
 * Time: 0:03
 */



namespace table;
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.class.php';
});

class Device {
    public $id;
    public $baidu_device_id;
} 