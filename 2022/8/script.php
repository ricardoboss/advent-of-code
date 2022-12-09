<?php
$input = array_filter(explode("\n", file_get_contents("input.txt")));
$grid = array_map(fn (string $line) => str_split($line), $input);

$visibleTreeCount = 0;
for ($i = 0, $iMax = count($grid); $i < $iMax; $i++) {
	for ($j = 0, $jMax = count($grid[$i]); $j < $jMax; $j++) {
		$cell = (int)$grid[$i][$j];

		if (isVisibleFromTop($grid, $i, $j, $cell)) {
			$visibleTreeCount++;
		} else if (isVisibleFromBottom($grid, $i, $j, $cell)) {
			$visibleTreeCount++;
		} else if (isVisibleFromLeft($grid, $i, $j, $cell)) {
			$visibleTreeCount++;
		} else if (isVisibleFromRight($grid, $i, $j, $cell)) {
			$visibleTreeCount++;
		}
	}
}

echo $visibleTreeCount;

function isVisibleFromTop(array $grid, int $i, int $j, int $cell): bool {
	if ($i === 0) {
		return true;
	}

	for ($row = $i - 1; $row >= 0; $row--) {
		$aboveCell = (int)$grid[$row][$j];

		if ($aboveCell >= $cell) {
			return false;
		}
	}

	return true;
}

function isVisibleFromBottom(array $grid, int $i, int $j, int $cell): bool {
	if ($i === count($grid) - 1) {
		return true;
	}

	for ($row = $i + 1, $rowMax = count($grid); $row < $rowMax; $row++) {
		$belowCell = (int)$grid[$row][$j];

		if ($belowCell >= $cell) {
			return false;
		}
	}

	return true;
}

function isVisibleFromLeft(array $grid, int $i, int $j, int $cell): bool {
	if ($j === 0) {
		return true;
	}

	for ($col = $j - 1; $col >= 0; $col--) {
		$leftCell = (int)$grid[$i][$col];

		if ($leftCell >= $cell) {
			return false;
		}
	}

	return true;
}

function isVisibleFromRight(array $grid, int $i, int $j, int $cell): bool {
	if ($j === count($grid[$i]) - 1) {
		return true;
	}

	for ($col = $j + 1, $colMax = count($grid[$i]); $col < $colMax; $col++) {
		$rightCell = (int)$grid[$i][$col];

		if ($rightCell >= $cell) {
			return false;
		}
	}

	return true;
}
