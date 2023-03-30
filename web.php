<?php

if(!isset($_GET['value'], $_GET['type'])) 
    exit('The VALUE and TYPE parameter is mandatory!');

if(!in_array($_GET['type'], ['remark', 'port'])) 
    exit('The TYPE parameter must be one of these (port | remark) options.');

include_once 'class.php';

$config = [
    'ip' => 'ip', # ip panel
    'port' => 'port', # port panel
    'ssl' => 'http', # https or http
    'session' => 'session' # session
];

$xui = new subscription_inquiry_xui($config['ip'], $config['port'], $config['ssl'], $config['session']);

$information = $xui->service_status($_GET['value'], $_GET['type']);

$result = ['success' => false];
if(!is_null($information)){
    $result['success'] = true;
    $result['results'] = $information; 
}

echo json_encode($result, 448);
