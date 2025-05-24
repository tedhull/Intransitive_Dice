<?php
namespace App;
class Messenger
{
    const string HELP_MESSAGE = "Here's how you play the game!";

    public static function message($text): void
    {
        echo "\n" . $text;
    }

    public static function exception($ex): void
    {
        self::message($ex->getMessage());
        self::help();
    }

    public static function help(): void
    {
        self::message(self::HELP_MESSAGE);
        die();
    }
}