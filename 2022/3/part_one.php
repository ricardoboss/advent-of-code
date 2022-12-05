<?php
$input = file_get_contents("input.txt");
$lines = array_filter(explode("\n", $input));

$sum = 0;
foreach ($lines as $line) {
	$len = strlen($line);
	assert($len % 2 === 0);

	$first = substr($line, 0, $len / 2);
	$second = substr($line, $len / 2);

	$common = array_unique(array_intersect(str_split($first), str_split($second)));
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
