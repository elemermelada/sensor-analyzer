<?php
const INACTIVE = 0;
const ACTIVE = 1;
const H_TILE = 2;
const V_TILE = 3;
const S_TILE = 4;

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

    // TILES
    // Vertical
    function v_tile_fits(int $x, int $y): bool
    {
        if (!$this->is_cell_active($x, $y)) return false;
        if (!$this->is_cell_active($x + 1, $y)) return false;
        if (!$this->is_cell_active($x + 2, $y)) return false;
        return true;
    }

    function draw_v_tile(int $x, int $y): void
    {
        $this->set_value($x, $y, V_TILE);
        $this->set_value($x + 1, $y, V_TILE);
        $this->set_value($x + 2, $y, V_TILE);
    }

    // Horizontal
    function h_tile_fits(int $x, int $y): bool
    {
        if (!$this->is_cell_active($x, $y)) return false;
        if (!$this->is_cell_active($x, $y + 1)) return false;
        if (!$this->is_cell_active($x, $y + 2)) return false;
        return true;
    }

    function draw_h_tile(int $x, int $y): void
    {
        $this->set_value($x, $y, H_TILE);
        $this->set_value($x, $y + 1, H_TILE);
        $this->set_value($x, $y + 2, H_TILE);
    }

    // Square
    function s_tile_fits(int $x, int $y): bool
    {
        if (!$this->is_cell_active($x, $y)) return false;
        if (!$this->is_cell_active($x, $y + 1)) return false;
        if (!$this->is_cell_active($x + 1, $y)) return false;
        if (!$this->is_cell_active($x + 1, $y + 1)) return false;
        return true;
    }

    function draw_s_tile(int $x, int $y): void
    {
        $this->set_value($x, $y, S_TILE);
        $this->set_value($x, $y + 1, S_TILE);
        $this->set_value($x + 1, $y, S_TILE);
        $this->set_value($x + 1, $y + 1, S_TILE);
    }

    // FUNCTION WAVE COLLAPSE
    function current_entropy()
    {
        $support_grid = new Grid($this->input);
        $total_possible_tiles = 0;

        for ($i = 0; $i < $this->size; $i++) {
            for ($j = 0; $j < $this->size; $j++) {
                if (!$this->is_cell_active($i, $j)) continue;
                if ($this->v_tile_fits($i, $j)) {
                    $total_possible_tiles++;
                    $support_grid->draw_v_tile($i, $j);
                }
                if ($this->h_tile_fits($i, $j)) {
                    $total_possible_tiles++;
                    $support_grid->draw_h_tile($i, $j);
                }
                if ($this->s_tile_fits($i, $j)) {
                    $total_possible_tiles++;
                    $support_grid->draw_s_tile($i, $j);
                }
            }
        }
        $defective_cells = substr_count($support_grid->input, (string)ACTIVE);

        return [$defective_cells, $total_possible_tiles];
    }

    function iterate_fwc()
    {
        if (substr_count($this->input, (string)ACTIVE) == 0) return 0;

        $best_fit = [$this->size ** 2 + 1, -1];
        $best_i = -1;
        $best_j = -1;
        $best_tile = -1;

        for ($i = 0; $i < $this->size; $i++) {
            for ($j = 0; $j < $this->size; $j++) {
                if (!$this->is_cell_active($i, $j)) continue;
                if ($this->v_tile_fits($i, $j)) {
                    $support_grid = new Grid($this->input);
                    $support_grid->draw_v_tile($i, $j);
                    $new_entropy = $support_grid->current_entropy();

                    if ($new_entropy[0] < $best_fit[0]) {
                        $best_fit = $new_entropy;
                        $best_i = $i;
                        $best_j = $j;
                        $best_tile = V_TILE;
                    }
                }
                if ($this->h_tile_fits($i, $j)) {
                    $support_grid = new Grid($this->input);
                    $support_grid->draw_h_tile($i, $j);
                    $new_entropy = $support_grid->current_entropy();

                    if ($new_entropy[0] < $best_fit[0]) {
                        $best_fit = $new_entropy;
                        $best_i = $i;
                        $best_j = $j;
                        $best_tile = H_TILE;
                    }
                }
                if ($this->s_tile_fits($i, $j)) {
                    $support_grid = new Grid($this->input);
                    $support_grid->draw_s_tile($i, $j);
                    $new_entropy = $support_grid->current_entropy();

                    if ($new_entropy[0] < $best_fit[0]) {
                        $best_fit = $new_entropy;
                        $best_i = $i;
                        $best_j = $j;
                        $best_tile = S_TILE;
                    }
                }
            }
        }

        switch ($best_tile) {
            case V_TILE:
                $this->draw_v_tile($best_i, $best_j);
                return 1;
            case H_TILE:
                $this->draw_h_tile($best_i, $best_j);
                return 1;
            case S_TILE:
                $this->draw_s_tile($best_i, $best_j);
                return 1;
            default:
                return -1;
        }
    }
}
