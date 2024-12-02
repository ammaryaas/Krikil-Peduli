<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="asset/logokotak.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/donasi.css">
    <title>Document</title>
</head>
<body>

    <nav>
        <div class="navbar">
            <div class="logo"><img src="asset/logo.png"></div>
            <div class="menu">
                <a href="home.html">Home</a>
                <a href="profile.html">Profile</a>
                <a href="transparency.html">Transparency</a>
                <a href="volunteer.html" class="login">Join Volunteer</a>
            </div>
        </div>
    </nav>

    <div class="utama">

        <!-- form -->
        <div class="kiri">
            <div class="judul">
                <h1>Donate!</h1>
                <p>Help those who need it</p>
            </div>
            <div class="form">
                <form id="donationForm" onsubmit="return false;">
                    <div class="flex">
                        <label>
                            <input type="text" id="firstname" placeholder="" required>
                            <span>Firstname</span>
                        </label>
                        <label>
                            <input type="text" id="lastname" placeholder="" required>
                            <span>Lastname</span>
                        </label>
                    </div>
                    <div class="flex">
                        <label>
                            <input type="email" id="email" placeholder="" required>
                            <span>Email</span>
                        </label>
                        <label>
                            <input type="text" id="phone" placeholder="" required>
                            <span>Phone</span>
                        </label>
                    </div>
                    <div class="column">
                        <label>
                            <input type="number" id="amount" placeholder="" required>
                            <span>Amount</span>
                        </label>
                        <label>
                            <input type="text" id="comment" placeholder="" required>
                            <span>Comment</span>
                        </label>
                        <div class="button">
                            <button type="button" id="donateButton">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- gambar -->
        <div class="kanan">
            <div class="image">
                <img src="asset/smile1.jpg" alt="smile1">
                <img src="asset/smile2.jpg" alt="smile2">
                <img src="asset/smile3.jpg" alt="smile3">
                <div class="bullet1"></div>
                <div class="bullet2"></div>
                <div class="bullet3"></div>
            </div>
            <div class="quote">
                <p>your help was <b>priceless</b> for them</p>
            </div>
        </div>
        
    </div>

    <!-- footer -->
    <div class="foot">
        <div class="social-links">
            <a href="#"><i class="bi bi-youtube"></i></a>
            <a href="#"><i class="bi bi-twitter-x"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-linkedin"></i></a>
        </div>
        <div class="par">
            <p>Krikil Peduli (Kipli) is present as a platform that accommodates the community in raising funds and also assistance for people in need. Krikil Peduli was born as a response to the unheard cries of affected communities</p>
        </div>
        <div class="logfoot"><img src="asset/logofot.png" alt="logo footer"></div>
        <div class="copy">copyright &copy; 2024 Krikil Peduli | All Rights Reserved</div>
    </div>

    <!-- Include Midtrans Snap.js -->
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-0OxubONt_z84S1W8"></script>

    <script type="text/javascript">
        document.getElementById('donateButton').addEventListener('click', function () {
            // Ambil data dari form
            const data = {
                firstname: document.getElementById('firstname').value,
                lastname: document.getElementById('lastname').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                amount: document.getElementById('amount').value,
                comment: document.getElementById('comment').value,
            };

            // Validasi input (opsional)
            if (!data.firstname || !data.lastname || !data.email || !data.phone || !data.amount || !data.comment) {
                alert('Harap lengkapi semua data!');
                return;
            }

            // Kirim data ke server untuk mendapatkan Snap Token
            fetch('http://localhost/krikil-peduli/get-snap-token.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())  // Parsing JSON response dari server
            .then(result => {
                if (result.token) {
                    snap.pay(result.token, {
                        onSuccess: function(result) {
                            alert("Pembayaran berhasil!");

                            // Kirim data donasi ke server setelah pembayaran sukses
                            const donationData = {
                                firstname: data.firstname,
                                lastname: data.lastname,
                                email: data.email,
                                phone: data.phone,
                                amount: data.amount,
                                comment: data.comment,
                                status: 'success',  // Status pembayaran sukses
                            };

                            // Kirim data donasi ke server untuk disimpan di database
                            fetch('http://localhost/krikil-peduli/save-donation.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify(donationData),
                            })
                            .then(response => response.json())
                            .then(result => {
                                if (result.success) {
                                    alert('Data donasi berhasil disimpan!');
                                } else {
                                    alert('Gagal menyimpan data donasi.');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Terjadi kesalahan saat menyimpan data donasi.');
                            });

                        },
                        onPending: function(result) {
                            alert("Pembayaran pending.");
                            console.log(result);
                        },
                        onError: function(result) {
                            alert("Terjadi kesalahan saat melakukan pembayaran.");
                            console.log(result);
                        }
                    });
                } else {
                    alert('Gagal mendapatkan token pembayaran: ' + result.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghubungi server.');
            });
        });
    </script>

</body>
</html>
