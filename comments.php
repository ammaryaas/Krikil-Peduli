<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kipli"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil data komentar
$sql = "SELECT CONCAT(firstname, ' ', lastname) AS full_name, comment FROM donations";
$result = $conn->query($sql);

$comments = [];
if ($result->num_rows > 0) {
  // Ambil setiap baris dan simpan dalam array
  while($row = $result->fetch_assoc()) {
    $comments[] = [
      'text' => $row['comment'],
      'author' => $row['full_name'],
      'avatar' => 'default_avatar.webp' // Ganti dengan logika untuk mengambil avatar jika diperlukan
    ];
  }
}

// Kirim data komentar sebagai JSON
echo json_encode($comments);

// Tutup koneksi
$conn->close();
?>
