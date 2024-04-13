<?php

require __DIR__ . '/util.php';

$input = $argv[1];
$input_len = strlen($input);
echo $input_len . "\n";
echo get_grid_size($input_len);