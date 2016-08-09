<?php


$step  = $argv[1];
$until = $argv[2];
$cmd   = $argv[3];


if(is_null($step) || is_null($until) || is_null($cmd)){
    usage();
    exit;
}

echo "[Execute Parallel] step $step until $until => command $cmd \n";

for($i = 0 ; $i < $until; $i=$i+$step){
    system("php $cmd $step $i");
}


function usage(){
    echo "usage: ./parallel_exec.php [step] [until] [cmd]\n\n";
}
