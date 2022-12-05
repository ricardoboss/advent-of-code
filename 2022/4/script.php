<?php
$input = file_get_contents("input.txt");
$pairs = array_map(
	fn(string $line) => array_map(
		fn(string $pair) => array_map(
			fn(string $bound) => (int)$bound,
			explode("-", $pair),
		),
		explode(',', $line),
	),
	array_filter(explode("\n", $input)),
);
unset($input);

$redundant = 0;
foreach ($pairs as $pair) {
	[[$start1, $end1], [$start2, $end2]] = $pair;

	if ($start1 <= $start2 && $end1 >= $end2) {
		$redundant++;
	} else if ($start2 <= $start1 && $end2 >= $end1) {
		$redundant++;
	}
}

echo $redundant;
