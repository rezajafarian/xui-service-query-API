<?php

if(!isset($_GET['value']) and !isset($_GET['type'])) exit('The VALUE and TYPE parameter is mandatory!');
if(!in_array($_GET['type'], ['remark', 'port'])) exit('The TYPE parameter must be one of these (port | remark) options.');

include_once 'class.php';

$config = [
    'ip' => 'ip', # ip panel
    'port' => 'port', # port panel
    'ssl' => 'http', # https or http
    'session' => 'session' # session
];

$xui = new subscription_inquiry_xui($config['ip'], $config['port'], $config['ssl'], $config['session']);

$information = $xui->service_status($_GET['value'], $_GET['type']);

if(is_null($information)){
    echo json_encode(['success' => false]);
}else{
    echo json_encode(['success' => true, 'results' => $information]);
}
