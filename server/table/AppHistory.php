<?php
/**
 * Created by PhpStorm.
 * User: kaixuan.teng
 * Date: 2015/5/24
 * Time: 10:58
 */

namespace table;

require_once 'App.php';
require_once 'Login.php';
require_once '../util/MysqlHelper.php';
use util\MysqlHelper;

class AppHistory {
    public $Id;
    public $UserId;
    public $DeviceId;
    public $AppId;
    public $StartTime;
    public $EndTime;

    /**
     * @param $deviceId $time
     * @return 返回$time时刻正在使用，$time时刻之后第一次App历史记录
     */
    public function getAppStartByDevice($deviceId, $time)
    {
        $sql = sprintf("select * from app_history where device_id=%s and
            (
            (start_time<'%s' and end_time>'%s')
            or start_time>='%s'
            )limit 1" ,
            $deviceId, $time, $time, $time);
        return $this->getOneAppHistory($sql);
    }

    public function getAppEndByDevice($deviceId, $time)
    {
        $sql = sprintf("select * from app_history where device_id=%s and
            (
            (start_time<'%s' and end_time>'%s')
            or end_time<='%s'
            )  order by id desc limit 1" ,
            $deviceId, $time, $time, $time);
        return $this->getOneAppHistory($sql);

    }

    public function getAppStartByUser($userId, $time)
    {
        $sql = sprintf("select * from app_history where user_id=%s and
            (
            (start_time<'%s' and end_time>'%s')
            or start_time>='%s'
            )limit 1" ,
            $userId, $time, $time, $time);
        return $this->getOneAppHistory($sql);
    }

    public function getAppEndByUser($userId, $time)
    {
        $sql = sprintf("select * from app_history where user_id=%s and
            (
            (start_time<'%s' and end_time>'%s')
            or end_time<='%s'
            )limit 1" ,
            $userId, $time, $time, $time);
        return $this->getOneAppHistory($sql);
    }


    private function getOneAppHistory($sql)
    {
        $appHistory = new AppHistory();
        $dbHelper = new MysqlHelper();
        $result = $dbHelper->executeSql($sql);

        if($result)
        {
            foreach($result as $row)
            {
                $appHistory->Id = $row['id'];
                $appHistory->UserId = $row['user_id'];
                $appHistory->DeviceId = $row['device_id'];
            }
            return $appHistory;
        }
        else
        {
            return null;
        }
    }
    /**
     * @param $deviceId
     * @param $start_time
     * @param $end_time
     * @return bool|\mysqli_result|null 返回从$start_time 至$end_time阶段，当前登录的前十名app的使用信息
     */
    public function getAppStatisticsByDeviceId($deviceId, $start_time, $end_time)
    {

        $startAppHistory = $this->getAppStartByDevice($deviceId, $start_time);
        $endAppHistory = $this->getAppEndByDevice($deviceId, $end_time);

        $selectSql = "
select app_history.id,app_history.device_id, user.number as user_number, app.name as app_name, sum( time_to_sec((timediff(app_history.end_time,app_history.start_time)))) as period from app_history
left join app on app_history.app_id = app.id
left join user on app_history.user_id = user.id";
        $sql = $selectSql;
        if($startAppHistory == null) return null;
        $sql = $selectSql. sprintf("
where app_history.device_id =%s and app_history.id >= %s
group by app_history.app_id order by period desc limit 10", $deviceId, $startAppHistory->Id);
        if($endAppHistory!=null)
        {
         $sql = $selectSql. sprintf("
where app_history.device_id =%s and app_history.id >= %s and app_history.id <= %s
group by app_history.app_id order by period desc limit 10", $deviceId, $startAppHistory->Id, $endAppHistory->Id);
        }

        $dbHelper = new MysqlHelper();
        $result = $dbHelper->executeSql($sql);

        if($result)
        {
            $ret = array();
            foreach($result as $row)
            {
                $oneRecord['user_number'] = $row['user_number'];
                $oneRecord['app_name']=$row['app_name'];
                $oneRecord['period']=$row['period'];
                array_push($ret,$oneRecord);
            }
           return $ret;
        }
        else
            return null;
    }


    public function getAppStatisticsByUserNumber($userNumber, $startTime, $endTime)
    {

    }
} 