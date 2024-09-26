<?php
$koneksi = mysqli_connect("localhost","root","","stok");

if(!$koneksi){
    die ("koneksi gagal". mysqli_connect_error(). mysqli_connect_error());
}

?>