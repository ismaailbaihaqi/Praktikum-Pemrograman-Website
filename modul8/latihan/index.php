<?php
$data = json_decode(file_get_contents('data/data.json'), true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand" href="index.php">Electronics CRUD</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="create.php">Add Product</a></li>
                    <li class="nav-item"><a class="nav-link" href="create_transaction.php">Add Transaction</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4 text-center">Products List</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['products'] as $index => $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['description']) ?></td>
                        <td><?= htmlspecialchars($product['type']) ?></td>
                        <td><?= htmlspecialchars($product['price']) ?></td>
                        <td>
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image" style="width: 50px; height: 50px; object-fit: cover;">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="update.php?id=<?= $index ?>" class="btn btn-primary">Edit</a>
                            <a href="delete.php?id=<?= $index ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="container mt-5">
        <h1 class="mb-4 text-center">Transactions List</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Buyer</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['transactions'])): ?>
                    <?php foreach ($data['transactions'] as $index => $transaction): ?>
                        <tr>
                            <td><?= htmlspecialchars($transaction['buyer']) ?></td>
                            <td>
                                <?= isset($data['products'][$transaction['product']]['name']) 
                                ? htmlspecialchars($data['products'][$transaction['product']]['name']) 
                                : 'Unknown Product' 
                                ?>
                            </td>
                            <td><?= htmlspecialchars($transaction['quantity']) ?></td>
                            <td><?= htmlspecialchars(number_format($transaction['total_price'], 2)) ?></td>
                            <td><?= htmlspecialchars($transaction['date']) ?></td>
                            <td>
                                <a href="edit_transaction.php?id=<?= $index ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="delete_transaction.php?id=<?= $index ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this transaction?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No transactions found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
