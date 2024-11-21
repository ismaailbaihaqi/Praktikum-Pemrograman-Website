<?php
$data = json_decode(file_get_contents('data/data.json'), true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD PHP Native</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- Navbar dengan Bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">
            <!-- Brand logo and name -->
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                CRUD Application
            </a>

            <!-- Toggle button for mobile view -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="create.php">Tambah Data</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container mt-5">
        <h1 class="mb-4 text-center text-primary">Daftar Data</h1>
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($data) > 0): ?>
                    <?php foreach ($data as $index => $item): ?>
                    <tr>
                        <td class="text-center"><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['email']); ?></td>
                        <td><?php echo htmlspecialchars($item['dob']); ?></td>
                        <td><?php echo htmlspecialchars($item['address']); ?></td>
                        <td class="text-center">
                            <?php if (!empty($item['image'])): ?>
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Gambar"
                                style="max-width: 150px; height: auto; border-radius: 8px;">
                            <?php else: ?>
                            <span class="text-muted">Tidak ada gambar</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="edit.php?id=<?php echo $index; ?>"
                                    class="btn btn-outline-primary btn-sm me-2 d-flex align-items-center"
                                    style="border-radius: 20px; min-width: 80px;">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <a href="delete.php?id=<?php echo $index; ?>"
                                    class="btn btn-outline-danger btn-sm d-flex align-items-center"
                                    style="border-radius: 20px; min-width: 80px;">
                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <span class="text-muted">Tidak ada data.</span>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Menambahkan link ke Bootstrap JS dan Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz4fnFO9gybQg9s4F18y5lbh4fp4k35FiWvLkN4+bS1p0r7AK50TtR1s2J6" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-c5e2hOPIh6gZseOPPQ1yExQyC44l88n5wUyIMZz0ONuzgz2ccWp63ws6JQvnLsF3" crossorigin="anonymous">
    </script>
</body>

</html>