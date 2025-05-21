<?php

class  Inputreader
{
    public static function validate_dice()
    {
        Judje::validate_dice(array_splice($_SERVER['argv'], 1));
    }
}