<?php
$input = trim(file_get_contents("input.txt"));

$i = 14;
while (count(array_unique(str_split(substr($input, $i - 14, 14)))) !== 14) {
	$i++;
}

echo $i;
