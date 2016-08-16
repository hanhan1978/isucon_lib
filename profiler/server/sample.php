<?php

require('./pro.php');

$p = new Profiler();
$p->probe();
usleep(40000);
$p->probe();
usleep(5000);
$p->probe();
usleep(90000);
$p->probe_end();


$p = new Profiler('IP BANNED');
$p->disable();
$p->probe();
$p->probe_end();