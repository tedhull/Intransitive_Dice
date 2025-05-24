<?php
namespace App;
class Messenger
{
    const string HELP_MESSAGE = "Here's how you play the game!\nFirst of all add the set of 3 or more dice that respects the rules of the \033[1mGeneralized Intransitive Dice Game\033[0m\nthat means you need the set of dice where each die will be stronger than previous one, and the first die should be stronger than last.";
    public static function message($text): void
    {
        echo "\n" . $text;
    }
    public static function exception($ex): void
    {
        self::message($ex->getMessage());
        self::help();
        die();
    }
    public static function help(): void
    {
        self::message(self::HELP_MESSAGE);
    }
}