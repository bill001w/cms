<?php

// 程序执行时间
function runtime()
{
    $temptime = explode(' ', SYS_START_TIME);
    $time = $temptime[1] + $temptime[0];
    $temptime = explode(' ', microtime());
    $now = $temptime[1] + $temptime[0];
    return number_format($now - $time, 6);
}

function lang($name, $data = '')
{
    $language = app('language');
    $string = isset($language[$name]) ? $language[$name] : $name;

    if ($data) {
        foreach ($data as $r => $t) {
            $string = str_replace('{' . $r . '}', $t, $string);
        }
    }

    return $string;
}
