<?php
/**
 * Created by PhpStorm.
 * User: kaixuan.teng
 * Date: 2015/5/24
 * Time: 0:21
 */

namespace util;


class MysqlHelper {
    public function executeSql($sql)
    {

        $db = mysqli_connect('localhost', 'teng', 'teng', 'app_statistics');
        $result = mysqli_query($db, $sql);
        return $result;
    }
} 