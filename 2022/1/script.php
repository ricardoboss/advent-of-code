<?php
$input = file_get_contents('input.txt');
$elves = array_map(
	fn ($lines) => array_sum(array_map(intval(...), explode("\n", $lines))),
	explode("\n\n", $input),
);
sort($elves);

echo "Part One: ";
echo end($elves) . PHP_EOL;

echo "Part Two: ";
echo array_pop($elves) + array_pop($elves) + array_pop($elves);
