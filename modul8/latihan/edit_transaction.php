<?php
$data = json_decode(file_get_contents('data/data.json'), true);

$id = $_GET['id'];
$transaction = $data['transactions'][$id];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['transactions'][$id] = [
        'buyer' => $_POST['buyer'],
        'product' => $_POST['product'],
        'quantity' => $_POST['quantity'],
        'total_price' => $_POST['quantity'] * $data['products'][$_POST['product']]['price'],
        'date' => $_POST['date']
    ];

    file_put_contents('data/data.json', json_encode($data, JSON_PRETTY_PRINT));
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Edit Transaction</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="buyer" class="form-label">Buyer</label>
                <input type="text" name="buyer" id="buyer" class="form-control" value="<?= htmlspecialchars($transaction['buyer']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="product" class="form-label">Product</label>
                <select name="product" id="product" class="form-control" required>
                    <?php foreach ($data['products'] as $productName => $productDetails): ?>
                        <option value="<?= $productName ?>" <?= $productName === $transaction['product'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($productDetails['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="<?= htmlspecialchars($transaction['quantity']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control" value="<?= htmlspecialchars($transaction['date']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Transaction</button>
        </form>
    </div>
</body>
</html>
