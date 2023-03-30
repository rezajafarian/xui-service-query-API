<?php

if(!isset($_GET['remark'])) exit('The remark parameter is mandatory!');

include_once 'class.php';

$config = [
    'ip' => 'ip', # ip panel
    'port' => 'port', # port panel
    'ssl' => 'http', # https or http
    'session' => 'session' # session
];

$xui = new subscription_inquiry_xui($config['ip'], $config['port'], $config['ssl'], $config['session']);

$information = $xui->service_status($_GET['remark']);

if(is_null($information)){
    echo json_encode(['success' => false, 'status_code' => 404]);
}else{
    echo json_encode(['success' => true, 'results' => $information]);
}