<?php

echo $argv[1];

$fp = fopen($argv[1], 'r');

$stat_count = [];
$stats = [];
$stats_line = [];

while($line = fgets($fp)){

    $elem = explode("\t", rtrim($line));
    $key = array_shift($elem) ." ". array_shift($elem);
    $stat_count[$key]++;

    $times = array_filter_key($elem, function($k){ return $k & 1;});
    $i=0;
    foreach($times as $t){
      $stats[$key][$i++] += $t;
    }
    if(!$stats_line){
      $stats_line = array_values(array_filter_key($elem, function($k){ return !($k & 1);}));
    }
}


print_r($stat_count);
print_r($stats);
print_r($stats_line);

foreach($stat_count as $path => $count){
  echo "--------------\n";
  echo $path."\n\n";
  for($j=0; $j<count($stats[$path]); $j++){

    echo "LINE ". $stats_line[$j]." ~ ".$stats_line[$j+1]."\t";
    echo (round($stats[$path][$j] / $count, 7) . "\n");
  }
  echo "\n";

}

function array_filter_key(array $array, $callback)
{
    $matchedKeys = array_filter(array_keys($array), $callback);
    return array_intersect_key($array, array_flip($matchedKeys));
}