<?php
$id = $_GET['id'] ?? null;
$data = json_decode(file_get_contents('data/data.json'), true);

if ($id !== null && isset($data['products'][$id])) {
    $product = $data['products'][$id];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $product['name'] = $_POST['name'];
        $product['description'] = $_POST['description'];
        $product['type'] = $_POST['type'];
        $product['price'] = $_POST['price'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $targetDir = 'uploads/';
            $imageName = time() . '_' . basename($_FILES['image']['name']);
            $targetFilePath = $targetDir . $imageName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $product['image'] = $targetFilePath;
            }
        }

        $data['products'][$id] = $product;
        file_put_contents('data/data.json', json_encode($data));

        header('Location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand" href="index.php">Electronics CRUD</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4">Edit Product</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" required><?= htmlspecialchars($product['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Product Type</label>
                <input type="text" class="form-control" name="type" value="<?= htmlspecialchars($product['type']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" class="form-control" name="image">
                <?php if ($product['image']): ?>
                    <img src="<?= $product['image'] ?>" alt="Product Image" class="img-fluid mt-3" style="max-width: 200px;">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
