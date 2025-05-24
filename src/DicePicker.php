<?php
namespace App;
class DicePicker
{
    private static $dice;
    private static $botsChoice;
    private static $usersChoice;

    public static function startGame($userMovesFirst): void
    {
        self::$dice = $_SERVER['dice'];
        if ($userMovesFirst) self::onPlayerMovesFirst();
        else self::onBotMovesFirst();
        DiceRoller::roll(self::$usersChoice,self::$botsChoice);
    }
    private static function onPlayerMovesFirst(): void
    {
        Messenger::message("You move first");
        self::letPlayerPick();
        Messenger::message("Now I pick my die");
        self::pickDie(false);
    }
    private static function onBotMovesFirst(): void
    {
        Messenger::message("I move first");
        self::pickDie(true);
        Messenger::message("Now you pick your die");
        self::letPlayerPick();
    }
    private static function letPlayerPick()
    {
        while (true) {
            $input = UIDrawer::pickDie();
            if ($input == -1) continue;
            self::$usersChoice = self::$dice[$input];
            break;
        }
        self::declareChoice(self::$usersChoice, "You");
    }
    private static function pickDie(bool $random)
    {
        if ($random) self::pickRandomDie();
        else self::pickBetterDie();
        self::declareChoice(self::$botsChoice, "I");
    }
    private static function pickRandomDie(): void
    {
        $choice = rand(0, count(self::$dice) - 1);
        self::$botsChoice = self::$dice[$choice];
        unset(self::$dice[$choice]);
        self::$dice = array_values(self::$dice);
        $_SERVER['accessible'] = self::$dice;
    }
    private static function pickBetterDie(): void
    {
        $index = array_search(self::$usersChoice, self::$dice);
        if ($index == array_key_last(self::$dice)) self::$botsChoice = self::$dice[0];
        else self::$botsChoice = self::$dice[$index + 1];
    }
    private static function declareChoice($die, string $side)
    {
        $strDie = implode(' ', $die);
        Messenger::message("{$side} picked [{$strDie}] die");
    }
}