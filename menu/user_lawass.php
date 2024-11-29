<?php
    $title = "Data Pengguna";

    // Tambah Data
    if (isset($_POST['tambah'])) {
        $nama = $_POST['nama'];
        $hp = $_POST['hp'];
        $alamat = $_POST['alamat'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO pengguna (nama, hp, alamat, username, password) VALUES ('$nama', '$hp', '$alamat', '$username', '$password')";
        mysqli_query($con, $sql);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Edit Data
    if (isset($_POST['edit'])) {
        $id_pengguna = $_POST['id_pengguna'];
        $nama = $_POST['nama'];
        $hp = $_POST['hp'];
        $alamat = $_POST['alamat'];
        $username = $_POST['username'];

        $sql = "UPDATE pengguna SET nama='$nama', hp='$hp', alamat='$alamat', username='$username' WHERE id_pengguna='$id_pengguna'";
        mysqli_query($con, $sql);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Hapus Data
    if (isset($_GET['hapus'])) {
        $id_pengguna = $_GET['hapus'];
        $sql = "DELETE FROM pengguna WHERE id_pengguna='$id_pengguna'";
        mysqli_query($con, $sql);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
?>

<title><?= $title ?></title>
<div class="container-fluid pt-4 px-4">
    <h3><?= $title ?></h3>
    <div class="card">
        <div class="card-header fw-bold text-uppercase d-flex justify-content-between align-items-center">
            <?= $title ?>
            <a href="#" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalTambahData">
                <i class="fa fa-plus me-2"></i> Tambah Data
            </a>
        </div>
        <div class="card-body">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nama</th>
                        <th>HP</th>
                        <th>Alamat</th>
                        <th>Username</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nodata = 1;
                    $sdata = mysqli_query($con, "SELECT * FROM pengguna");
                    while ($ddata = mysqli_fetch_array($sdata)) {
                        echo "
                            <tr>
                                <td class='text-center'>$nodata</td>
                                <td>{$ddata['nama']}</td>
                                <td>{$ddata['hp']}</td>
                                <td>{$ddata['alamat']}</td>
                                <td>{$ddata['username']}</td>
                                <td class='text-center'>
                                    <div class='btn-group'>
                                        <a href='#' data-bs-toggle='modal' data-bs-target='#modalEditData{$ddata['id_pengguna']}' class='btn btn-primary btn-sm'><i class='fa fa-edit'></i></a>
                                        <a href='?hapus={$ddata['id_pengguna']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus data ini?\")'><i class='fa fa-trash'></i></a>
                                    </div>
                                </td>
                            </tr>
                        ";
                        $nodata++;
                    ?>
                    <!-- Modal Edit -->
                    <div class="modal fade" id="modalEditData<?= $ddata['id_pengguna'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id_pengguna" value="<?= $ddata['id_pengguna'] ?>">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" name="nama" value="<?= $ddata['nama'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="hp" class="form-label">HP</label>
                                            <input type="text" class="form-control" name="hp" value="<?= $ddata['hp'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" name="alamat" rows="3" required><?= $ddata['alamat'] ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" name="username" value="<?= $ddata['username'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="edit" class="btn btn-success">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahData" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="hp" class="form-label">HP</label>
                        <input type="text" class="form-control" name="hp" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        new DataTable('.data_tabel');
    });
</script>