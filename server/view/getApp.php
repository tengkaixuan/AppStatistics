<?php
/**
 * Created by PhpStorm.
 * User: kaixuan.teng
 * Date: 2015/5/24
 * Time: 12:26
 */

require_once '../table/AppHistory.php';
use table\AppHistory;
$appHistory = new AppHistory();
/*
$app = $appHistory->getAppStart(2,'2015-05-24 00:00:00');
if($app!=null)
{
    print($app->Name);
}
*/
$result = $appUsage = $appHistory->getAppStatisticsByDeviceId(2,'2015-05-23 00:00:00','2015-05-25 00:00:00');

echo json_encode($result);