<?php
$input = file_get_contents("input.txt");
$lines = explode("\n", $input);
$grid = [];

$y = 0;
while (!empty($line = array_shift($lines))) {
	$chars = str_split($line);
	for ($x = 0, $xMax = strlen($line); $x < $xMax; $x += 4) {
		if ($line[$x] === '[') {
			$col = intdiv($x, 4);
			$grid[$col] ??= "";
			$grid[$col] = $line[$x + 1] . $grid[$col];
		}
	}
	$y++;
}

ksort($grid);

$moves = [];
while (!empty($line = array_shift($lines))) {
	$tokens = explode(" ", $line);
	$move = ['count' => (int)$tokens[1], 'from' => ((int)$tokens[3]) - 1, 'to' => ((int)$tokens[5]) - 1];
	$moves[] = $move;
}

function printGrid(array $grid)
{
	$col = 0;
	foreach ($grid as $column) {
		echo $col . "\t" . $column . PHP_EOL;
		$col++;
	}
}

printGrid($grid);
foreach ($moves as $move) {
	$from = $move['from'];
	$to = $move['to'];
	$count = $move['count'];

	$stack = strrev(substr($grid[$from], -$count));
	$grid[$from] = substr($grid[$from], 0, -$count);
	$grid[$to] .= $stack;

	echo PHP_EOL;
	echo "Moving $count crates from $from to $to:" . PHP_EOL;
	printGrid($grid);
}

echo PHP_EOL;
echo implode('', array_map(fn($col) => substr($col, -1), $grid));
