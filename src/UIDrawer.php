<?php

namespace App;

use App\TableDrawer;

class UIDrawer
{
    const string BASIC_UI = "X - exit\n? - help\nT - probabilities table\n";

    public static function suggestNumber()
    {
        Messenger::message("0 - 0\n1 - 1\n" . self::BASIC_UI);
        return self::readInput([0, 1]);
    }

    public static function pickDie()
    {
        $expected = [];
        $accessible = $_SERVER['accessible'];

        $index = 0;
        foreach ($accessible as $die) {
            $expected[] = $index;
            $strDie = implode(' ', $die);
            Messenger::message("{$index} [{$strDie}]");
            $index++;


        }
        Messenger::message(self::BASIC_UI);
        return self::readInput($expected);
    }

    private static function readInput(array $expected)
    {
        $input = readline();
        switch (strtolower($input)) {
            case 'x':
                die();
            case '?':
                Messenger::help();
                break;
            case 't':
                TableDrawer::DrawTable();
                break;
            default:
        }
        foreach ($expected as $val) {
            if ($val == $input) return $val;
        }
        throw new \Exception("Invalid input,please select one of suggested options.");
    }
}