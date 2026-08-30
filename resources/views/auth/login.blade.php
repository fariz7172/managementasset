<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPP/SPM Assets</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --color-teal: #24b1b1;
            --color-orange: #e37434;
            --color-dark: #1e293b;
            --color-white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--color-dark);
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(36, 177, 177, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 85% 30%, rgba(227, 116, 52, 0.15) 0%, transparent 50%);
            background-attachment: fixed;
            overflow: hidden;
            position: relative;
        }

        /* Ambient Blobs */
        .blob-1, .blob-2 {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            animation: float 10s ease-in-out infinite alternate;
        }
        .blob-1 {
            width: 400px;
            height: 400px;
            background: rgba(36, 177, 177, 0.2);
            top: -100px;
            left: -100px;
        }
        .blob-2 {
            width: 500px;
            height: 500px;
            background: rgba(227, 116, 52, 0.15);
            bottom: -200px;
            right: -100px;
            animation-delay: -5s;
        }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, 50px) scale(1.1); }
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-header h1 {
            color: var(--color-white);
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }
        
        .login-header h1 span {
            background: linear-gradient(135deg, var(--color-teal), var(--color-orange));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .input-icon-wrapper {
            position: relative;
        }

        .input-icon-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.4);
            transition: 0.3s;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 45px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: var(--color-white);
            font-size: 1rem;
            outline: none;
            transition: all 0.3s;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--color-teal);
            box-shadow: 0 0 0 4px rgba(36, 177, 177, 0.15);
        }

        .form-control:focus + i, .input-icon-wrapper:focus-within i {
            color: var(--color-teal);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--color-teal), #1d8e8e);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(36, 177, 177, 0.3);
        }
        
        .btn-submit:active {
            transform: translateY(0);
        }

        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border-left: 3px solid #ef4444;
            color: #fca5a5;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>
    
    <div class="blob-1"></div>
    <div class="blob-2"></div>

    <div class="login-container">
        <div class="login-header">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, var(--color-teal), var(--color-orange)); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; color: white; margin: 0 auto 16px; box-shadow: 0 10px 25px rgba(36, 177, 177, 0.4);">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <h1>SPP/SPM <span>Assets</span></h1>
            <p>Silakan masuk ke akun administrator Anda</p>
        </div>

        @if($errors->any())
            <div class="error-message">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>Email atau kata sandi salah.</span>
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Alamat Email</label>
                <div class="input-icon-wrapper">
                    <input type="email" name="email" class="form-control" placeholder="admin@gmail.com" value="{{ old('email') }}" required autofocus>
                    <i class="fa-solid fa-envelope"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Kata Sandi</label>
                <div class="input-icon-wrapper">
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    <i class="fa-solid fa-lock"></i>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                Masuk Sistem <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </button>
        </form>
    </div>

</body>
</html>
