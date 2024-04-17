<?php

require __DIR__ . '/util.php';

$input = $argv[1];
$grid = new Grid($input);
var_dump($grid->is_cell_active(-1, 0));
var_dump($grid->is_cell_active(0, 4));
var_dump($grid->is_cell_active(1, 0));
var_dump($grid->is_cell_active(1, 1));