<?php
$server = "localhost";
$username = "root";
$password = "";
$conn = new mysqli($server, $username, $password);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil daftar database
$databases = [];
$result = $conn->query("SHOW DATABASES");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $databases[] = $row['Database'];
    }
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['create_database'])) {
        $newDatabase = $_POST['new_database_name'];
        $sqlCreateDb = "CREATE DATABASE IF NOT EXISTS `$newDatabase`";
        if ($conn->query($sqlCreateDb) === TRUE) {
            $message = "Database <strong>$newDatabase</strong> berhasil dibuat.";
            $databases[] = $newDatabase;
        } else {
            $message = "Gagal membuat database: " . $conn->error;
        }
    } elseif (isset($_POST['create_table'])) {
        $database = $_POST['database_name'];
        $tableName = $_POST['table_name'];
        $columnsArray = $_POST['columns'];

        $columns = [];
        foreach ($columnsArray as $column) {
            $columnParts = explode(" ", $column, 2);
            if (count($columnParts) === 2) {
                $columnName = trim($columnParts[0]);
                $columnType = trim($columnParts[1]);
                if (!empty($columnName) && !empty($columnType)) {
                    $columns[] = "`$columnName` $columnType";
                }
            }
        }

        if (empty($columns)) {
            $message = "Kolom tidak valid. Pastikan setiap kolom berformat 'nama tipe'.";
        } else {
            $conn->select_db($database);
            $columnsSql = implode(", ", $columns);
            $sqlCreateTable = "CREATE TABLE IF NOT EXISTS `$tableName` (id INT AUTO_INCREMENT PRIMARY KEY, $columnsSql)";
            if ($conn->query($sqlCreateTable) === TRUE) {
                $message = "Tabel <strong>$tableName</strong> berhasil dibuat di database <strong>$database</strong>.";
            } else {
                $message = "Gagal membuat tabel: " . $conn->error;
            }
        }
    } elseif (isset($_POST['insert_data'])) {
        $database = $_POST['database_name'];
        $tableName = $_POST['table_name'];
        $dataColumns = $_POST['data_columns'];
        $dataValues = $_POST['data_values'];

        $conn->select_db($database);
        $columnsSql = implode(", ", array_map('trim', $dataColumns));
        $valuesSql = implode(", ", array_map(function ($value) {
            return "'" . trim($value) . "'";
        }, $dataValues));

        $sqlInsert = "INSERT INTO `$tableName` ($columnsSql) VALUES ($valuesSql)";
        if ($conn->query($sqlInsert) === TRUE) {
            $message = "Data berhasil ditambahkan ke tabel <strong>$tableName</strong>.";
        } else {
            $message = "Gagal menambahkan data: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Database</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Manajemen Database</h1>
        <?php if (!empty($message)): ?>
        <div class="alert alert-info" role="alert">
            <?= $message; ?>
        </div>
        <?php endif; ?>

        <!-- Form membuat database -->
        <div class="card mb-4">
            <div class="card-body">
                <h3>Buat Database Baru</h3>
                <form method="POST">
                    <div class="mb-3">
                        <label for="new_database_name" class="form-label">Nama Database Baru</label>
                        <input type="text" id="new_database_name" name="new_database_name" class="form-control"
                            placeholder="Masukkan nama database baru" required>
                    </div>
                    <button type="submit" name="create_database" class="btn btn-primary w-100">Buat Database</button>
                </form>
            </div>
        </div>

        <!-- Form membuat tabel -->
        <div class="card mb-4">
            <div class="card-body">
                <h3>Buat Tabel</h3>
                <form method="POST">
                    <div class="mb-3">
                        <label for="database_name" class="form-label">Pilih Database</label>
                        <select id="database_name" name="database_name" class="form-select" required>
                            <?php foreach ($databases as $db): ?>
                            <option value="<?= $db; ?>"><?= $db; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="table_name" class="form-label">Nama Tabel</label>
                        <input type="text" id="table_name" name="table_name" class="form-control"
                            placeholder="Masukkan nama tabel" required>
                    </div>
                    <div id="columns-container">
                        <label class="form-label">Kolom Tabel</label>
                        <div class="mb-3 d-flex">
                            <input type="text" name="columns[]" class="form-control me-2"
                                placeholder="contoh: nama VARCHAR(255)" required>
                            <button type="button" class="btn btn-danger remove-column">Hapus</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary mb-3" id="add-column">Tambah Kolom</button>
                    <button type="submit" name="create_table" class="btn btn-primary w-100">Buat Tabel</button>
                </form>
            </div>
        </div>

        <!-- Form menambah data -->
        <div class="card">
            <div class="card-body">
                <h3>Tambah Data ke Tabel</h3>
                <form method="POST">
                    <div class="mb-3">
                        <label for="database_name_data" class="form-label">Pilih Database</label>
                        <select id="database_name_data" name="database_name" class="form-select" required>
                            <?php foreach ($databases as $db): ?>
                            <option value="<?= $db; ?>"><?= $db; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="table_name_data" class="form-label">Nama Tabel</label>
                        <input type="text" id="table_name_data" name="table_name" class="form-control"
                            placeholder="Masukkan nama tabel" required>
                    </div>
                    <div id="data-container">
                        <label class="form-label">Kolom dan Nilai</label>
                        <div class="mb-3 d-flex">
                            <input type="text" name="data_columns[]" class="form-control me-2"
                                placeholder="Kolom (contoh: nama)" required>
                            <input type="text" name="data_values[]" class="form-control me-2"
                                placeholder="Nilai (contoh: John Doe)" required>
                            <button type="button" class="btn btn-danger remove-data">Hapus</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary mb-3" id="add-data">Tambah Data</button>
                    <button type="submit" name="insert_data" class="btn btn-primary w-100">Tambah Data</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Tambah kolom tabel
        document.getElementById('add-column').addEventListener('click', function () {
            const container = document.getElementById('columns-container');
            const newField = document.createElement('div');
            newField.classList.add('mb-3', 'd-flex');
            newField.innerHTML = `
                <input type="text" name="columns[]" class="form-control me-2" placeholder="contoh: nama VARCHAR(255)" required>
                <button type="button" class="btn btn-danger remove-column">Hapus</button>
            `;
            container.appendChild(newField);

            newField.querySelector('.remove-column').addEventListener('click', function () {
                newField.remove();
            });
        });

        // Tambah data
        document.getElementById('add-data').addEventListener('click', function () {
            const container = document.getElementById('data-container');
            const newField = document.createElement('div');
            newField.classList.add('mb-3', 'd-flex');
            newField.innerHTML = `
                <input type="text" name="data_columns[]" class="form-control me-2" placeholder="Kolom (contoh: nama)" required>
                <input type="text" name="data_values[]" class="form-control me-2" placeholder="Nilai (contoh: John Doe)" required>
                <button type="button" class="btn btn-danger remove-data">Hapus</button>
            `;
            container.appendChild(newField);

            newField.querySelector('.remove-data').addEventListener('click', function () {
                newField.remove();
            });
        });
    </script>
</body>

</html>
