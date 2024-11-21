<?php
$id = $_GET['id'] ?? null;
$data = json_decode(file_get_contents('data/data.json'), true);

if ($id !== null && isset($data[$id])) {
    $imagePath = $data[$id]['image'] ?? null;

    // Hapus data dari array dan re-index
    unset($data[$id]);
    $data = array_values($data); // Re-index array

    // Simpan kembali data yang diperbarui
    file_put_contents('data/data.json', json_encode($data));

    // Hapus gambar jika ada
    if ($imagePath && file_exists($imagePath)) {
        unlink($imagePath);
    }

    header('Location: index.php');
    exit();
} else {
    echo 'Data tidak ditemukan.';
    exit();
}