<?php
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
        $this->size = $size;
    }

    // Positioning stuff

    function get_x($pos)
    {
        return floor($pos / $this->size);
    }

    function get_y($pos)
    {
        return $pos - $this->get_x($pos) * $this->size;
    }

    function get_pos($x, $y)
    {
        return $x * $this->size + $y;
    }

    // Data stuff

    function is_cell_active($x, $y)
    {
        $pos = $this->get_pos($x, $y);
        var_dump($this->input[$pos]);
        return $this->input[$pos] == '1';
    }
}