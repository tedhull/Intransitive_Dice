<?php

namespace App;
class ProbabilityComputer
{
    public static function ComputeProbabilities()
    {
        $map = [];
        $dice = $_SERVER['dice'];
        for ($i = 0; $i < count($dice); $i++) {
            $map[] = ['die' => implode(' ', $dice[$i])];
            for ($j = 0; $j < count($dice); $j++) {
                if ($i == $j) $map[$i][] = "-";
                else $map[$i][] = self::winProbability($j, $i, count($dice));
            }
        }
        return $map;
    }

    private static function winProbability($m, $n, $N)
    {
        $delta = ($n - $m + $N) % $N;
        $result = 1 - (0.5 + (1 / (2 * $N)) - ($delta / ($N * $N)));
        return round($result, 2);
    }
}