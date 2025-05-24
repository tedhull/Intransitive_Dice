<?php

namespace App;

use LucidFrame\Console\ConsoleTable;

class TableDrawer
{
    public static function DrawTable()
    {
        $map = $_SERVER['map'];
        $table = new ConsoleTable();
        $table->addHeader("Die        ");
        //$table->setPadding(5);
        foreach ($map as $die) {
            $table->addHeader($die['die']);
        }

        foreach ($map as $die) {
            $table->addRow($die);
        }
        $table->display();
    }
}