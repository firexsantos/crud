<title>Data Pengguna</title>
<div class="container-fluid pt-4 px-4">
    <h2>Data Pengguna</h2>


    <?php
        if (isset($_POST['tambahin'])) {
            $nama = mysqli_real_escape_string($con, $_POST['nama']);
            $hp = mysqli_real_escape_string($con, $_POST['hp']);
            $alamat = mysqli_real_escape_string($con, $_POST['alamat']);
            $username = mysqli_real_escape_string($con, $_POST['username']);
            $password = mysqli_real_escape_string($con, $_POST['password']);
            
            // Upload file gambar
            $gambar = $_FILES['gambar']['name'];
            $gambar_tmp = $_FILES['gambar']['tmp_name'];
            $upload_dir = "berkas/pengguna/";
            $upload_path = $upload_dir . basename($gambar);

            // Pindahkan file gambar ke folder uploads
            if (move_uploaded_file($gambar_tmp, $upload_path)) {
                // Query untuk simpan data
                $sql = "INSERT INTO pengguna (nama, hp, alamat, username, `password`, gambar) 
                        VALUES ('$nama', '$hp', '$alamat', '$username', '$password', '$gambar')";

                $proses = mysqli_query($con, $sql);

                if($proses){
                echo"<div class='alert alert-success'>Berhasil menambah data.</div>";
                }else{
                    echo"<div class='alert alert-danger'>Terjadi kesalahan, gagal menambah data.</div>";
                }
            } else {
                echo"<div class='alert alert-danger'>Terjadi kesalahan, gagal mengupload berkas gambar.</div>";
            }
        }else if (isset($_POST['editin'])) {
            $nama = mysqli_real_escape_string($con, $_POST['nama']);
            $hp = mysqli_real_escape_string($con, $_POST['hp']);
            $alamat = mysqli_real_escape_string($con, $_POST['alamat']);
            $username = mysqli_real_escape_string($con, $_POST['username']);
            
            // Upload file gambar
            $gambar = $_FILES['gambar']['name'];
            $gambar_tmp = $_FILES['gambar']['tmp_name'];
            $upload_dir = "berkas/pengguna/";
            $upload_path = $upload_dir . basename($gambar);

            // Pindahkan file gambar ke folder uploads
            if (move_uploaded_file($gambar_tmp, $upload_path)) {
                // Query untuk simpan data
                $sql = "UPDATE pengguna SEt nama = '$nama', hp = '$hp', alamat = '$alamat', username = '$username', gambar = '$gambar' WHERE id_pengguna = '".$_POST['id']."'";
            } else {
                $sql = "UPDATE pengguna SEt nama = '$nama', hp = '$hp', alamat = '$alamat' WHERE id_pengguna = '".$_POST['id']."'";
            }

            $proses = mysqli_query($con, $sql);

            if($proses){
            echo"<div class='alert alert-success'>Berhasil mengubah data.</div>";
            }else{
                echo"<div class='alert alert-danger'>Terjadi kesalahan, gagal mengubah data.</div>";
            }
        }else if(isset($_POST['hapusin'])){
            $proses = mysqli_query($con, "DELETE FROM pengguna WHERE id_pengguna = '".$_POST['id']."'");
            if($proses){
                echo"<div class='alert alert-success'>Berhasil menghapus data.</div>";
            }else{
                echo"<div class='alert alert-danger'>Terjadi kesalahan, gagal menghapus data.</div>";
            }
        }
    ?>


    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="m-0">Data Pengguna</h4>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahModal">
                Tambah
            </button>
        </div>

        <div class="card-body">
            <table class="table table-hover mb-0 data_tabel">
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
                                    <td>
                                        <img src="berkas/pengguna/'.$ddata['gambar'].'" class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                        '.$ddata['nama'].'
                                    </td>
                                    <td>'.$ddata['hp'].'</td>
                                    <td>'.$ddata['alamat'].'</td>
                                    <td>'.$ddata['username'].'</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-primary btn-sm btedit" data-bs-toggle="modal" data-bs-target="#modalEdit" data-id="'.$ddata['id_pengguna'].'" data-nama="'.$ddata['nama'].'" data-hp="'.$ddata['hp'].'" data-alamat="'.$ddata['alamat'].'" data-username="'.$ddata['username'].'"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-danger btn-sm bthapus" data-bs-toggle="modal" data-bs-target="#modalHapus" data-id="'.$ddata['id_pengguna'].'" data-nama="'.$ddata['nama'].'"><i class="fa fa-trash"></i></a>
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
                        <button type="submit" class="btn btn-primary" name="tambahin">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id_edit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditLabel">Edit Data Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama_edit" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="hp" class="form-label">HP</label>
                            <input type="text" class="form-control" id="hp_edit" name="hp" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat_edit" name="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username_edit" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="gambar_edit" name="gambar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" name="editin">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id_hapus">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalHapusLabel">Konfirmasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger text-center">
                            Anda yakin akan menghapus data <b id="nama_hapus"></b>? Data yang sudah dihapus tidak bisa dikembalikan lagi.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger" name="hapusin">Ya! Hapus data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script> 

        $(document).ready(function() {

            new DataTable('.data_tabel');

            $(document).on('click', '.bthapus', function() {
                const id 	= $(this).data('id');
                const nama 	= $(this).data('nama');
                $('#id_hapus').val(id);
                document.getElementById("nama_hapus").innerHTML = nama;
            });

            $(document).on('click', '.btedit', function() {
                const id 	= $(this).data('id');
                const nama 	= $(this).data('nama');
                const hp 	= $(this).data('hp');
                const alamat 	= $(this).data('alamat');
                const username 	= $(this).data('username');
                $('#id_edit').val(id);
                $('#nama_edit').val(nama);
                $('#hp_edit').val(hp);
                $('#alamat_edit').val(alamat);
                $('#username_edit').val(username);
            });
        });
    </script>