<?php

declare(strict_types=1);

$array_size=15;

// Read array  will be used to work out the next state of each cell and saved to the write array
$read = array_fill(0, $array_size, array_fill(0, $array_size, 0));
$write = array_fill(0, $array_size, array_fill(0, $array_size, 0));

$read[1][2]=$read[2][3]=$read[3][1]=$read[3][2]=$read[3][3]=1;


$iterations = 10;

//Print read array to show initial state of all cells
function print_array($array_size, $array)
{
    for ($i = 0; $i < $array_size; $i++) {
        for ($k = 0; $k < $array_size; $k++) {
            echo $array[$i][$k];
        }
        echo "\n";
    }
    echo "\n\n";
}

print_array($array_size, $read);

//Function to calculate next state of cell if cell starts alive
function calculate_state_live ($cell1, $cell2, $cell3, $cell4=0, $cell5=0, $cell6=0, $cell7=0, $cell8=0): int{
    $sum_of_cells = $cell1+$cell2+$cell3+$cell4+$cell5+$cell6+$cell7+$cell8;
    return match ($sum_of_cells) {
        0, 1, 4, 5, 6, 7, 8     => 0,
        2, 3                    => 1,
        default => throw new \Exception('Unexpected match value'),
    };
}
//Function to calculate next state of cell if cell starts dead
function calculate_state_dead ($cell1, $cell2, $cell3, $cell4=0, $cell5=0, $cell6=0, $cell7=0, $cell8=0): int
{
    $sum_of_cells = $cell1+$cell2+$cell3+$cell4+$cell5+$cell6+$cell7+$cell8;
    return match ($sum_of_cells) {
        0, 1, 2, 4, 5, 6, 7, 8  => 0,
        3                       => 1,
        default => throw new \Exception('Unexpected match value'),
    };
}

//Combining above functions
function calculate_state($current_cell_state, $cell1, $cell2, $cell3, $cell4=0, $cell5=0, $cell6=0, $cell7=0, $cell8=0) :int{
    if ($current_cell_state==1) {
        return calculate_state_live($cell1, $cell2, $cell3, $cell4, $cell5, $cell6, $cell7, $cell8);
    }
    else if ($current_cell_state==0) {
        return calculate_state_dead($cell1, $cell2, $cell3, $cell4, $cell5, $cell6, $cell7, $cell8);
    }
}

for ($iteration = 0; $iteration < $iterations; $iteration++) {

    for($row=0; $row<$array_size; $row++) {
        if ($row==0){
            for ($column=0; $column<$array_size; $column++) {
                if ($column==0){
                    $write[$column][$row] = calculate_state($read[$column][$row], $read[$column+1][$row], $read[$column][$row+1], $read[$column+1][$row+1]);
                }
                elseif ($column==$array_size-1){
                    $write[$column][$row] = calculate_state($read[$column][$row], $read[$column-1][$row], $read[$column][$row+1], $read[$column-1][$row+1]);
                }
                else{
                    $write[$column][$row] = calculate_state($read[$column][$row], $read[$column-1][$row], $read[$column-1][$row+1], $read[$column][$row+1], $read[$column+1][$row+1], $read[$column+1][$row]);
                }
            }

        }
        elseif ($row==$array_size-1) {
            for ($column = 0; $column < $array_size; $column++) {
                if ($column == 0) {
                    $write[$column][$row] = calculate_state($read[$column][$row], $read[$column + 1][$row], $read[$column][$row - 1], $read[$column + 1][$row - 1]);
                } elseif ($column == $array_size - 1) {
                    $write[$column][$row] = calculate_state($read[$column][$row], $read[$column - 1][$row], $read[$column][$row - 1], $read[$column - 1][$row - 1]);
                } else {
                    $write[$column][$row] = calculate_state($read[$column][$row], $read[$column - 1][$row], $read[$column - 1][$row - 1], $read[$column][$row - 1], $read[$column + 1][$row - 1], $read[$column + 1][$row]);
                }
            }
        }
        else{
            for ($column = 0; $column < $array_size; $column++) {
                if ($column == 0) {
                    $write[$column][$row] = calculate_state($read[$column][$row], $read[$column][$row-1], $read[$column+1][$row - 1], $read[$column + 1][$row], $read[$column+1][$row + 1], $read[$column][$row+1]);
                } elseif ($column == $array_size - 1) {
                    $write[$column][$row] = calculate_state($read[$column][$row], $read[$column][$row-1], $read[$column-1][$row - 1], $read[$column - 1][$row], $read[$column-1][$row + 1], $read[$column][$row+1]);
                } else {
                    $write[$column][$row] = calculate_state($read[$column][$row], $read[$column - 1][$row], $read[$column - 1][$row - 1], $read[$column][$row - 1], $read[$column + 1][$row - 1], $read[$column + 1][$row], $read[$column+1][$row+1], $read[$column][$row+1], $read[$column-1][$row+1]);
                }
            }
        }
    }
    $read = $write;
    print_array($array_size, $read);
}



class Game
{
    public function GameOfLife1D(int $array_length, int $iterations)
    {
        $read = array_fill(0, $array_length, 1);
        $write = array_fill(0, $array_length, 0);

        foreach ($read as $state) {
            echo $state;
        }
        echo "\n";

        for ($i = 0; $i < $iterations; $i++) {
            $write[0] = 0;
            $write[$array_length - 1] = 0;

            for ($n = 1; $n < ($array_length - 1); $n++) {
                if ($read[$n - 1] + $read[$n + 1] == 2) {
                    $write[$n] = 1;
                } else {
                    $write[$n] = 0;
                }
            }
            foreach ($write as $state) {
                echo $state;
            }
            echo "\n";
            $read = $write;
        }

    }
}


