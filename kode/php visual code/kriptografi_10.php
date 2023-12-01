<?php

function konversiAscii($input_string) {
    $ascii_values = [];
    for ($i = 0; $i < strlen($input_string); $i++) {
        $ascii_value = ord($input_string[$i]);
        $ascii_values[] = $ascii_value;
    }
    return $ascii_values;
}

function xorBiner($biner1, $biner2) {
    $result = bindec($biner1) ^ bindec($biner2);
    $result_biner = str_pad(decbin($result), 8, "0", STR_PAD_LEFT);
    return $result_biner;
}

function binerKeDesimal($biner) {
    return bindec($biner);
}

function kodeAscii($ascii_code) {
    return chr($ascii_code);
}

// Input Plaintext dan Kunci dari pengguna
$plaintext = readline("Masukkan Plaintext: ");
$kunci = readline("Masukkan Kunci: ");

// Konversi Plaintext ke ASCII
$ascii_values_plaintext = konversiAscii($plaintext);

// Konversi Kunci ke ASCII
$ascii_values_kunci = konversiAscii($kunci);

// XOR antara ASCII Plaintext dan ASCII Kunci
$hasil_xor = [];
for ($i = 0; $i < strlen($plaintext); $i++) {
    $bin_ascii_plaintext = decbin($ascii_values_plaintext[$i]);
    $bin_ascii_kunci = decbin($ascii_values_kunci[$i % strlen($kunci)]);
    $hasil_xor[] = xorBiner($bin_ascii_plaintext, $bin_ascii_kunci);
}

// Konversi hasil XOR ke Desimal
$hasil_desimal = array_map("binerKeDesimal", $hasil_xor);

// Output Enkripsi
echo "\n=== Hasil Enkripsi ===\n";
echo "Plainteks: $plaintext\n";
echo "Kunci: $kunci\n";

// Menampilkan hasil Enkripsi dalam format yang diminta
$hasil_enkripsi = array_map(function ($desimal, $xor) {
    return ($desimal < 32) ? "ctrl-" . chr($desimal) . " ($xor)" : chr($desimal);
}, $hasil_desimal, $hasil_xor);

echo "Hasil Enkripsi: " . implode(" ", $hasil_enkripsi) . "\n";

// Dekripsi
$hasil_deskripsi = [];
for ($i = 0; $i < strlen($plaintext); $i++) {
    $bin_hasil_desimal = decbin($hasil_desimal[$i]);
    $bin_ascii_kunci = decbin($ascii_values_kunci[$i % strlen($kunci)]);
    $hasil_deskripsi[] = xorBiner($bin_hasil_desimal, $bin_ascii_kunci);
}

$hasil_deskripsi_karakter = array_map("kodeAscii", array_map("binerKeDesimal", $hasil_deskripsi));

// Output Dekripsi
echo "\n=== Hasil Dekripsi ===\n";
echo "Hasil Dekripsi: " . implode("", $hasil_deskripsi_karakter) . "\n";
?>
