<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($con, $_POST['nama']);
    $hp = mysqli_real_escape_string($con, $_POST['hp']);
    $alamat = mysqli_real_escape_string($con, $_POST['alamat']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    
    // Upload file gambar
    $gambar = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $upload_dir = "uploads/";
    $upload_path = $upload_dir . basename($gambar);

    // Pindahkan file gambar ke folder uploads
    if (move_uploaded_file($gambar_tmp, $upload_path)) {
        // Query untuk simpan data
        $sql = "INSERT INTO pengguna (nama, hp, alamat, username, password, gambar) 
                VALUES ('$nama', '$hp', '$alamat', '$username', '$password', '$gambar')";

        if (mysqli_query($con, $sql)) {
            echo "<script>alert('Data berhasil disimpan!');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    } else {
        echo "<script>alert('Gagal mengupload gambar.');</script>";
    }
}
?>


<div class="container-fluid pt-4 px-4">
    <h2>Data Pengguna</h2>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="m-0">Data Pengguna</h4>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahModal">
                Tambah
            </button>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>HP</th>
                    <th>Alamat</th>
                    <th>Username</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $nodata = 1;
                    $sdata = mysqli_query($con, "SELECT * FROM pengguna");
                    while($ddata = mysqli_fetch_array($sdata)){
                        echo'
                            <tr>
                                <td>'.$nodata.'</td>
                                <td>'.$ddata['nama'].'</td>
                                <td>'.$ddata['hp'].'</td>
                                <td>'.$ddata['alamat'].'</td>
                                <td>'.$ddata['username'].'</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        ';
                        $nodata++;
                    }
                ?>
            </tbody>
        </table>
    </div>

</div>




<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Data Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="hp" class="form-label">HP</label>
                            <input type="text" class="form-control" id="hp" name="hp" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>