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

function is_cell_active($input, $x, $y, $size)
{
    $pos = get_pos($x, $y, $size);
    return $input[$pos] == 1;
}

function vertical_elem_fits($input, $pos, $size)
{

}

class Grid
{
    public $input = "";
    public $size = 0;

    function __construct($input)
    {
        $this->input = $input;
        $this->set_grid_size(strlen($input));
    }

    function set_grid_size($input_len)
    {
        $size = sqrt($input_len);
        if ($input_len - floor($size) ** 2 != 0) {
            throw new Exception("Invalid input");  // Invalid input
        }
        return $size;
    }

    // Positioning stuff

    function get_x($pos)
    {
        return floor($pos / $this->size);
    }

    function get_y($pos)
    {
        return $pos - get_x($pos, $this->size) * $this->size;
    }

    function get_pos($x, $y)
    {
        return $x * $this->size + $y;
    }

    // Data stuff

    function is_cell_active($x, $y)
    {
        $pos = get_pos($x, $y, $this->size);
        return $this->input[$pos] == 1;
    }
}