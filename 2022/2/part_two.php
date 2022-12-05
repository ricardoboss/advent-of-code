<?php
$input = file_get_contents("input.txt");

$score = 0;
$lines = array_filter(explode("\n", $input));

const WIN = 6;
const DRAW = 3;
const LOSS = 0;

const OP_ROCK = "A";
const OP_PAPER = "B";
const OP_SCISSORS = "C";

const DO_LOOSE = "X";
const DO_DRAW = "Y";
const DO_WIN = "Z";

const SCORE_ROCK = 1;
const SCORE_PAPER = 2;
const SCORE_SCISSORS = 3;

foreach ($lines as $line) {
	$op = $line[0];
	$my = $line[2];

	$score += match ($op) {
		OP_ROCK => match ($my) {
			DO_WIN => WIN + SCORE_PAPER,
			DO_DRAW => DRAW + SCORE_ROCK,
			DO_LOOSE => LOSS + SCORE_SCISSORS,
		},
		OP_PAPER => match ($my) {
			DO_LOOSE => LOSS + SCORE_ROCK,
			DO_DRAW => DRAW + SCORE_PAPER,
			DO_WIN => WIN + SCORE_SCISSORS,
		},
		OP_SCISSORS => match ($my) {
			DO_LOOSE => LOSS + SCORE_PAPER,
			DO_DRAW => DRAW + SCORE_SCISSORS,
			DO_WIN => WIN + SCORE_ROCK,
		},
	};
}

echo "Part Two: ";
echo $score . PHP_EOL;
