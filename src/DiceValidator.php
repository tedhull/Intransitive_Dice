<?php
class DiceValidator
{
    static public function validate_dice($arr): void
    {
        if (count($arr) <= 2) {
            Messenger::message("You don't have enough dice!");
            return;
        }
        $dice = self::toSortedArrays($arr);
        $first = $dice[0];
        $last = $dice[array_key_last($dice)];
        for ($i = 0; $i < count($dice) - 1; $i++) {
            self::compare($dice[$i], $dice[$i + 1]);
        }
        self::compare($last, $first);
    }

    private static function compare($dieA, $dieB)
    {
        $countA = array_pop($dieA);
        $countB = array_pop($dieB);
        $wins = 0;
        $faceDuplicates = 0;
        $j = 0;
        foreach ($dieA as $a) {
            while ($j < count($dieB) && $dieB[$j]['val'] < $a['val']) {
                $faceDuplicates += $dieB[$j]['count'];
                $j++;
            }
            $wins += $a['count'] * $faceDuplicates;
        }
        $total = $countA * $countB;
        $winChance = $wins / $total;
        if ($winChance <= 0.5 || $winChance >= 1) throw new exception("Dice don't correspond the rules!");
    }

    private static function toSortedArrays(array $strings): array
    {
        $result = [];
        $nums = [];
        foreach ($strings as $string) {
            $nums[] = explode(",", $string);
        }
        foreach ($nums as $die) {
            $counted = array_count_values($die);
            ksort($counted);
            $sorted = [];
            foreach ($counted as $val => $count) {
                if (!ctype_digit($val)) throw new exception("all numbers should be whole!");
                $sorted[] = ['val' => $val, 'count' => $count,];
            }
            $sorted['total'] = array_sum($counted);
            $result[] = $sorted;
        }
        return $result;
    }
}