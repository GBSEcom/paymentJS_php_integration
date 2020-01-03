<?php
//get the response from the server	
$inputJSON = file_get_contents('php://input');
$logfile = dirname(__FILE__) . '/paymentLog/log_' . date('m-d-y') . '.log';

//get the value of Client-Token from the headers
$headers = [];
foreach (getallheaders() as $name => $value) {
    $headers[$name] = $value;
}

$clientToken = $headers['Client-Token'];
$logdata = '{' . '"clientToken":' . '"' . $clientToken. '",' . $inputJSON . '}';

//save the response in a log file
file_put_contents($logfile, $logdata . PHP_EOL, FILE_APPEND | LOCK_EX);
?>