<?php
// Database connection
$servername = "localhost";  // Ganti dengan host database Anda
$username = "root";         // Ganti dengan username database Anda
$password = "";             // Ganti dengan password database Anda
$dbname = "kipli";          // Nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari request JSON
$data = json_decode(file_get_contents("php://input"), true);

// Ambil data dari form
$firstname = $data['firstname'];
$lastname = $data['lastname'];
$email = $data['email'];
$phone = $data['phone'];
$amount = $data['amount'];
$comment = $data['comment'];
$transaction_id = $data['transaction_id'];  // Ini harus diberikan setelah pembayaran sukses

// Query untuk menyimpan data donasi
$sql = "INSERT INTO donations (firstname, lastname, email, phone, amount, comment, transaction_id)
        VALUES ('$firstname', '$lastname', '$email', '$phone', '$amount', '$comment', '$transaction_id')";

// Eksekusi query dan periksa apakah berhasil
if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Donation saved successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error]);
}

// Tutup koneksi
$conn->close();
?>
