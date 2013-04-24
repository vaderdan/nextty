<?php

require_once dirname(__FILE__).'/lib/lime/lime.php';

$t = new lime_harness();
$t->register(array(dirname(__FILE__).'/functional'));
$t->run();

