<?php

$dir = './';

function read_all_dir($dir)
{
    static $result = array();

    $h = opendir($dir);
    if($h){
        while (($file = readdir($h)) !== false) {
            if ($file != '.' && $file != '..') {
                $cur_path = $dir . DIRECTORY_SEPARATOR . $file;

                if (is_dir($cur_path)) {
                    $result['dir'][$cur_path] = read_all_dir($cur_path);
                } else {
                    $result['file'][] = $cur_path;
                }
            }
        }
        closedir($h);
    }

    return $result;
}
