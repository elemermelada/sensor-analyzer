<?php
const INACTIVE = 0;
const ACTIVE = 1;

class Grid
{

    // INITIALIZE

    public $input = "";
    public $size = 0;

    function __construct(string $input)
    {
        $this->input = $input;
        $this->set_grid_size(strlen($input));
    }

    function set_grid_size(int $input_len): void
    {
        $size = sqrt($input_len);
        if ($input_len - floor($size) ** 2 != 0) {
            throw new Exception("Invalid input");  // Invalid input
        }
        $this->size = $size;
    }

    // POSITIONING

    function get_x(int $pos): int
    {
        return floor($pos / $this->size);
    }

    function get_y(int $pos): int
    {
        return $pos - $this->get_x($pos) * $this->size;
    }

    function get_pos(int $x, int $y): int
    {
        if ($x < 0 || $x >= $this->size) return -1; // Send -1 if position is invalid
        if ($y < 0 || $y >= $this->size) return -1; // Send -1 if position is invalid
        return $x * $this->size + $y;
    }

    // VALUE

    function get_value(int $x, int $y): int
    {
        $pos = $this->get_pos($x, $y);
        if ($pos < 0) return $pos;  // If pos is invalid, return ec
        return (int)$this->input[$pos];
    }

    function set_value(int $x, int $y, int $value): void
    {
        $pos = $this->get_pos($x, $y);
        if ($pos < 0) throw new Exception("Fatal error: attempting to `set_value` out of bounds");
        $this->input[$pos] = (string)$value;
    }

    function is_cell_active(int $x, int $y): bool
    {
        $val = $this->get_value($x, $y);
        if ($val < 0) return false;   // If value is invalid, return false

        return $val == ACTIVE;
    }
}