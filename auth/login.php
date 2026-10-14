<?php
// auth/login.php
session_start();
require_once '../db.php';

$errors = [];
$success = $_SESSION['success'] ?? '';   // ✅ thêm dòng này
unset($_SESSION['success']);             // ✅ thêm dòng này
// Nếu đã login → redirect theo role
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] === 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../index.php");
    }
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    if (empty($username) || empty($password)) {
        $errors[] = "Vui lòng nhập đầy đủ thông tin!";
    } else {
        $stmt = $conn->prepare("
            SELECT id, username, email, password, role, status, avatar, phone 
            FROM users 
            WHERE (username = ? OR email = ?) AND status = 'active'
            LIMIT 1
        ");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'role' => $user['role'],
                'avatar' => $user['avatar'],
                'phone' => $user['phone']
            ];
            
            if ($user['role'] === 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../index.php");
            }
            exit;
        } else {
            $errors[] = "Tên đăng nhập/email hoặc mật khẩu không đúng!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - THTRAVEL</title>
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

        .login-container { 
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

        .login-content { 
            display: flex; 
            align-items: center; 
            text-align: center; 
        }
        
        .login-form { 
            width: 400px;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 169, 127, 0.15);
        }
        
        .login-form img { 
            height: 100px; 
            margin-bottom: 1rem; 
        }
        
        .login-form h2 { 
            margin: 15px 0 25px; 
            color: #00a97f;
            text-transform: uppercase; 
            font-weight: 800;
            font-size: 3rem;
            font-family: 'Playfair Display', serif;
            text-shadow: 2px 2px 4px rgba(0, 169, 127, 0.2);
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

        .input-div.pass { margin-bottom: 10px; }

        .input-div.one.focus .i i,
        .input-div.pass.focus .i i { color: #198754; }
        
        .input-div.one.focus div h5,
        .input-div.pass.focus div h5 { 
            top: -8px; 
            font-size: 0.95rem; 
            color: #00a97f;
            background: white;
            padding: 0 5px;
            left: 5px;
        }
        
        .input-div.one.focus,
        .input-div.pass.focus { border-bottom: 3px solid #198754; }

        .btn-login {
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
        .btn-login:hover { 
            background-position: right; 
            box-shadow: 0 6px 20px rgba(0, 169, 127, 0.6);
            transform: translateY(-2px);
        }

        .remember-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 15px 0;
            font-size: 1rem;
            color: #444;
            font-weight: 500;
        }
        
        .remember-wrapper a {
            color: #00a97f;
            text-decoration: none;
            font-weight: 600;
            transition: .3s;
        }
        .remember-wrapper a:hover { 
            color: #198754; 
            text-decoration: underline;
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

        .register-link {
            margin-top: 20px;
            font-size: 1.05rem;
            color: #555;
        }
        .register-link a {
            color: #00a97f;
            font-weight: 700;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
            color: #198754;
        }

        @media screen and (max-width: 1050px) {
            .login-container { grid-template-columns: 1fr; }
            .img { display: none; }
            .wave { display: none; }
            .login-content { justify-content: center; }
            .login-form { width: 90%; padding: 30px; }
        }
        @media screen and (max-width: 600px) {
            .login-form { width: 95%; padding: 20px; }
            .login-form h2 { font-size: 2.2rem; }
        }
    </style>
</head>
<body>

    <img class="wave" src="../img/wave.png" alt="wave background">

    <div class="container login-container">
        <div class="img">
            <img src="../img/bg.svg" alt="background svg">
        </div>
        <div class="login-content">
            <form class="login-form" method="POST" action="">
                <img src="../img/avatar.svg" alt="avatar">
                <h2 class="title">Đăng nhập</h2>
                <?php if (!empty($success)): ?>
                 <div style="color:#198754; font-size:1rem; margin:15px 0; text-align:center; background:#d4edda; padding:12px; border-radius:8px; border-left:4px solid #198754; font-weight:500;">
                 <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($success) ?>
                 </div>
                <?php endif; ?>
                <?php if (!empty($errors)): ?>
                    <div class="error-msg">
                        <?php foreach ($errors as $err): ?>
                            <div><i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($err) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="input-div one">
                    <div class="i"><i class="fas fa-user"></i></div>
                    <div class="div">
                        <h5>Email hoặc tên đăng nhập</h5>
                        <input type="text" name="username" class="input" required 
                               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                    </div>
                </div>

                <div class="input-div pass">
                    <div class="i"><i class="fas fa-lock"></i></div>
                    <div class="div">
                        <h5>Mật khẩu</h5>
                        <input type="password" name="password" class="input" required>
                    </div>
                </div>

                <div class="remember-wrapper">
                    <label style="cursor: pointer;">
                        <input type="checkbox" name="remember" style="margin-right: 5px;"> Ghi nhớ đăng nhập
                    </label>
                    <a href="forgot-password.php">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="btn-login">Đăng nhập</button>

                <p class="register-link">Chưa có tài khoản? 
                    <a href="register.php">Đăng ký ngay</a>
                </p>
            </form>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll(".input");

function addcl() {
    this.parentNode.parentNode.classList.add("focus");
}

function remcl() {
    if (this.value == "") {
        this.parentNode.parentNode.classList.remove("focus");
    }
}

inputs.forEach(input => {
    input.addEventListener("focus", addcl);
    input.addEventListener("blur", remcl);

    // ✅ Quan trọng: nếu input đã có giá trị sẵn (ví dụ sau khi đăng nhập sai)
    // thì thêm class focus ngay lập tức để nhãn nhảy lên trên
    if (input.value != "") {
        input.parentNode.parentNode.classList.add("focus");
    }
});
    </script>
</body>
</html>