<?php
// auth/register.php
session_start();
require_once '../db.php';

$errors = [];
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($username) || empty($email) || empty($password)) {
        $errors[] = "Vui lòng điền đầy đủ thông tin bắt buộc!";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không hợp lệ!";
    }
    
    if (strlen($password) < 6) {
        $errors[] = "Mật khẩu phải ít nhất 6 ký tự!";
    }
    
    if ($password !== $confirm) {
        $errors[] = "Mật khẩu xác nhận không khớp!";
    }
    
    // Check trùng
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $errors[] = "Email hoặc tên đăng nhập đã tồn tại!";
        }
        $stmt->close();
    }
    
    // Insert
    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $role = 'customer';
        
        $stmt = $conn->prepare("
            INSERT INTO users (username, email, phone, password, role, status, joined) 
            VALUES (?, ?, ?, ?, ?, 'active', NOW())
        ");
        $stmt->bind_param("sssss", $username, $email, $phone, $hashed, $role);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
            header("Location: login.php");
            exit;
        } else {
            $errors[] = "Lỗi hệ thống: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - THTRAVEL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Inter', sans-serif; 
            background: #f0f7f4; 
            height: 100vh; 
            overflow: hidden;
        }

        .wave { 
            position: fixed; 
            bottom: 0; 
            left: 0; 
            width: 100%; 
            z-index: -1; 
        }

        .register-container { 
            position: relative; 
            width: 100%; 
            height: 100vh; 
            display: grid; 
            grid-template-columns: repeat(2, 1fr); 
            grid-gap: 7rem; 
            padding: 0 2rem; 
        }

        .img { 
            display: flex; 
            justify-content: flex-end; 
            align-items: center; 
        }
        .img img { 
            width: 500px; 
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .register-content { 
            display: flex; 
            align-items: center; 
            text-align: center; 
            justify-content: flex-start;
        }
        
        .register-form { 
            width: 420px;
            background: rgba(255, 255, 255, 0.95);
            padding: 35px 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 169, 127, 0.15);
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .register-form::-webkit-scrollbar {
            width: 5px;
        }
        .register-form::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .register-form::-webkit-scrollbar-thumb {
            background: #00a97f;
            border-radius: 10px;
        }
        
        .register-form img { 
            height: 80px; 
            margin-bottom: 0.5rem; 
        }
        
        .register-form h2 { 
            margin: 10px 0 20px; 
            color: #00a97f;
            text-transform: uppercase; 
            font-weight: 800;
            font-size: 2.2rem;
            font-family: 'Playfair Display', serif;
            text-shadow: 2px 2px 4px rgba(0, 169, 127, 0.2);
        }

        .input-div { 
            position: relative; 
            display: grid; 
            grid-template-columns: 7% 93%; 
            margin: 20px 0; 
            padding: 5px 0; 
            border-bottom: 3px solid #00a97f;
            background: transparent;
        }
        
        .input-div.one { margin-top: 0; }
        
        .i { 
            color: #00a97f;
            display: flex; 
            justify-content: center; 
            align-items: center; 
            font-size: 1.1rem;
        }
        
        .i i { transition: .3s; }

        .input-div > div { 
            position: relative; 
            height: 45px;
        }
        
        .input-div > div > h5 { 
            position: absolute; 
            left: 10px; 
            top: 50%; 
            transform: translateY(-50%); 
            color: #555;
            font-size: 1rem;
            font-weight: 600;
            transition: .3s; 
            pointer-events: none;
        }
        
        .input-div > div > input { 
            position: absolute; 
            left: 0; 
            top: 0; 
            width: 100%; 
            height: 100%; 
            border: none; 
            outline: none; 
            background: transparent !important;
            padding: 0.5rem 0.7rem; 
            font-size: 1.1rem;
            font-weight: 500;
            color: #222;
            font-family: 'Inter', sans-serif;
            border-radius: 0;
            box-shadow: none !important;
        }

        .input-div.pass { margin-bottom: 10px; }

        .input-div.one.focus .i i,
        .input-div.pass.focus .i i { color: #198754; }
        
        .input-div.one.focus div h5,
        .input-div.pass.focus div h5 { 
            top: -8px; 
            font-size: 0.85rem; 
            color: #00a97f;
            background: white;
            padding: 0 5px;
            left: 5px;
        }
        
        .input-div.one.focus,
        .input-div.pass.focus { border-bottom: 3px solid #198754; }

        .btn-register {
            display: block;
            width: 100%;
            height: 50px;
            border-radius: 25px;
            outline: none;
            border: none;
            background-image: linear-gradient(to right, #00a97f, #198754, #00a97f);
            background-size: 200%;
            color: #fff;
            font-family: 'Inter', sans-serif;
            text-transform: uppercase;
            font-weight: 700;
            font-size: 1rem;
            margin: 1.2rem 0 0.8rem;
            cursor: pointer;
            transition: .5s;
            box-shadow: 0 4px 15px rgba(0, 169, 127, 0.4);
        }
        .btn-register:hover { 
            background-position: right; 
            box-shadow: 0 6px 20px rgba(0, 169, 127, 0.6);
            transform: translateY(-2px);
        }

        .agree-wrapper {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin: 15px 0;
            font-size: 0.9rem;
            color: #444;
            font-weight: 500;
        }
        
        .agree-wrapper input[type="checkbox"] {
            margin-right: 8px;
            accent-color: #00a97f;
        }
        
        .agree-wrapper a {
            color: #00a97f;
            text-decoration: none;
            font-weight: 600;
        }
        .agree-wrapper a:hover {
            text-decoration: underline;
        }

        .error-msg { 
            color: #dc3545; 
            font-size: 0.9rem; 
            margin: 10px 0; 
            text-align: center; 
            background: #f8d7da;
            padding: 10px;
            border-radius: 8px;
            border-left: 4px solid #dc3545;
            font-weight: 500;
        }

        .login-link {
            margin-top: 15px;
            font-size: 1rem;
            color: #555;
        }
        .login-link a {
            color: #00a97f;
            font-weight: 700;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
            color: #198754;
        }

        @media screen and (max-width: 1050px) {
            .register-container { grid-template-columns: 1fr; }
            .img { display: none; }
            .wave { display: none; }
            .register-content { justify-content: center; }
            .register-form { width: 90%; padding: 25px; }
        }
        @media screen and (max-width: 600px) {
            .register-form { width: 95%; padding: 20px; }
            .register-form h2 { font-size: 1.8rem; }
        }
    </style>
</head>
<body>

    <img class="wave" src="../img/wave.png" alt="wave background">

    <div class="container register-container">
        <div class="img">
            <img src="../img/bg.svg" alt="background svg">
        </div>
        <div class="register-content">
            <form class="register-form" method="POST" action="">
                <img src="../img/avatar.svg" alt="avatar">
                <h2 class="title">Đăng ký</h2>

                <?php if (!empty($errors)): ?>
                    <div class="error-msg">
                        <?php foreach ($errors as $err): ?>
                            <div><i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($err) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Tên đăng nhập -->
                <div class="input-div one">
                    <div class="i"><i class="fas fa-user"></i></div>
                    <div class="div">
                        <h5>Tên đăng nhập *</h5>
                        <input type="text" name="username" class="input" required
                               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                    </div>
                </div>

                <!-- Email -->
                <div class="input-div one">
                    <div class="i"><i class="fas fa-envelope"></i></div>
                    <div class="div">
                        <h5>Email *</h5>
                        <input type="email" name="email" class="input" required
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                </div>

                <!-- Số điện thoại -->
                <div class="input-div one">
                    <div class="i"><i class="fas fa-phone"></i></div>
                    <div class="div">
                        <h5>Số điện thoại</h5>
                        <input type="tel" name="phone" class="input"
                               value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                    </div>
                </div>

                <!-- Mật khẩu -->
                <div class="input-div pass">
                    <div class="i"><i class="fas fa-lock"></i></div>
                    <div class="div">
                        <h5>Mật khẩu *</h5>
                        <input type="password" name="password" class="input" required minlength="6">
                    </div>
                </div>

                <!-- Xác nhận mật khẩu -->
                <div class="input-div pass">
                    <div class="i"><i class="fas fa-lock"></i></div>
                    <div class="div">
                        <h5>Xác nhận mật khẩu *</h5>
                        <input type="password" name="confirm_password" class="input" required>
                    </div>
                </div>

                <!-- Đồng ý điều khoản -->
                <div class="agree-wrapper">
                    <input type="checkbox" id="agree" name="agree" required>
                    <label for="agree">Tôi đồng ý với <a href="#">điều khoản sử dụng</a></label>
                </div>

                <button type="submit" class="btn-register">Đăng ký ngay</button>

                <p class="login-link">Đã có tài khoản? 
                    <a href="login.php">Đăng nhập</a>
                </p>
            </form>
        </div>
    </div>

        <script>
        // Hiệu ứng floating label
        const inputs = document.querySelectorAll(".input");

        function addcl() {
            let parent = this.parentNode.parentNode;
            parent.classList.add("focus");
        }

        function remcl() {
            let parent = this.parentNode.parentNode;
            if (this.value == "") {
                parent.classList.remove("focus");
            }
        }

        inputs.forEach(input => {
            input.addEventListener("focus", addcl);
            input.addEventListener("blur", remcl);

            // ✅ Nếu input đã có giá trị sẵn (sau khi đăng ký lỗi, trang load lại)
            // thì tự thêm class focus để nhãn nhảy lên trên
            if (input.value != "") {
                input.parentNode.parentNode.classList.add("focus");
            }
        });
    </script>
</body>
</html>