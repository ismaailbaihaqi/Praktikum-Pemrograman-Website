<?php
$id = $_GET['id'] ?? null;
$data = json_decode(file_get_contents('data/data.json'), true);

if ($id !== null && isset($data[$id])) {
    $item = $data[$id];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];
        $imagePath = $item['image']; // Default to current image path

        // Process image upload if a file is uploaded
        if (!empty($_FILES['image']['name'])) {
            $targetDir = 'uploads/';
            $imageName = time() . '_' . basename($_FILES['image']['name']);
            $targetFilePath = $targetDir . $imageName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $imagePath = $targetFilePath;
            }
        }

        // Update data
        $data[$id] = [
            'name' => $name,
            'email' => $email,
            'dob' => $dob,
            'address' => $address,
            'image' => $imagePath
        ];

        file_put_contents('data/data.json', json_encode($data));

        header('Location: index.php');
        exit();
    }
} else {
    echo 'Data tidak ditemukan.';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .form-floating>.form-control:focus {
            border-color: #6c757d;
            box-shadow: none;
        }

        .navbar {
            border-bottom: 2px solid #ddd;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                CRUD Application
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="create.php">Tambah Data</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4">Edit Data</h1>
        <form method="POST" enctype="multipart/form-data">
            <!-- Nama -->
            <div class="form-floating mb-3">
                <input type="text" id="name" name="name" class="form-control" placeholder="Nama" value="<?php echo htmlspecialchars($item['name']); ?>" required>
                <label for="name">Nama:</label>
            </div>

            <!-- Email -->
            <div class="form-floating mb-3">
                <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?php echo htmlspecialchars($item['email']); ?>" required>
                <label for="email">Email:</label>
            </div>

            <!-- Tanggal Lahir -->
            <div class="form-floating mb-3">
                <input type="date" id="dob" name="dob" class="form-control" placeholder="Tanggal Lahir" value="<?php echo htmlspecialchars($item['dob']); ?>" required>
                <label for="dob">Tanggal Lahir:</label>
            </div>

            <!-- Alamat -->
            <div class="form-floating mb-3">
                <textarea id="address" name="address" class="form-control" placeholder="Alamat" required><?php echo htmlspecialchars($item['address']); ?></textarea>
                <label for="address">Alamat:</label>
            </div>

            <!-- Gambar -->
            <div class="mb-3">
                <label for="image" class="form-label">Gambar:</label>
                <input type="file" id="image" name="image" class="form-control">
                <?php if (!empty($item['image']) && file_exists($item['image'])): ?>
                <div class="mt-3">
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Gambar" class="img-thumbnail" style="max-width: 100px;">
                </div>
                <?php endif; ?>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybQg9s4F18y5lbh4fp4k35FiWvLkN4+bS1p0r7AK50TtR1s2J6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-c5e2hOPIh6gZseOPPQ1yExQyC44l88n5wUyIMZz0ONuzgz2ccWp63ws6JQvnLsF3" crossorigin="anonymous"></script>
</body>

</html>