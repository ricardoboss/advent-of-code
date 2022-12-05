<?php
$input = file_get_contents("input.txt");
$pairs = array_map(
	fn (string $line) => explode(',', $line),
	array_filter(explode("\n", $input)),
);

$redundant = 0;
foreach ($pairs as $pair) {
	assert(count($pair) === 2);

	$pair1 = explode("-", $pair[0]);
	$pair2 = explode("-", $pair[1]);

	$start1 = (int) $pair1[0];
	$end1 = (int) $pair1[1];
	$start2 = (int) $pair2[0];
	$end2 = (int) $pair2[1];

	if ($start1 > $start2) {
		$t1 = $start1;
		$t2 = $end1;
		$start1 = $start2;
		$end1 = $end2;
		$start2 = $t1;
		$end2 = $t2;
	}

	if ($start1 <= $start2 && $end1 >= $end2) {
		$redundant++;
	}
}

echo $redundant;
