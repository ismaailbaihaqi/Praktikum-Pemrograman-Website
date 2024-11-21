<?php
$data = json_decode(file_get_contents('data/data.json'), true);

$id = $_GET['id'];

// Hapus transaksi dari array
unset($data['transactions'][$id]);

// Simpan kembali data ke file JSON
file_put_contents('data/data.json', json_encode($data, JSON_PRETTY_PRINT));

// Redirect kembali ke index.php
header('Location: index.php');
exit();
?>
