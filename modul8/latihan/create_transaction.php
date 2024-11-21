<?php
$data = json_decode(file_get_contents('data/data.json'), true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Transaction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand" href="index.php">Electronics CRUD</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="create.php">Add Product</a></li>
                    <li class="nav-item"><a class="nav-link active" href="create_transaction.php">Add Transaction</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4 text-center">Add Transaction</h1>
        <form action="store_transaction.php" method="POST">
            <div class="mb-3">
                <label for="product" class="form-label">Select Product</label>
                <select name="product" id="product" class="form-control" required>
                    <option value="">-- Select Product --</option>
                    <?php foreach ($data['products'] as $index => $product): ?>
                        <option value="<?= $index ?>">
                            <?= htmlspecialchars($product['name']) ?> - $<?= htmlspecialchars($product['price']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
            </div>
            <div class="mb-3">
                <label for="buyer" class="form-label">Buyer Name</label>
                <input type="text" class="form-control" id="buyer" name="buyer" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Transaction Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <button type="submit" class="btn btn-success">Add Transaction</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
