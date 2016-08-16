<?php

class Profiler {

    private $name;
    private $probe_points = [];
    private $probe_lines = [];
    private $log_file = __DIR__.'/../analyze.log';
    private $disabled = false;

    public function __construct($name = '')
    {
        $this->name = $name;
    }
    public function disable()
    {
        $this->disabled = true;
    }

    public function probe($bt = null)
    {
        if($this->disabled) return;
        if(is_null($bt)){
          $bt = debug_backtrace();
        }
        $this->probe_lines[]  = $bt[0]['line'];
        $this->probe_points[] = microtime(true);
    }

    public function probe_end()
    {
        if($this->disabled) return;
        $this->probe(debug_backtrace());

        $str = $_SERVER['REQUEST_URI']."\t";
        $str .= $_SERVER['REQUEST_METHOD']."\t";
        for($i=0; $i<count($this->probe_points) ; $i++){
          $str .= "L".$this->probe_lines[$i]."\t";
          if($i < (count($this->probe_points) -1)){
            $str .= sprintf("%f\t", $this->probe_points[$i+1] - $this->probe_points[$i]);
          }
        }
        $this->write_log($str);
    }

    private function write_log($str)
    {
        $str = "[".$this->name."] ".$str;
        $fp = fopen($this->log_file, 'a');
        fwrite($fp, $str."\n");
        fclose($fp);
    }
}
