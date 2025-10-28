
<?php
include 'koneksi.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){
$username = $_POST['username'];
$email    = $_POST['email'];
$role     = $_POST['role'];
$password = $_POST['password'];


$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO users (username, email, role, password)
          VALUES ('$username', '$email', '$role', '$hashed_password')";

if (mysqli_query($koneksi, $query)) {
    echo "<script>
            alert('Data user berhasil disimpan!');
            window.location.href='form.html';
          </script>";
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}
}
mysqli_close($koneksi);
?>
