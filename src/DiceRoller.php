<?php
namespace App;
class DiceRoller
{
    public static function roll($player, $bot)
    {
        $player = self::rollDie($player, "Your");
        $bot = self::rollDie($bot, "My");

        switch ($player) {
            case $player > $bot:
                Messenger::message("$player is bigger than $bot, you won\nCongrats!");
                break;
            case  $player < $bot:
                Messenger::message("$bot is bigger than $player, I won\nBetter luck nex time!");
                break;

            default:
                Messenger::message("Draw!");
                break;
        }
    }
    private static function rollDie($die, string $roller)
    {
        $num = $die[random_int(0,count($die)-1)];
        $key = hash('sha3-512',random_bytes(16));
        $hash = hash_hmac('sha3-512', $num, $key);
        Messenger::message("I roll $roller dice, there is a random value\n(HMAC={$hash})\n Choose number under 6");
        while (true) {
            $input = UIDrawer::chooseNumber();
            if ($input == -1) continue;
            else break;
        }
        $sum = $num + $input;
        Messenger::message("Random number is {$input}\n My number is {$num} \n(KEY={$key})\n");
        Messenger::message("fair generation: $num+$input=$sum");
        return $num;
    }
}