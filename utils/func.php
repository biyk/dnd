<?php


function write_php_ini($array, $file)
{
    $res = array();
    foreach($array as $key => $val)
    {
        if(is_array($val))
        {
            $res[] = "[$key]";
            foreach($val as $skey => $sval) $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
        }
        else $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
    }
    safefilerewrite($file, implode("\r\n", $res));
}

function safefilerewrite($fileName, $dataToSave)
{    if ($fp = fopen($fileName, 'w'))
{
    $startTime = microtime(TRUE);
    do
    {            $canWrite = flock($fp, LOCK_EX);
        // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
        if(!$canWrite) usleep(round(rand(0, 100)*1000));
    } while ((!$canWrite)and((microtime(TRUE)-$startTime) < 5));
    //file was locked so now we can store information
    if ($canWrite)
    {            fwrite($fp, $dataToSave);
        flock($fp, LOCK_UN);
    }
    fclose($fp);
}
}

if (!function_exists('pre'))
{
    /**
     * @param bool|array $array
     * @param bool $vardump
     * @param bool $description
     * @param bool $debug_print_trace
     *
     * @return bool
     */
    function pre($array = false, $vardump = false, $description = false, $debug_print_trace = false)
    {
        $debug_trace = debug_backtrace();
        if ($debug_print_trace)
        {
            $backtrace = "";
            foreach ($debug_trace as $k => $v)
            {
                if ($v['function'] == "include" || $v['function'] == "include_once" || $v['function'] == "require_once"
                    || $v['function'] == "require"
                )
                {
                    $backtrace
                        .= "#".$k." ".$v['function']."(".$v['args'][0].") called at [".$v['file'].":".$v['line']."]<br />";
                }
                else
                {
                    $backtrace .= "#".$k." ".$v['function']."() called at [".$v['file'].":".$v['line']."]<br />";
                }
            }
            echo "<br /><b>".$backtrace."</b><br />";
        }
        else
        {
            print("<br /><b>".$debug_trace[0]["file"].": ".$debug_trace[0]["line"]."</b><br />");
        }

        if ($description)
        {
            echo "<b>".$description."</b><br />";
        }

        echo "<pre>";
        if ($vardump)
        {
            var_dump($array);
        }
        else
        {
            print_r($array);
        }
        echo "</pre>";

        return true;
    }
}


function orderTry(&$init){

    usort($init['all'], function($a, $b) {
        if ($a['init'] && $b['init']) return $a['init'] - $b['init'];
        return 0;
    });
}

function getCurrentPlayer($init){
    $try = $init['try'];
    foreach ($init['all'] as $player){
        if ($player['init']==$try) return $player['name'];
    }
    return '???';
}

function getNextPlayer($init){
    orderTry($init);
    if (!$init['try']) return '--';
    if ($init['next']) {
        foreach ($init['all'] as $player){
            $local_init = (int) $player['init'];
            if ( $local_init==$init['next']) return $player['name'];
        }
    };
    $try = $init['try']-1;
    foreach ($init['all'] as $player){
        $local_init = (int) $player['init'];
        if ( $local_init>=$try) return $player['name'];
    }
    return '???';
}



/**
 * API
 */

function selectCommand($data){
    $command = $phrase = $locales = null;
    extract($data);
    $result = $command;

    // If the phrase is "таймер" and the second locale is an integer, replace the "()"
    if ($phrase=='таймер' && intval($locales[1])){
        $result = str_replace('()',"($locales[1])",$command);
    }

    if ($phrase=='Подсказка' && intval($locales[1])){
        //TODO
        //$result = str_replace('()',"($locales[1])",$command);
    }

    return $result;
}

function saveJson($file, $array){
    return file_put_contents($file, json_encode($array,JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE));
}