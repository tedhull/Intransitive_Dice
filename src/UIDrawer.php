<?php
class UIDrawer
{
    const string BASIC_UI = "X - exit\n? - help\n";
    public static function suggestNumber()
    {
        Messenger::message("0 - 0\n1 - 1\n" . self::BASIC_UI);
        $input = readline();
        return self::readInput($input, [0,1]);
    }
    private static function readInput($input, array $expected)
    {
        switch (strtolower($input)) {
            case 'x': die();
            case '?': Messenger::help(); break;
        }
        foreach($expected as $val){
            if($val == $input) return $val;
        }
        throw new exception("Invalid input,please select one of suggested options.");
    }
}