<?php
/*
* Mencetak string
* $teks nilai string
* $bold adalah argumen opsional
*/
function print_teks($teks, $bold = true) {
    echo $bold ? '<b>' .$teks. '</b>' : $teks;
}
print_teks('POLITEKNIK');
// Mencetak dengan huruf tebal

print_teks('PURBAYA', false);
// Mencetak dengan huruf reguler
?>