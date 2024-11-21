<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('data/data.json'), true);

    foreach ($_POST['name'] as $index => $name) {
        $email = $_POST['email'][$index];
        $dob = $_POST['dob'][$index];
        $address = $_POST['address'][$index];

        // Proses unggah gambar
        if (isset($_FILES['image']['name'][$index]) && $_FILES['image']['name'][$index] != '') {
            $targetDir = 'uploads/';
            $imageName = time() . '_' . basename($_FILES['image']['name'][$index]);
            $targetFilePath = $targetDir . $imageName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'][$index], $targetFilePath)) {
                $imagePath = $targetFilePath;
            } else {
                $imagePath = null;
            }
        } else {
            $imagePath = null;
        }

        $data[] = [
            'name' => $name,
            'email' => $email,
            'dob' => $dob,
            'address' => $address,
            'image' => $imagePath
        ];
    }

    // Menyimpan data ke file JSON
    file_put_contents('data/data.json', json_encode($data));
    header('Location: index.php'); // Redirect ke halaman utama
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data</title>
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

        .btn-secondary {
            margin-top: 10px;
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
    <h1 class="mb-4">Tambah Data</h1>
    <form method="POST" enctype="multipart/form-data">
        <div id="data-container">
            <!-- Entry Form -->
            <div class="data-entry mb-4">
                <div class="form-floating mb-3">
                    <input type="text" name="name[]" class="form-control" placeholder="Nama" required>
                    <label for="name">Nama:</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" name="email[]" class="form-control" placeholder="Email" required>
                    <label for="email">Email:</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" name="dob[]" class="form-control" placeholder="Tanggal Lahir" required>
                    <label for="dob">Tanggal Lahir:</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea name="address[]" class="form-control" placeholder="Alamat" rows="3" required></textarea>
                    <label for="address">Alamat:</label>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar:</label>
                    <input type="file" name="image[]" class="form-control">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Tambah</button>
    </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybQg9s4F18y5lbh4fp4k35FiWvLkN4+bS1p0r7AK50TtR1s2J6" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-c5e2hOPIh6gZseOPPQ1yExQyC44l88n5wUyIMZz0ONuzgz2ccWp63ws6JQvnLsF3" crossorigin="anonymous"></script>
</body>
</html>