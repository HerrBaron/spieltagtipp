<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$nextWeek = time() + (7 * 24 * 60 * 60);
                   // 7 Tage; 24 Stunden; 60 Minuten; 60 Sekunden
echo 'Jetzt:          '. date('Y-m-d') ."\n";
echo 'Naechste Woche: '. date('Y-m-d', $nextWeek) ."\n";
// oder strtotime() verwenden:
echo 'Naechste Woche: '. date('Y-m-d', strtotime('+1 week')) ."\n";

?>

