<!DOCTYPE html>
<html lang="en">

    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="images/kominfo-seeklogo.ico">
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="./assets/compiled/css/auth.css">
</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <img src="assets/compiled/png/LOGO Balmon Jakarta 2023.png" alt="Logo Balmon" class="logo-balmon">
                    <h1 class="auth-title">SISKA</h1>

                    <p class="auth-subtitle mb-2 ">Sistem Informasi Kinerja</p>

                    <!-- <p class="auth-sub-subtitle mb-5">Silahkan Login.</p> -->
                    <p class="auth-sub-subtitle mb-5"></p>
             
                    <form id="loginForm" action="connection/auth.php" method="POST">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="username" class="form-control form-control-xl" placeholder="Username" id="username" required>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" class="form-control form-control-xl" placeholder="Password" id="password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault" name="keep_logged_in">
                            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                Keep me logged in
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5" name="kirim">Log in</button>
                        <div class="footer">
                            <span class="footer-text">Balmon Jakarta @2024</span>
                        </div>
                    </form>
                    <div id="error-message" style="color: red; text-align: center; margin-top: 20px;">
                        <?php if (isset($_GET['error'])) echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                    <img src="assets/compiled/jpg/balmon.jpeg" alt="Deskripsi Gambar" style="width: 100%; height: 100%; object-fit:fill">
                </div>
            </div>
        </div>
    </div>


    
</body>
</html>
