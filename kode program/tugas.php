<?php

$a = [4, 6, 9, 13, 18];
for ($i = 1; $i <= 2; $i++) {
    $selisih = $a[count($a) - 1] - $a[count($a) - 2] + 1; // pola selisih bertambah 1
    $a[] = end($a) + $selisih;
}
echo "A: " . implode(", ", $a) . "<br><br>";

$b = [2, 2, 3, 3, 4];
for ($i = 1; $i <= 2; $i++) {
    if (count($b) % 2 == 1) { // tiap dua kali naik 1
        $b[] = end($b);
    } else {
        $b[] = end($b) + 1;
    }
}
echo "B: " . implode(", ", $b) . "<br><br>";

$c = [1, 9, 2, 10, 3];
for ($i = 1; $i <= 2; $i++) {
    if ($i == 1) {
        $c[] = 11; // pola: ganjil naik 1, genap naik 1 juga (9→10→11)
    } else {
        $c[] = 4; // pola: 1→2→3→4
    }
}
echo "C: " . implode(", ", $c);
?>
