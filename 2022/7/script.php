<?php
$input = array_filter(explode("\n", file_get_contents("input.txt")));

function putAtPath(array $path, array &$fs, string $name, array|int $entry): void {
	if (empty($path)) {
		$fs[$name] = $entry;
	} else {
		$nested = &$fs[array_shift($path)];

		putAtPath($path, $nested, $name, $entry);
	}
}

$path = [];
$fs = ['/' => []];
for ($i = 0, $iMax = count($input); $i < $iMax; $i++) {
	$line = $input[$i];

	if (!str_starts_with($line, "$")) {
		echo "unexpected line: $line";
	}

	$tokens = explode(" ", $line);
	switch ($tokens[1]) {
		case "cd":
			if ($tokens[2] === "..") {
				array_pop($path);
			} else {
				$path[] = $tokens[2];
			}
			break;
		case "ls":
			for ($i++; $i < $iMax && !str_starts_with($input[$i], "$"); $i++) {
				$entry = $input[$i];
				[$typeOrSize, $name] = explode(" ", $entry);

				if ($typeOrSize === "dir") {
					putAtPath($path, $fs, $name, []);
				} else {
					putAtPath($path, $fs, $name, (int)$typeOrSize);
				}
			}
			$i--;
			break;
		default:
			echo "Unknown command: $tokens[1]";
			break;
	}
}

function printFs(array $fs, int $indent = 0): void {
	foreach ($fs as $name => $entry) {
		if (is_array($entry)) {
			echo str_repeat(" ", $indent) . "- $name (dir)" . PHP_EOL;
			printFs($entry, $indent + 1);
		} else {
			echo str_repeat(" ", $indent) . "- $name (file, size=$entry)" . PHP_EOL;
		}
	}
}

//printFs($fs);

function calculateDirSize(array $dir): int {
	$sum = 0;
	foreach ($dir as $entry) {
		if (is_array($entry)) {
			$sum += calculateDirSize($entry);
		} else {
			$sum += $entry;
		}
	}
	return $sum;
}

function walkBranches(array $fs, callable $callback): void {
	foreach ($fs as $name => $entry) {
		if (is_int($entry)) {
			continue;
		}

		$callback($entry, $name);

		walkBranches($entry, $callback);
	}
}

$dirSizesTo100k = 0;
walkBranches($fs, function (array $entry) use (&$dirSizesTo100k) {
	$size = calculateDirSize($entry);
	if ($size <= 100000) {
		$dirSizesTo100k += $size;
	}
});
echo "Sum of all directories with a size of at most 100000: " . $dirSizesTo100k . PHP_EOL;

$total = 70000000;
$used = calculateDirSize($fs);
$available = $total - $used;
echo "Total size: $total, Used: $used, Available: $available" . PHP_EOL;

$smallestName = "/";
$smallestSize = $used;
walkBranches($fs, function (array $entry, string $name) use (&$smallestSize, &$smallestName, $available) {
	$needed = 30000000;
	$size = calculateDirSize($entry);
	if ($available + $size > $needed && $size < $smallestSize) {
		$smallestSize = $size;
		$smallestName = $name;
	}
});

echo "The directory that needs to be deleted is $smallestName with a size of $smallestSize" . PHP_EOL;
