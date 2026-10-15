<?php
// auth/forgot-password.php
session_start();
require_once '../db.php';

$errors = [];
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    
    if (empty($email)) {
        $errors[] = "Vui lòng nhập email!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không hợp lệ!";
    } else {
        // Kiểm tra email có tồn tại không
        $stmt = $conn->prepare("SELECT id, username FROM users WHERE email = ? AND status = 'active'");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        
        if ($user) {
            // Tạo token reset (trong thực tế nên lưu vào DB với thời hạn)
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Lưu token vào DB (bảng password_resets hoặc thêm cột vào users)
            $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_expiry = ? WHERE id = ?");
            $stmt->bind_param("ssi", $token, $expiry, $user['id']);
            $stmt->execute();
            $stmt->close();
            
            // Gửi email (giả lập - trong thực tế dùng PHPMailer/SMTP)
            // $resetLink = "http://localhost/thtravel/auth/reset-password.php?token=" . $token;
            // mail($email, "Reset Password", "Click: " . $resetLink);
            
            $success = "Link reset mật khẩu đã được gửi đến email của bạn!";
        } else {
            $errors[] = "Email không tồn tại trong hệ thống!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - THTRAVEL</title>
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

        .forgot-container { 
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

        .forgot-content { 
            display: flex; 
            align-items: center; 
            text-align: center; 
        }
        
        .forgot-form { 
            width: 400px;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 169, 127, 0.15);
        }
        
        .forgot-form img { 
            height: 100px; 
            margin-bottom: 1rem; 
        }
        
        .forgot-form h2 { 
            margin: 15px 0 10px; 
            color: #00a97f;
            text-transform: uppercase; 
            font-weight: 800;
            font-size: 2.5rem;
            font-family: 'Playfair Display', serif;
            text-shadow: 2px 2px 4px rgba(0, 169, 127, 0.2);
        }

        .forgot-form p.description {
            color: #666;
            font-size: 1rem;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .input-div { 
            position: relative; 
            display: grid; 
            grid-template-columns: 7% 93%; 
            margin: 25px 0; 
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
            font-size: 1.2rem;
        }
        
        .i i { transition: .3s; }

        .input-div > div { 
            position: relative; 
            height: 50px;
        }
        
        .input-div > div > h5 { 
            position: absolute; 
            left: 10px; 
            top: 50%; 
            transform: translateY(-50%); 
            color: #555;
            font-size: 1.1rem;
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
            font-size: 1.3rem;
            font-weight: 500;
            color: #222;
            font-family: 'Inter', sans-serif;
            border-radius: 0;
            box-shadow: none !important;
        }

        .input-div.one.focus .i i { color: #198754; }
        
        .input-div.one.focus div h5 { 
            top: -8px; 
            font-size: 0.95rem; 
            color: #00a97f;
            background: white;
            padding: 0 5px;
            left: 5px;
        }
        
        .input-div.one.focus { border-bottom: 3px solid #198754; }

        .btn-forgot {
            display: block;
            width: 100%;
            height: 55px;
            border-radius: 27px;
            outline: none;
            border: none;
            background-image: linear-gradient(to right, #00a97f, #198754, #00a97f);
            background-size: 200%;
            color: #fff;
            font-family: 'Inter', sans-serif;
            text-transform: uppercase;
            font-weight: 700;
            font-size: 1.1rem;
            margin: 1.5rem 0 1rem;
            cursor: pointer;
            transition: .5s;
            box-shadow: 0 4px 15px rgba(0, 169, 127, 0.4);
        }
        .btn-forgot:hover { 
            background-position: right; 
            box-shadow: 0 6px 20px rgba(0, 169, 127, 0.6);
            transform: translateY(-2px);
        }

        .error-msg { 
            color: #dc3545; 
            font-size: 1rem; 
            margin: 15px 0; 
            text-align: center; 
            background: #f8d7da;
            padding: 12px;
            border-radius: 8px;
            border-left: 4px solid #dc3545;
            font-weight: 500;
        }

        .success-msg { 
            color: #198754; 
            font-size: 1rem; 
            margin: 15px 0; 
            text-align: center; 
            background: #d4edda;
            padding: 12px;
            border-radius: 8px;
            border-left: 4px solid #198754;
            font-weight: 500;
        }

        .back-link {
            margin-top: 20px;
            font-size: 1.05rem;
            color: #555;
        }
        .back-link a {
            color: #00a97f;
            font-weight: 700;
            text-decoration: none;
        }
        .back-link a:hover {
            text-decoration: underline;
            color: #198754;
        }

        @media screen and (max-width: 1050px) {
            .forgot-container { grid-template-columns: 1fr; }
            .img { display: none; }
            .wave { display: none; }
            .forgot-content { justify-content: center; }
            .forgot-form { width: 90%; padding: 30px; }
        }
        @media screen and (max-width: 600px) {
            .forgot-form { width: 95%; padding: 20px; }
            .forgot-form h2 { font-size: 2rem; }
        }
    </style>
</head>
<body>

    <img class="wave" src="../img/wave.png" alt="wave background">

    <div class="container forgot-container">
        <div class="img">
            <img src="../img/bg.svg" alt="background svg">
        </div>
        <div class="forgot-content">
            <form class="forgot-form" method="POST" action="">
                <img src="../img/avatar.svg" alt="avatar">
                <h2 class="title">Quên mật khẩu</h2>
                <p class="description">Nhập email của bạn để nhận link đặt lại mật khẩu</p>

                <?php if (!empty($errors)): ?>
                    <div class="error-msg">
                        <?php foreach ($errors as $err): ?>
                            <div><i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($err) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <div class="success-msg">
                        <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <div class="input-div one">
                    <div class="i"><i class="fas fa-envelope"></i></div>
                    <div class="div">
                        <h5>Email của bạn</h5>
                        <input type="email" name="email" class="input" required 
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                </div>

                <button type="submit" class="btn-forgot">Gửi link reset</button>

                <p class="back-link">
                    <a href="login.php"><i class="fas fa-arrow-left me-2"></i>Quay lại đăng nhập</a>
                </p>
            </form>
        </div>
    </div>

    <script>
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
        });
    </script>
</body>
</html>