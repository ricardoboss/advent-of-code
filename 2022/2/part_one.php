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

const MY_ROCK = "X";
const MY_PAPER = "Y";
const MY_SCISSORS = "Z";

const SCORE_ROCK = 1;
const SCORE_PAPER = 2;
const SCORE_SCISSORS = 3;

foreach ($lines as $line) {
	$op = $line[0];
	$my = $line[2];

	$score += match ($op) {
		OP_ROCK => match ($my) {
			MY_ROCK => DRAW + SCORE_ROCK,
			MY_PAPER => WIN + SCORE_PAPER,
			MY_SCISSORS => LOSS + SCORE_SCISSORS,
		},
		OP_PAPER => match ($my) {
			MY_ROCK => LOSS + SCORE_ROCK,
			MY_PAPER => DRAW + SCORE_PAPER,
			MY_SCISSORS => WIN + SCORE_SCISSORS,
		},
		OP_SCISSORS => match ($my) {
			MY_ROCK => WIN + SCORE_ROCK,
			MY_PAPER => LOSS + SCORE_PAPER,
			MY_SCISSORS => DRAW + SCORE_SCISSORS,
		},
	};
}

echo "Part One: ";
echo $score . PHP_EOL;
