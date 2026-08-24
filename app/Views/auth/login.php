<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | POS Comite</title>
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css') ?>">
    <style>
        * { box-sizing: border-box; }
        body.login-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 200% 200%;
            animation: gradientMove 12s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        /* Bubble dekorasi */
        .bubble {
            position: fixed;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
            animation: float 8s ease-in-out infinite;
        }
        .bubble:nth-child(1) { width: 180px; height: 180px; top: 8%; left: 10%; animation-delay: 0s; }
        .bubble:nth-child(2) { width: 100px; height: 100px; top: 65%; left: 82%; animation-delay: 2s; }
        .bubble:nth-child(3) { width: 140px; height: 140px; top: 75%; left: 12%; animation-delay: 4s; }
        .bubble:nth-child(4) { width: 70px; height: 70px; top: 18%; left: 78%; animation-delay: 1s; }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-25px) scale(1.05); }
        }
        .login-box { width: 400px; position: relative; z-index: 2; animation: slideUp .6s ease; }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(35px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .login-card {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(14px);
            border-radius: 20px !important;
            border: none;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .login-brand {
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 32px 20px 26px;
            text-align: center;
            color: #fff;
        }
        .login-brand .logo-icon {
            width: 72px; height: 72px;
            background: rgba(255,255,255,0.18);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            margin-bottom: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        .login-brand h1 { font-size: 26px; font-weight: 700; margin: 0; letter-spacing: .5px; }
        .login-brand p { margin: 4px 0 0; opacity: .85; font-size: 13px; }
        .login-card .card-body { padding: 30px 32px 26px; }
        .login-box-msg { font-size: 14px; color: #666; padding-bottom: 18px; }
        .input-group .form-control {
            border-radius: 10px 0 0 10px !important;
            border: 2px solid #e5e9f2;
            border-right: none;
            padding: 12px 14px;
            height: auto;
            font-size: 14px;
            transition: border-color .2s;
        }
        .input-group .form-control:focus { border-color: #667eea; box-shadow: none; }
        .input-group-text {
            border-radius: 0 10px 10px 0 !important;
            border: 2px solid #e5e9f2;
            border-left: none;
            background: #fff;
            color: #a0a8b8;
        }
        .input-group:focus-within .form-control,
        .input-group:focus-within .input-group-text { border-color: #667eea; }
        .input-group:focus-within .input-group-text { color: #667eea; }
        .btn-login {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 15px;
            letter-spacing: .5px;
            color: #fff;
            transition: transform .15s, box-shadow .15s;
        }
        .btn-login:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102,126,234,0.45);
        }
        .btn-login:active { transform: translateY(0); }
        .demo-box {
            background: linear-gradient(135deg, #f6f8ff, #fdf4ff);
            border: 1px dashed #c9d4f5;
            border-radius: 10px;
            padding: 10px 14px;
            margin-top: 18px;
            font-size: 12.5px;
            color: #555;
        }
        .demo-box b { color: #764ba2; }
        .alert { border-radius: 10px; font-size: 13.5px; }
        .shake { animation: shake .4s; }
        @keyframes shake {
            0%,100% { transform: translateX(0); }
            25% { transform: translateX(-7px); }
            75% { transform: translateX(7px); }
        }
    </style>
</head>
<body class="login-page">
<div class="bubble"></div><div class="bubble"></div><div class="bubble"></div><div class="bubble"></div>

<div class="login-box">
    <div class="card login-card <?= session()->getFlashdata('error') ? 'shake' : '' ?>">
        <div class="login-brand">
            <div class="logo-icon"><i class="fas fa-cash-register"></i></div>
            <h1>POS Comite</h1>
            <p>Sistem Kasir Point of Sale</p>
        </div>
        <div class="card-body">
            <p class="login-box-msg text-center">Masukkan kredensial Anda untuk melanjutkan</p>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><i class="fas fa-exclamation-circle mr-1"></i> <?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><i class="fas fa-check-circle mr-1"></i> <?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <form action="<?= base_url('login') ?>" method="post">
                <?= csrf_field() ?>
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
                    <div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>
                </div>
                <div class="input-group mb-4">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text" style="cursor:pointer" onclick="togglePass()">
                            <span class="fas fa-eye" id="eyeIcon"></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-login btn-block">
                    <i class="fas fa-sign-in-alt mr-1"></i> Masuk
                </button>
            </form>
            <div class="demo-box text-center">
                <i class="fas fa-info-circle"></i> Demo: <b>admin / admin123</b> &nbsp;atau&nbsp; <b>kasir / kasir123</b>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script>
function togglePass() {
    const p = document.getElementById('password');
    const i = document.getElementById('eyeIcon');
    if (p.type === 'password') { p.type = 'text'; i.classList.replace('fa-eye', 'fa-eye-slash'); }
    else { p.type = 'password'; i.classList.replace('fa-eye-slash', 'fa-eye'); }
}
</script>
</body>
</html>
