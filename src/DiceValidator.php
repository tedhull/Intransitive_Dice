<?php

namespace App;
class DiceValidator
{
    static public function validate_dice($arr): array
    {
        if (count($arr) <= 2) throw new \Exception("You don't have enough dice!");
        $nums = self::explodeDice($arr);
        $dice = self::toSortedArrays($nums);
        $first = $dice[0];
        $last = $dice[array_key_last($dice)];
        for ($i = 0; $i < count($dice) - 1; $i++) {
            self::compare($dice[$i], $dice[$i + 1]);
        }
        self::compare($last, $first);
        return $nums;
    }

    private static function compare($dieA, $dieB): void
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
        if ($winChance <= 0.5 || $winChance >= 1) throw new \Exception("Dice don't correspond the rules!");
    }

    private static function toSortedArrays(array $nums): array
    {
        $result = [];
        foreach ($nums as $die) {
            $counted = array_count_values($die);
            ksort($counted);
            $sorted = [];
            foreach ($counted as $val => $count) {
                if (intval($val) != $val || floor($val) != $val) throw new \Exception("all numbers should be whole!");
                $sorted[] = ['val' => $val, 'count' => $count,];
            }
            $sorted['total'] = array_sum($counted);
            $result[] = $sorted;
        }
        return $result;
    }

    public static function explodeDice($strings): array
    {
        $nums = [];
        foreach ($strings as $string) {
            $nums[] = explode(",", $string);
        }
        return $nums;
    }
}