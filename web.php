<?php

if(!isset($_GET['value'])) exit('The value parameter is mandatory!');

include_once 'class.php';

$config = [
    'ip' => 'ip', # ip panel
    'port' => 'port', # port panel
    'ssl' => 'http', # https or http
    'session' => 'session' # session || cookie
];

$xui = new subscription_inquiry_xui($config['ip'], $config['port'], $config['ssl'], $config['session']);

if(isset($_GET['type']) and $_GET['type'] == 'port'){
    $information = $xui->service_status($_GET['value'], 'port');
}else{
    $information = $xui->service_status($_GET['value'], 'value');
}

if(is_null($information)){
    echo json_encode(['success' => false, 'status_code' => 404]);
}else{
    echo json_encode(['success' => true, 'results' => $information]);
}
