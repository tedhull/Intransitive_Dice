<?php

class Judje
{
    static public function validate_dice($arr): void
    {
        if (count($arr) <= 2) {
            Messenger::message("You don't have enough dice!");
            return;
        }

        $dice = self::to_arrays($arr);
        $first = $dice[0];
        $last = $dice[array_key_last($dice)];

        for ($i = 0; $i < count($dice) - 1; $i++) {
            self::compare($dice[$i], $dice[$i + 1]);
        }
        self::compare($last, $first);
    }

    private static function compare($dieA, $dieB): void
    {
        $countA = array_count_values($dieA);
        $countB = array_count_values($dieB);

        // Sort by face value
        ksort($countA);
        ksort($countB);
        $sortedA = [];

        foreach ($countA as $val => $count) {
            $sortedA[] = ['val' => $val, 'count' => $count];
        }

        $sortedB = [];
        foreach ($countB as $val => $count) {
            $sortedB[] = ['val' => $val, 'count' => $count];
        }

        $wins = 0;
        $cumulativeB = 0;
        $j = 0;

        foreach ($sortedA as $a) {
            while ($j < count($sortedB) && $sortedB[$j]['val'] < $a['val']) {
                $cumulativeB += $sortedB[$j]['count'];
                $j++;
            }
            $wins += $a['count'] * $cumulativeB;
        }

        $total = array_sum($countA) * array_sum($countB);
        echo $wins / $total;
        echo "\n";

    }

    private static function compare_faces($a, $b): int
    {
        if (floor($a) != $a || floor($b) != $b) throw new exception("you cannot use float");
        return $a <=> $b;
    }

    private static function to_arrays(array $strings): array
    {
        $result = [];
        foreach ($strings as $string) {
            $result[] = explode(",", $string);
        }
        return $result;
    }
}