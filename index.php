<?php

// inisialisasi variabel
$key = "";
$text = "";
$error = "";
$color = "#FF0000";

// cek apakah ada data yang dikirimkan melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // cek apakah data dengan nama 'key' dan 'text' ada dalam $_POST
    if (isset($_POST['key']) && isset($_POST['text'])) {
        $key = $_POST['key'];
        $text = $_POST['text'];

        // jika menekan tombol enkripsi atau dekripsi
        if (isset($_POST['encrypt']) || isset($_POST['decrypt'])) {
            // declare encrypt and decrypt functions
            function encrypt($key, $text)
            {
                // inisialisasi variable
                $ki = 0;
                $kl = strlen($key);
                $length = strlen($text);

                // lakukan perulangan untuk setiap abjad
                for ($i = 0; $i < $length; $i++) {
                    // jika text merupakan alphabet
                    if (ctype_alpha($text[$i])) {
                        // jika text merupakan huruf kapital (semua)
                        if (ctype_upper($text[$i])) {
                            $text[$i] = chr(((ord($text[$i]) - ord("A") + ord($key[$ki]) - ord("A")) % 26) + ord("A"));
                        }
                        // jika text merupakan huruf kecil (semua)
                        else {
                            $text[$i] = chr(((ord($text[$i]) - ord("a") + ord($key[$ki]) - ord("a")) % 26) + ord("a"));
                        }

                        $ki++;
                        if ($ki >= $kl) {
                            $ki = 0;
                        }
                    }
                }
                // mengembalikan nilai text
                return $text;
            }

            function decrypt($key, $text)
            {
                // inisialisasi variable
                $ki = 0;
                $kl = strlen($key);
                $length = strlen($text);

                // lakukan perulangan untuk setiap abjad
                for ($i = 0; $i < $length; $i++) {
                    // jika text merupakan alphabet
                    if (ctype_alpha($text[$i])) {
                        // jika text merupakan huruf kapital (semua)
                        if (ctype_upper($text[$i])) {
                            $x = ((ord($text[$i]) - ord("A")) - (ord($key[$ki]) - ord("A")) % 26);

                            if ($x < 0) {
                                $x += 26;
                            }

                            $x = $x + ord("A");

                            $text[$i] = chr($x);
                        }

                        // jika text merupakan huruf kecil (semua)
                        else {
                            $x = ((ord($text[$i]) - ord("a")) - (ord($key[$ki]) - ord("a")) % 26);

                            if ($x < 0) {
                                $x += 26;
                            }

                            $x = $x + ord("a");

                            $text[$i] = chr($x);
                        }

                        $ki++;
                        if ($ki >= $kl) {
                            $ki = 0;
                        }
                    }
                }

                // mengembalikan nilai text
                return $text;
            }

            // jika menekan tombol enkripsi
            if (isset($_POST['encrypt'])) {
                $text = encrypt($key, $text);
                $error = "Text berhasil di enkripsi!";
            }

            // jika menekan tombol dekripsi
            if (isset($_POST['decrypt'])) {
                $text = decrypt($key, $text);
                $error = "Text berhasil di dekripsi!";
            }
        } else {
            $error = "Mohon lengkapi semua input!";
        }
    }
}

?>

<html>
<head>
    <title>Vigenere Cipher</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<br><br><br><br><br>
<main role="main" class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <caption><h2 style="text-align: center;"><b>Vigenere Cipher</b></h2></caption>
                </div>
                <div class="card-body">
                    <form action="index.php" method="post">
                        <div class="form-group">
                            <label for="Kunci">Kunci</label>
                            <input type="text" class="form-control" name="key" id="kunci"
                                   aria-describedby="inputKunci" placeholder="Masukkan Kunci"
                                   value="<?php echo $key; ?>">
                        </div>
                        <div class="form-group">
                            <label for="Plaintext">Plaintext</label>
                            <textarea class="form-control" name="text" id="text"
                                      rows="5"><?php echo $text; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-success" name="encrypt" value="Encrypt">Enkripsi</button>
                        <br><br>
                        <button type="submit" class="btn btn-danger" name="decrypt" value="Decrypt">Deskripsi</button>
                    </form>
                </div>
                <div class="card-footer text-center text-success">
                    <strong><?php echo $error; ?></strong>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>