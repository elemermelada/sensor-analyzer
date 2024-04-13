<?php
function get_grid_size($input_len)
{
    $size = sqrt($input_len);
    if ($input_len - floor($size) ** 2 != 0) {
        return -1;  // Invalid input
    }
    return $size;
}