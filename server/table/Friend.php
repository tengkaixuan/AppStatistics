<?php
/**
 * Created by PhpStorm.
 * User: kaixuan.teng
 * Date: 2015/5/24
 * Time: 0:06
 */

namespace table;

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.class.php';
});
class Friend {
    public $id;
    public $member1;
    public $member2;
} 