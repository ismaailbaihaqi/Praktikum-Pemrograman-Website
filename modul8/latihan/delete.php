<?php
$id = $_GET['id'] ?? null;
$data = json_decode(file_get_contents('data/data.json'), true);

if ($id !== null && isset($data['products'][$id])) {
    unset($data['products'][$id]);
    $data['products'] = array_values($data['products']); // Re-index the array

    file_put_contents('data/data.json', json_encode($data));
}

header('Location: index.php');
exit();
