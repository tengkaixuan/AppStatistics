<?php
/**
 * Created by PhpStorm.
 * User: kaixuan.teng
 * Date: 2015/5/24
 * Time: 0:05
 */

namespace table;

require_once '../util/MysqlHelper.php';
use util\MysqlHelper;

/**
 * Class LogIn 一旦用户使用一个设备登录之后，系统就会默认给此用户分配LogIn ID, 用户没有注册时，一个loginID 对应一个user number以及一个device，即一个用户只能使用一个device，
 * @package table
 */
class LogIn {
    public $Id;
    public $Number;
    public $DeviceId;
    public $StartTime;
    public $EndTime;

    /**
     * @param $userNumber
     * @param $startTime
     * @param $endTime
     * @return bool|\mysqli_result|null 数组[login_id:1]
     */
    public function getLoginIdsByNumber($userNumber, $startTime, $endTime)
    {
        $ret = array();
        $sql = sprintf("SELECT log_in.id as login_id FROM log_in left join user on log_in.user_id = user.id
where user.number ='%s' and ((start_time>='%s'and start_time<'%s' ) or(end_time>'%s' and end_time<='%s'))", $userNumber, $startTime,$endTime,$startTime,$endTime);
        $sqlHelper = new MysqlHelper();
        $result =  $sqlHelper->executeSql($sql);
        if($result)
        {
            return $result;
        }
        else
            return null;
    }

}

