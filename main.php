<?php
require_once 'vendor/autoload.php';

use App\Messenger;
use App\DiceValidator;
use App\OrderDefiner;
use App\GameProcessor;
use App\ProbabilityComputer;

start();
play();
function start(): void
{
    try {
        configureDiceData();
        Messenger::message("Welcome to Intransitive Dice Game!");
    } catch (Exception $e) {
        Messenger::exception($e);
    }
}

function play(): void
{
    try {
        $userMovesFirst = OrderDefiner::DefineOrder();
        GameProcessor::startGame($userMovesFirst);
    } catch (Exception $e) {
        Messenger::exception($e);
    }
}

function configureDiceData(): void
{
    $dice = array_splice($_SERVER['argv'], 1);
    $validDice = DiceValidator::validate_dice($dice);
    $_SERVER['dice'] = $validDice;
    $_SERVER['accessible'] = $validDice;
    $probabilityMap = ProbabilityComputer::ComputeProbabilities();
    $_SERVER['map'] = $probabilityMap;
}