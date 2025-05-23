<?php

class GameProcessor
{
    public static function Process($userMovesFirst)
    {
        if($userMovesFirst) Messenger::message("You move first");
        else Messenger::message("I move first");
    }
}