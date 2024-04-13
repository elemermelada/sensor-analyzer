<?php
function get_grid_size($input_len)
{
    $size = sqrt($input_len);
    if ($input_len - floor($size) ** 2 != 0) {
        return -1;  // Invalid input
    }
    return $size;
}

function get_x($pos, $size)
{
    return floor($pos / $size);
}

function get_y($pos, $size)
{
    return $pos - get_x($pos, $size) * $size;
}

function get_pos($x, $y, $size)
{
    return $x * $size + $y;
}