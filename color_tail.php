<?php
require './vendor/autoload.php';
use Colors\Color;

$c = new Color();
$file = dirname(__FILE__).'/'.$argv[1];

while(true){

    clearstatcache(true, $file);
    $currentSize = filesize($file);

    if ($size == $currentSize) {
        usleep(100000);
        continue;
    }
    $fh = fopen($file, "r");
    fseek($fh, $size);

    while ($row = fgets($fh)) {
        $r = explode("\t", rtrim($row));
        echo $c($r[0])->white;
        echo "\t";
        echo $c($r[1])->white;
        echo "\t";
        for($i=2; isset($r[$i]); $i++){
            $elm = $r[$i];
            if(preg_match('/^L/', $elm)){
                echo $c($elm)->white;
            }else{
                $time = (float)$elm;
                if(abs($time) < 0.001){
                    //echo $c($elm)->white->bold->bg_cyan;
                    echo $c($elm)->cyan;
                }else if(abs($time) < 0.01){
                    //echo $c($elm)->white->bold->bg_yellow;
                    echo $c($elm)->yellow;
                }else {
                    //echo $c($elm)->white->bold->bg_red;
                    echo $c($elm)->red;
                }
            }
            echo "\t";
        }
        echo PHP_EOL;
    }
    fclose($fh);
    $size = $currentSize; 
}


