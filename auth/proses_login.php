<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = md5($_POST['password']); 

$login = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($login);

if($cek > 0){
    $data = mysqli_fetch_assoc($login);
    $_SESSION['username'] = $username;
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['role'] = $data['role'];
    $_SESSION['status'] = "login";
    
    echo "<script>
            localStorage.setItem('sipas_auth', 'true');
            window.location.href = '../jadwal_angkut/index.html';
          </script>";
}else{
    header("location:index.php?pesan=gagal");
}
?>