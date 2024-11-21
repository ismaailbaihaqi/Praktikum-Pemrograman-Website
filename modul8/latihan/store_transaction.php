<?php
// Ambil data JSON dari file
$dataFile = 'data/data.json';
$data = json_decode(file_get_contents($dataFile), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $productIndex = $_POST['product'];
    $quantity = $_POST['quantity'];
    $buyer = $_POST['buyer'];
    $date = $_POST['date'];

    // Validasi: apakah produk ada
    if (!isset($data['products'][$productIndex])) {
        die("Error: Produk yang dipilih tidak valid.");
    }

    // Ambil informasi produk yang dipilih
    $product = $data['products'][$productIndex];
    $productName = $product['name'];
    $productPrice = $product['price'];

    // Hitung total harga
    $totalPrice = $productPrice * $quantity;

    // Buat data transaksi baru
    $newTransaction = [
        'product' => $productName,
        'quantity' => $quantity,
        'buyer' => $buyer,
        'date' => $date,
        'total_price' => $totalPrice
    ];

    // Tambahkan transaksi baru ke array transaksi
    $data['transactions'][] = $newTransaction;

    // Simpan data ke file JSON
    if (file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT))) {
        // Redirect ke halaman utama setelah sukses
        header('Location: index.php?success=1');
        exit;
    } else {
        die("Error: Gagal menyimpan transaksi.");
    }
} else {
    // Jika bukan POST, redirect ke halaman utama
    header('Location: index.php');
    exit;
}
?>
