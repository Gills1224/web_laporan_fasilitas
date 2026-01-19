<?php
// panduan.php

$pdfPath = "panduan/buku_panduan.pdf";

if (file_exists($pdfPath)) {
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=buku_panduan.pdf");
    readfile($pdfPath);
    exit;
} else {
    echo "File panduan tidak ditemukan.";
}
