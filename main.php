<?php
require "autoload.php";
Messenger::message("Welcome to Intransitive Dice Game!");
try {
    DiceValidator::validate_dice(array_splice($_SERVER['argv'], 1));
    $userMovesFirst = OrderDefiner::DefineOrder();
    GameProcessor::Process($userMovesFirst);

} catch (Exception $e) {
    Messenger::exception($e);
}