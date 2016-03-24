<?php

//Dungeon class
class Dungeon {
private $seed, $dungeon_layout, $room_min, $room_max, $room_layout,$corridor_layout;
private $remove_deadends, $add_stairs, $map_style, $cell_size;
private $n_i, $n_j, $n_rows, $n_cols, $max_row, $max_col, $n_rooms;
private $room_base, $room_radix;
private $cell;


public Dungeon($opts){

//Import $opts - serves place of "my ($dungeon) = @_;" and get_opts()
$seed = $opts["seed"];
$n_rows = $opts["n_rows"];
$n_cols = $opts["n_cols"];
$dungeon_layout = $opts["dungeon_layout"];
$room_min = $opts["room_min"];
$room_max = $opts["room_max"];
$room_layout = $opts["room_layout"];
$corridor_layout = $opts["corridor_layout"];
$remove_deadends = $opts["remove_deadends"];
$add_stairs = $opts["add_stairs"];
$map_style = $opts["map_style"];
$cell_size = $opts["cell_size"];

//The following is just a translation of the extant create_dungeon()
$n_i = int($n_rows / 2);
$n_j = int ($n_cols / 2);
$n_rows = $n_i * 2;
$n_cols = $n_j * 2;
$max_row = $n_rows - 1;
$max_col = $n_cols - 1;
$n_rooms = 0;

//These are local variables
$max = $room_max;
$min = $room_min;

$room_base = int(($min + 1) / 2); 
$room_radix = int(($max - $min) / 2) + 1;

init_cells();
emplace_rooms();
open_rooms();
label_rooms();
corridors();
if($add_stairs) emplace_stairs();
clean_dungeon();

}

public init_cells(){

for ($r = 0; $i <= $n_rows; $r++)
	for ($c = 0; $c <= $n_cols; $c++)
		$cell[$r][$c] = $NOTHING;

srand($seed + 0);

//I AM UP TO THIS POINT CURRENTLY IN TRANSLATING

}

public emplace_rooms(){} //STUB
public open_rooms(){} //STUB
public label_rooms(){} //STUB
public corridors(){} //STUB
public emplace_stairs(){} //STUB
public clean_dungeon(){} //STUB

}

//Configuration
$dungeon_layout = array(
"Box" => [[1,1,1],[1,0,1],[1,1,1]],
"Cross" => [[0,1,0],[1,1,1],[0,1,0]]
);

$corridor_layout = array(
"Labyrinth" => 0,
"Bent" => 50,
"Straight" => 100
);

$map_style = array(
"Standard" => array(
"fill" => "000000",
"open" => "FFFFFF",
"open_grid" => "CCCCCC"
),
);

//Cell bits
$NOTHING     = 0x00000000;
$BLOCKED     = 0x00000001;
$ROOM        = 0x00000002;
$CORRIDOR    = 0x00000004;
//             0x00000008;
$PERIMETER   = 0x00000010;
$ENTRANCE    = 0x00000020;
$ROOM_ID     = 0x0000FFC0;
$ARCH        = 0x00010000;
$DOOR        = 0x00020000;
$LOCKED      = 0x00040000;
$TRAPPED     = 0x00080000;
$SECRET      = 0x00100000;
$PORTC       = 0x00200000;
$STAIR_DN    = 0x00400000;
$STAIR_UP    = 0x00800000;
$LABEL       = 0xFF000000;

$OPENSPACE   = $ROOM | $CORRIDOR;
$DOORSPACE   = $ARCH | $DOOR | $LOCKED | $TRAPPED | $SECRET | $PORTC;
$ESPACE      = $ENTRANCE | $DOORSPACE | 0xFF000000;
$STAIRS      = $STAIR_DN | $STAIR_UP;

$BLOCK_ROOM  = $BLOCKED | $ROOM;
$BLOCK_CORR  = $BLOCKED | $PERIMETER | $CORRIDOR;
$BLOCK_DOOR  = $BLOCKED | $DOORSPACE;

//directions
$di = array("north" => -1, "south" => 1, "west" = 0, "east" = 0);
$dj = array("north" => 0, "south" => 0, "west" = -1, "east" = 1);
$opposite = array(
"north" => "south",
"south" => "north",
"west" => "east",
"east" => "west"
);

$stair_end = array(
"north" => array(
"walled" => [[1,-1],[0,-1],[-1,-1],[-1,0],[-1,1],[0,1],[1,1]],
"corridor" => [[0,0],[1,0],[2,0]],
"stair" => [0,0],
"next" => [1,0]
),
"south" => array(
"walled" => [[-1,-1],[0,-1],[1,-1],[1,0],[1,1],[0,1],[-1,1]],
"corridor" => [[0,0],[-1,0],[-2,0]],
"stair" => [0,0],
"next" => [-1,0]
),
"west" => array(
"walled" => [[-1,1],[-1,0],[-1,-1],[0,-1],[1,-1],[1,0],[1,1]]
"corridor" => [[0,0],[0,1],[0,2]],
"stair" => [0,0],
"next" => [0,1]
),
"east" => array(
"walled" => [[-1,-1],[-1,0],[-1,1],[0,1],[1,1],[1,0],[1,-1]],
"corridor" => [[0,0],[0,-1],[0,-2]],
"stair" => [0,0],
"next" => [0,-1]
)
);

//cleaning
$close _end = array(
"north" => array(
"walled" => [[0,-1],[1,-1],[1,0],[1,1],[0,1]],
"close" => [[0,0]],
"recurse" => [-1,0]
),
"south" => array(
"walled" => [[0,-1],[-1,-1],[-1,0],[-1,1],[0,1]],
"close" => [[0,0]],
"recurse" => [1,0]
),
"west" => array(
"walled" => [[-1,0],[-1,1],[0,1],[1,1],[1,0]],
"close" => [[0,0]],
"recurse" => [0,-1]
),
"east" => array(
"walled" => [[-1,0],[-1,-1],[0,-1],[1,-1],[1,0]],
"close" => [[0,0]],
"recurse" => [0,1]
)
);

//imaging
$color_chain = array(
"door" => "fill",
"label" => "fill",
"stair" => "wall",
"wall" => "fill",
"fill" => "black"
);

//showtime

//my $opts = &get_opts();
//my $dungeon = &create_dungeon($opts);
//   &image_dungeon($dungeon);

//get dungeon options - OVERRIDE LATER WITH FORM
function get_opts(){
$opts = array(
 'seed'              => time(),
    'n_rows'            => 39,          // must be an odd number
    'n_cols'            => 39,          // must be an odd number
    'dungeon_layout'    => 'None',
    'room_min'          => 3,           // minimum room size
    'room_max'          => 9,           // maximum room size
    'room_layout'       => 'Scattered', // Packed, Scattered
    'corridor_layout'   => 'Bent',
    'remove_deadends'   => 50,          // percentage
    'add_stairs'        => 2,           // number of stairs
    'map_style'         => 'Standard',
    'cell_size'         => 18          // pixels

);
return $opts;
}

//Create dungeon - see Dungeon class above

?>
