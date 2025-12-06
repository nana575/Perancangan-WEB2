<?php

// gunakan variable koneksi yang benar
// yaitu: $koneksi

$query = mysqli_query($koneksi, "SELECT COUNT(id_mahasiswa) FROM tb_mahasiswa");
$row = mysqli_fetch_row($query);
$rows = $row[0];

$page_rows = 2;
$last = ceil($rows / $page_rows);

if ($last < 1) {
    $last = 1;
}

$pagenum = 1;
if (isset($_GET['pn'])) {
    $pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
}

if ($pagenum < 1) {
    $pagenum = 1;
} elseif ($pagenum > $last) {
    $pagenum = $last;
}

$limit = 'LIMIT ' . (($pagenum - 1) * $page_rows) . ',' . $page_rows;

$nquery = mysqli_query($koneksi, "SELECT * FROM tb_mahasiswa $limit");

$paginationCtrls = '';

if ($last != 1) {
    if ($pagenum > 1) {
        $previous = $pagenum - 1;
        $paginationCtrls .= '<a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '" class="btn btn-secondary">Previous</a> &nbsp; ';
        
        for ($i = $pagenum - 2; $i < $pagenum; $i++) {
            if ($i > 0) {
                $paginationCtrls .= '<a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $i . '" class="btn btn-light">' . $i . '</a> ';
            }
        }
    }

    $paginationCtrls .= '<span class="btn btn-primary">' . $pagenum . '</span> ';

    for ($i = $pagenum + 1; $i <= $last; $i++) {
        $paginationCtrls .= '<a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $i . '" class="btn btn-light">' . $i . '</a> ';
        if ($i >= $pagenum + 2) {
            break;
        }
    }

    if ($pagenum != $last) {
        $next = $pagenum + 1;
        $paginationCtrls .= '<a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $next . '" class="btn btn-secondary">Next</a>';
    }
}

?>
