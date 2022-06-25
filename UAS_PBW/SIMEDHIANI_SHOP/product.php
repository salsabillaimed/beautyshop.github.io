<?php

error_reporting(1);

    //koneksi Database
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "dbshop";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

    //jikatombol simpan di klik
    if(isset($_POST['bsimpan'])){

        //Pengujian apakah data akan diedit atau disimpan baru
            if($_GET['hal'] == "edit")
            {
                //data akan diedit
                $edit = mysqli_query($koneksi, " UPDATE tproduct set 
                                                    stock = '$_POST[tstock]',
                                                    nama = '$_POST[tnama]',
                                                    shade = '$_POST[tshade]',
                                                    harga = '$_POST[tharga]'
                                                WHERE id = '$_GET[id]'
                                                ");
            
                if($edit) //jika edit sukses
            {
                echo "<script>
                            alert('Data Product berhasil diedit');
                            document.location='product.php';
                        </script>";
            }
            else //jika edit gagal
            {
                echo "<script>
                            alert('Data Product gagal diedit');
                            document.location='product.php';
                        </script>";
            }
        }
        else
        {
            //data akan disimpan baru
            $simpan = mysqli_query($koneksi, "INSERT INTO tproduct (stock, nama, shade, harga) VALUES ('$_POST [tstock]', '$_POST[tnama]', '$_POST[tshade]', '$_POST[tharga]')");
        if($simpan) //jika simpan sukses
        {
            echo "<script>
                        alert('Data Product berhasil disimpan');
                        document.location='product.php';
                    </script>";
        }
        else //jika simpan gagal
        {
            echo "<script>
                        alert('Data Product gagal disimpan');
                        document.location='product.php';
                    </script>";
        }
        }
    }
        

    //Pengujian jika tombol edit atau hapus di klik
    if(isset($_GET['hal']))
    {
        //Pengujian jika edit data
        if($_GET['hal'] == "edit")
        {
            //Tampilkan data yang akan diedit
            $tampil = mysqli_query($koneksi,"SELECT * FROM tproduct WHERE id = '$_GET[id]'");
            $data = mysqli_fetch_array ($tampil);
            if($data)
            {
                //jika data ditemukan, maka data ditampung dahulu kedalam variabel
                $vstock = $data['stock'];
                $vnama = $data['nama'];
                $vshade = $data['shade'];
                $vharga = $data['harga'];
            }
        }
        else if($_GET['hal'] == "hapus")
        {
            //hapus data
            $hapus = mysqli_query($koneksi, "DELETE FROM tproduct WHERE id = '$_GET[id]'");
            if($hapus){
                echo "<script>
                        alert('Data Product berhasil dihapus');
                        document.location='product.php';
                    </script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>CREATE PRODUCT</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">

        <h1 class="text-center">SIMEDHIANI'S SHOP</h1>
        <h2 class="text-center">OUR PRODUCT</h2>
        
    <!-- Awal Tampilan Form-->
    <div class="card mt-3">
    <div class="card-header bg-info text-white">
        Create Product
    </div>
    <div class="card-body">
        <form method="post" action="">
            <div class="form-group">
                <label>Stock</label>
                <input type="text" name="tstock" value="<?=$vstock?>" class="form-control" placeholder="Banyaknya Stock" required>
            </div>
            <div class="form-group">
                <label>Nama Product</label>
                <select class="form-control" name="tnama">
                    <option value = "<?=$vnama?>"><?=$vnama?></option>
                    <option value="Emina Cheeklit Cream Blush"> Emina Cheeklit Cream Blush </option>
                    <option value="Emina Liquid Lip Shine – Carnation Pink"> Emina Liquid Lip Shine – Carnation Pink </option>
                    <option value="Focallure Big Cover Liquid Concealer"> Focallure Big Cover Liquid Concealer </option>
                    <option value="Focallure Ultra Chic Lips"> Focallure Ultra Chic Lips </option>
                    <option value="Luxcrime Second Skin Luminous Cushion"> Luxcrime Second Skin Luminous Cushion </option>
                    <option value="Luxcrime Ultra Light Lip Stain"> Luxcrime Ultra Light Lip Stain </option>
                    <option value="Luxcrime Blur & Cover Two Way Cake"> Luxcrime Blur & Cover Two Way Cake </option>
                    <option value="Make Over Powerstay Weightless Liquid Foundation"> Make Over Powerstay Weightless Liquid Foundation </option>
                    <option value="Make Over Intense Matte Lip Cream"> Make Over Intense Matte Lip Cream </option>
                    <option value="Make Over Powerstay Brow Definer Mascara"> Make Over Powerstay Brow Definer Mascara </option>
                    <option value="Maybelline Fit Me Smooth Powder"> Maybelline Fit Me Smooth Powder </option>
                    <option value="Maybelline Superstay Matte Ink"> Maybelline Superstay Matte Ink </option>
                    <option value="Maybelline Volum Express Hypercurl Waterproof Mascara"> Maybelline Volum Express Hypercurl Waterproof Mascara </option>
                    <option value="Wardah Colorfit Perfect Glow Cushion"> Wardah Colorfit Perfect Glow Cushion </option>
                    <option value="Wardah Intense Matte Lipstick"> Wardah Intense Matte Lipstick </option>
                    
                </select>
            </div>
            <div class="form-group">
                <label>Shade</label>
                <input type="text" name="tshade" value="<?=$vshade?>" class="form-control"placeholder="Input Shade Product" required>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="text" name="tharga" value="<?=$vharga?>" class="form-control" placeholder="Input Harga Product" required>
            </div>

            <button type="submit" class="btn btn-success" name="bsimpan"> Simpan</button>
            <button type="reset" class="btn btn-danger" name="breset"> Batal</button>
        </form>
        
    </div>
    </div>
    <!-- Akhir Tampilan Form-->

    <!-- Awal Tampilan Table-->
    <div class="card mt-3">
    <div class="card-header bg-success text-white">
        Daftar Product
    </div>
    <div class="card-body">

        <table class="table table-bordered table-striped">
            <tr>
                <th>No</th>
                <th>Stock</th>
                <th>Nama Product</th>
                <th>Shade</th>
                <th>Harga</th>
                <th>Action</th>
            </tr>
            <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * from tproduct order by id desc");
                while($data = mysqli_fetch_array($tampil)) :
            ?>
            <tr>
                <td><?=$no++;?></td>
                <td><?=$data['stock']?></td>
                <td><?=$data['nama']?></td>
                <td><?=$data['shade']?></td>
                <td><?=$data['harga']?></td>
                <td>
                    <a href="product.php?hal=edit&id=<?=$data['id']?>" class="btn btn-primary">Edit</a>
                    <a href="product.php?hal=hapus&id=<?=$data['id']?>" 
                            onclick = "return confirm('Data product akan terhapus. Tetap lanjutkan?')" class="btn btn-danger">Hapus</a>
                </td>
            </tr>
            <?php endwhile; //penutup perulangan while ?>
        </table>
    </div>
    </div>
    <!-- Akhir Tampilan Table-->
</div>
   <script type="text/javascript" src="js/bootstrap.min.js"></script> 
</body>
</html>