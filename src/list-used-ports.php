<?php

/**
 * Created by Erlang Parasu 2022.
 */

function _parseStrLog($str_all)
{
    $lines = explode("\n", $str_all);
    // var_dump($lines);

    $str_all = implode("\n", $lines);

    $ports = [];
    foreach ($lines as $line) {
        $port = _parseLine($line);
        $ports['_' . $port] = $port;
    }
    // var_dump($ports);

    $results = [];
    foreach ($ports as $line) {
        if (!empty($line)) {
            if (strpos($str_all, ':' . $line . ' (LISTEN)') !== false) {
                $results[] = (int) $line;
            }
        }
    }

    sort($results);

    return $results;
}

function _parseLine($line)
{
    $str = $line;
    $arr = explode('(LISTEN', $str);
    $str = $arr[0];
    $arr = explode(':', $str);
    $arr = array_reverse($arr);

    $result = '';
    foreach ($arr as $item) {
        $item = trim($item);
        // echo $item;
        // echo "=====";
        $result = $item;

        break;
    }

    return $result;
}

function _execListUsedPorts()
{
    exec('lsof -nlP | grep "LISTEN"', $output);
    $str_all = implode("\n", $output);
    $ports = _parseStrLog($str_all);

    return $ports;
}

// $ports = _execListUsedPorts();
// var_dump($ports);
