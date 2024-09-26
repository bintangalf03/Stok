<?php
$kon = mysqli_connect("localhost", "root", "", "stok");

if (!$kon) {
    die("gagal: " . mysqli_connect_error());
}

$adminQuery = "SELECT username FROM admin WHERE id = 1"; 
$adminResult = mysqli_query($kon, $adminQuery);
$adminRow = mysqli_fetch_assoc($adminResult);
$adminName = $adminRow['username'] ?? 'admin'; 

$checkStockQuery = "SELECT * FROM inventory WHERE jml_stok <= 0";
$stockResult = mysqli_query($kon, $checkStockQuery);
$showStockAlert = (mysqli_num_rows($stockResult) > 0);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="../aset/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000; 
        }

        .sidebar {
            background-color: #333; 
            color: yellow;
            height: 95vh;
        }

        .sidebar h3 {
            padding: 15px;
            text-align: center;
        }

        .nav-link {
            color: grey; 
            font-weight: bold;
            padding: 10px 15px; 
        }

        .nav-link.active {
            background-color: #0056b3; 
        }

        .nav-link:hover {
            background-color: #0056b3; 
            color: red; 
        }    
        .table thead th {
            background-color: #007bff; 
            color: black;
        }

        .table-danger {
            background-color: #f8d7da;
        }

        .table-hover tbody tr:hover {
            background-color: #e2e3e5; 
        }

        .btn-primary, .btn-success, .btn-danger {
            margin: 10px; 
        }

        footer {
            background-color: #333; 
            color: white;
            padding: 10px 0;
        }

        .search-form {
            width: 40%; 
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky pt-3">
                    <h4>Admin</h4>
                    <br>
                    <br>
                    <br>
                    <br>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#inventory" data-bs-toggle="tab">
                                Inventory
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#storage" data-bs-toggle="tab">
                                Storage
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#vendor" data-bs-toggle="tab">
                                Vendor
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <button class='btn btn-sm btn-outline'>
                            <a style="text-decoration: none;" class='text-white' href="../logout.php">Logout</a>
                            </button>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="text-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-primary">Welcome To Dashboard Admin, <?php echo htmlspecialchars($adminName); ?></h1>
    <form method="get" class="search-form d-inline-flex justify-content-center">
        <input type="text" class="form-control me-2" name="search" placeholder="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button class="btn btn-sm btn-outline-secondary" type="submit">Search</button>
    </form>
</div>


                <div class="tab-content">
                    <div class="tab-pane fade show active" id="inventory">
                        <h3 class="text-secondary">Tabel Inventory</h3>
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Jenis Barang</th>
                                    <th>Harga</th>
                                    <th>Jumlah Stok</th>
                                    <th>Lokasi Gudang</th>
                                    <th>Barcode</th>
                                    <th>Nama Vendor</th>
                                    <th>Pilihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $search = isset($_GET['search']) ? mysqli_real_escape_string($kon, $_GET['search']) : '';
                                $qry = "SELECT * FROM inventory 
                                        INNER JOIN vendor ON inventory.id_vendor = vendor.id_vendor
                                        INNER JOIN storage ON inventory.id_gudang = storage.id_gudang
                                        WHERE inventory.nama_brg LIKE '%$search%' OR
                                              inventory.jenis_brg LIKE '%$search%' OR
                                              vendor.nama_vendor LIKE '%$search%'";

                                $hsl = mysqli_query($kon, $qry);

                                if (!$hsl) {
                                    die("gagal: " . mysqli_error($kon));
                                }
                                while ($dt = mysqli_fetch_assoc($hsl)) {
                                    $rowClass = ($dt['jml_stok'] <= 0) ? 'table-danger' : '';
                                    echo "<tr class='$rowClass'>";
                                    echo "<td>{$dt['id_brg']}</td>";
                                    echo "<td>{$dt['nama_brg']}</td>";
                                    echo "<td>{$dt['jenis_brg']}</td>";
                                    echo "<td>{$dt['harga']}</td>";
                                    echo "<td>{$dt['jml_stok']}</td>";
                                    echo "<td>{$dt['lokasi_gudang']}</td>";
                                    echo "<td>{$dt['barcode']}</td>";
                                    echo "<td>{$dt['nama_vendor']}</td>";
                                    echo "<td>
                                    <button class='btn btn-danger'><a style='text-decoration: none;' class='text-white' href='hapus_inventory.php?id={$dt['id_brg']}' onclick='return confirm(\"Yakin ?\")'>Delete</a></button>
                                    <button class='btn btn-success'><a style='text-decoration: none;' href='edit_inventory.php?id={$dt['id_brg']}' class='text-black'>Edit</a></button>
                                </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <button class="btn btn-sm btn-primary" type="button"><a style="text-decoration: none;" class='text-white' href="tambah_inventory.php">Tambah</a></button>
                    </div>

                    <div class="tab-pane fade" id="storage">
                        <h3 class="text-secondary">Tabel Storage</h3>
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID Gudang</th>
                                    <th>Nama Gudang</th>
                                    <th>Lokasi Gudang</th>
                                    <th>Pilihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $search = isset($_GET['search']) ? mysqli_real_escape_string($kon, $_GET['search']) : '';
                                $qry = "SELECT * FROM storage 
                                        WHERE nama_gudang LIKE '%$search%' OR
                                              lokasi_gudang LIKE '%$search%'";

                                $hsl = mysqli_query($kon, $qry);

                                if (!$hsl) {
                                    die("gagal: " . mysqli_error($kon));
                                }
                                while ($dt = mysqli_fetch_assoc($hsl)) {
                                    echo "<tr>";
                                    echo "<td>{$dt['id_gudang']}</td>";
                                    echo "<td>{$dt['nama_gudang']}</td>";
                                    echo "<td>{$dt['lokasi_gudang']}</td>";
                                    echo "<td>
                                    <button class='btn btn-danger'><a style='text-decoration: none;' class='text-white' href='hapus_storage.php?id={$dt['id_gudang']}' onclick='return confirm(\"Yakin ?\")'>Delete</a></button>
                                    <button class='btn btn-success'><a style='text-decoration: none;' href='edit_storage.php?id={$dt['id_gudang']}' class='text-black'>Edit</a></button>
                                </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <button class="btn btn-sm btn-primary" type="button"><a style="text-decoration: none;" class='text-white' href="tambah_storage.php">Tambah</a></button>
                    </div>

                    <div class="tab-pane fade" id="vendor">
                        <h3 class="text-secondary">Tabel Vendor</h3>
                        <table class="table table-striped table-hover table-bordered">
                            <thead> 
                                <tr>
                                    <th>ID Vendor</th>
                                    <th>Nama Vendor</th>
                                    <th>Kontak</th>
                                    <th>Nama Barang</th>
                                    <th>Pilihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $search = isset($_GET['search']) ? mysqli_real_escape_string($kon, $_GET['search']) : '';
                                $qry = "SELECT * FROM vendor 
                                        WHERE nama_vendor LIKE '%$search%' OR
                                              kontak LIKE '%$search%'";

                                $hsl = mysqli_query($kon, $qry);

                                if (!$hsl) {
                                    die("gagal: " . mysqli_error($kon));
                                }
                                while ($dt = mysqli_fetch_assoc($hsl)) {
                                    echo "<tr>";
                                    echo "<td>{$dt['id_vendor']}</td>";
                                    echo "<td>{$dt['nama_vendor']}</td>";
                                    echo "<td>{$dt['kontak']}</td>";
                                    echo "<td>{$dt['nama_brgg']}</td>";
                                    echo "<td>
                                        <button class='btn btn-danger'><a style='text-decoration: none;' class='text-white' href='hapus_vendor.php?id={$dt['id_vendor']}' onclick='return confirm(\"Yakin ?\")'>Delete</a></button>
                                        <button class='btn btn-success'><a style='text-decoration: none;' href='edit_vendor.php?id={$dt['id_vendor']}' class='text-black'>Edit</a></button>
                                    </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <button class="btn btn-sm btn-primary" type="button"><a style="text-decoration: none;" class='text-white' href="tambah_vendor.php">Tambah</a></button>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <footer class="text-center mt-4">
        <div class="container">
            <p>  - Dashboard Admin Bintang</p>
        </div>
    </footer>

    <script src="../aset/bootstrap.bundle.min.js"></script>

</body>
</html>