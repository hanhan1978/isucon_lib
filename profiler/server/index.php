<?php

require('./pro.php');

$p = new Profiler();
$p->probe();
usleep(100000);
$p->probe();
usleep(90000);
$p->probe();
usleep(190000);
$p->probe_end();

echo nl2br(print_r($_SERVER, true));