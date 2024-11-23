<?php
    include"conf/config.php";
    $menu = @$_GET['menu'];
    
    $sesuser = $_SESSION;

    if(empty($sesuser['id_pengguna'])){
        //Kalau belum login
        header('Location: index.php');
    }else{
        //Kalau sudah login

        $queryses = mysqli_query($con, "SELECT * FROM pengguna WHERE id_pengguna = '".$sesuser['id_pengguna']."'");
        $sesdata = mysqli_fetch_array($queryses);

        if(empty($sesdata['gambar'])){
            //kalau tidak ada gambar
            $gambaruser = "img/default.avif";
        }else{
            //kalau ada gambarnya
            $gambaruser = "berkas/pengguna/".$sesdata['gambar'];
        }
?>
<!DOCTYPE html>
<html lang="en">

        <?php
            include"inc/meta_head.php";
        ?>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <?php
            include"inc/sidebar.php";
        ?>

        <div class="content">
            
            <?php
                include"inc/nav.php";

                
                
                if(empty($menu) || $menu == "beranda"){
                    include"menu/beranda.php";
                }else if($menu == "user"){
                    include"menu/user.php";
                }else{
                    echo"
                        <h1>Error 404</h1>
                        <h2>Halaman tidak ditemukan...</h2>
                    ";
                }

                include"inc/footer.php";
            ?>
        </div>


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <?php
        include"inc/meta_footer.php";
    ?>

    
</body>

</html>
<?php } ?>