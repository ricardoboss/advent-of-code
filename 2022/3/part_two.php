<?php
$input = file_get_contents("input.txt");
$lines = array_filter(explode("\n", $input));

$sum = 0;
for ($i = 0, $iMax = count($lines); $i < $iMax; $i += 3) {
	$first = $lines[$i];
	$second = $lines[$i + 1];
	$third = $lines[$i + 2];

	$common = array_unique(array_intersect(str_split($first), str_split($second), str_split($third)));
	assert(count($common) === 1);

	$c = ord(reset($common));
	if ($c > 90) {
		$c -= ord('a');
	} else {
		$c -= ord('A');
		$c += 26;
	}

	$sum += $c + 1;
}

echo $sum;