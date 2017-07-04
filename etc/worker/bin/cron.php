<?php
/**
 * The file to call by service or cron
 * @package worker
 * @version 0.0.1
 * @upgrade true
 */

if(!defined('BASEPATH'))
    define('BASEPATH', dirname(dirname(dirname(dirname(__FILE__)))));

$config = include BASEPATH . '/etc/config.php';
date_default_timezone_set($config['timezone']);

$files = array_values( array_diff( scandir(BASEPATH.'/etc/worker/jobs'), ['.', '..', '.gitkeep'] ) );
$nl = PHP_EOL;

if(!$files)
    return;

foreach($files as $file){
    $file_abs = BASEPATH . '/etc/worker/jobs/' . $file;
    $file_ctn = file_get_contents($file_abs);
    $data = explode(' | ', $file_ctn);
    
    if(!$data || !isset($data[1])){
        unlink($file_abs);
        continue;
    }
    
    $time = trim($data[0]);
    
    if($time > time())
        continue;
    
    $url = trim($data[1]);
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $result = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    
    $tx = print_r($info, true);
    $tx.= $nl;
    $tx.= $result;
    
    unlink($file_abs);
    $file_res = BASEPATH . '/etc/worker/result/' . $file;
    $f = fopen($file_res, 'w');
    fwrite($f, $tx);
    fclose($f);
}