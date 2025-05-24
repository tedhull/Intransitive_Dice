<?php

namespace App;
class OrderDefiner
{
    static $selectedNum;
    public static function DefineOrder()
    {
        Messenger::message("Let's figure out who makes the first move!");
        $botNum = random_int(0, 1);

        self::$selectedNum = $botNum;
        $key = hash('sha3-512',random_bytes(16));
        $hash = hash_hmac('sha3-512', $botNum, $key);
        Messenger::message("I selected a random number in range 0..1\n(HMAC={$hash})\nTry to guess my selection");
        while (true) {
            $userNum = UIDrawer::suggestNumber();
            if ($userNum == -1) continue;
            Messenger::message("your num is {$userNum}\nMy num is {$botNum}\n(KEY={$key})\n");
            return $userNum == $botNum;
        }
    }
}