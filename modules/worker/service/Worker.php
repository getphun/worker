<?php
/**
 * Worker service
 * @package worker
 * @version 0.0.1
 * @upgrade true
 */

namespace Worker\Service;

class Worker{

    public function add($name, $url, $time, $overwrite=false){
        $file = BASEPATH . '/etc/worker/jobs/' . $name;

        if(!$overwrite && is_file($file))
            return false;
        
        $f = fopen($file, 'w');
        fwrite($f, "$time | $url");
        fclose($f);

        if(!is_file($file))
            return false;
        
        return true;
    }
    
    public function exists($name){
        $file = BASEPATH . '/etc/worker/jobs/' . $name;
        return is_file($file);
    }
    
    public function list(){
        $files = array_diff(scandir(BASEPATH . '/etc/worker/jobs'), ['.','..','.gitkeep']);
        return array_values($files);
    }
    
    public function remove($name){
        $file = BASEPATH . '/etc/worker/jobs/' . $name;
        if(!is_file($file))
            return false;
        return unlink($file);
    }
    
    public function get($name){
        $ctn = file_get_contents(BASEPATH . '/etc/worker/jobs/' . $name);
        $ctn = explode(' | ', $ctn);
        return (object)[
            'name' => $name,
            'time' => $ctn[0],
            'url'  => $ctn[1]
        ];
    }
}