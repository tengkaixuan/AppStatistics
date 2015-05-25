<?php
/**
 * Created by PhpStorm.
 * User: kaixuan.teng
 * Date: 2015/5/24
 * Time: 10:54
 */

namespace table;
require_once '../util/MysqlHelper.php';
use util\MysqlHelper;

class App {
    public $Id;
    public $Name;
    public function getAppById($id)
    {
        $app = new App();
        $dbHelper = new MysqlHelper();
        $sql = sprintf("select * from app where id = %s", $id);
        $result = $dbHelper->executeSql($sql);
        if($result)
        {
            foreach($result as $row)
            {
                $app->Id = $id;
                $app->Name = $row['name'];
            }

            return $app;
        }
        else
            return null;
    }
} 