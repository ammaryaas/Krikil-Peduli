<?php
// Konfigurasi untuk mengakses API Midtrans
require_once 'midtrans-php-master/Midtrans.php'; // Pastikan anda telah menginstal midtrans via composer

// Set your server key here
\Midtrans\Config::$serverKey = '#';
\Midtrans\Config::$clientKey = '#';
\Midtrans\Config::$isProduction = true; // Ganti ke true jika sudah di produksi
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

// Ambil data dari frontend (yang dikirim via POST)
$data = json_decode(file_get_contents("php://input"));

// Pastikan data yang diterima tidak kosong
if (empty($data->firstname) || empty($data->lastname) || empty($data->email) || empty($data->phone) || empty($data->amount) || empty($data->comment)) {
    echo json_encode(['error' => 'Data tidak lengkap!']);
    exit;
}

// Membuat transaksi Midtrans
$orderId = "order_" . rand(1000, 9999); // Anda bisa menggunakan ID unik sesuai kebutuhan
$amount = $data->amount;
$transaction_details = array(
    'order_id' => $orderId,
    'gross_amount' => $amount,
);

$item_details = array(
    array(
        'id' => 'item1',
        'price' => $amount,
        'quantity' => 1,
        'name' => 'Donation for ' . $data->firstname . ' ' . $data->lastname,
    ),
);

// Data pengirim
$billing_address = array(
    'first_name'    => $data->firstname,
    'last_name'     => $data->lastname,
    'address'       => 'N/A',
    'city'          => 'N/A',
    'postal_code'   => '00000',
    'phone'         => $data->phone,
    'email'         => $data->email
);

// Membuat transaksi Midtrans
$transaction = array(
    'payment_type' => 'credit_card',
    'transaction_details' => $transaction_details,
    'item_details' => $item_details,
    'billing_address' => $billing_address
);

try {
    // Mengambil snap token dari Midtrans
    $snapToken = \Midtrans\Snap::getSnapToken($transaction);

    // Kirimkan token kepada frontend
    echo json_encode(['token' => $snapToken]);
} catch (Exception $e) {
    // Tangani jika terjadi kesalahan saat mendapatkan snap token
    echo json_encode(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
}
?>
