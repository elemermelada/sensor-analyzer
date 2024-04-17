<?php
const INACTIVE = 0;
const ACTIVE = 1;

class Grid
{
    public $input = "";
    public $size = 0;

    function __construct($input)
    {
        $this->input = $input;
        $this->set_grid_size(strlen($input));
    }

    function set_grid_size($input_len):void
    {
        $size = sqrt($input_len);
        if ($input_len - floor($size) ** 2 != 0) {
            throw new Exception("Invalid input");  // Invalid input
        }
        $this->size = $size;
    }

    // Positioning stuff

    function get_x($pos):int
    {
        return floor($pos / $this->size);
    }

    function get_y($pos):int
    {
        return $pos - $this->get_x($pos) * $this->size;
    }

    function get_pos($x, $y):int
    {
        if ($x<0 || $x>=$this->size) return -1; // Send -1 if position is invalid
        if ($y<0 || $y>=$this->size) return -1; // Send -1 if position is invalid
        return $x * $this->size + $y;
    }

    function get_value_in_pos($x, $y):int
    {
        $pos = $this->get_pos($x, $y);
        if ($pos < 0) return $pos;  // If pos is invalid, return ec
        return (int)$this->input[$pos];
    }

    // Data stuff

    function is_cell_active($x, $y):bool
    {
        $val = $this->get_value_in_pos($x, $y);
        var_dump($val);
        if ($val < 0) return false;   // If value is invalid, return false

        return $val == ACTIVE;
    }
}