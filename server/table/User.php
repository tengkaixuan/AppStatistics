<?php
/**
 * Created by PhpStorm.
 * User: kaixuan.teng
 * Date: 2015/5/23
 * Time: 22:25
 */


namespace table;
require_once 'util/MysqlHelper.php';
use util\MysqlHelper;


class User {
    public $Id = 0;
    public $UserName='';
    public $Number;
    public $Friends = array();

    public function  getUserById($id)
    {
        $user = new User();
        $user->Id = '';
        $dbHelper = new MysqlHelper();
        $result = $dbHelper->executeSql("select * from USER where id = {$id}");
        if($result)
        {
            foreach($result as $row)
            {
                $user->Id = $row['id'];
                $user->UserName = $row['name'];
                $user->Number = $row['number'];
            }
            return $user;
        }
        return null;
    }
}

