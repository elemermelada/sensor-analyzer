<?php

require __DIR__ . '/util.php';

$input = $argv[1];
$grid = new Grid($input);

echo $grid->apply_wfc();
