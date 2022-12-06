<?php
$input = trim(file_get_contents("input.txt"));

$i = 4;
while (count(array_unique(str_split(substr($input, $i - 4, 4)))) !== 4) {
	$i++;
}

echo $i;
