<style>
    /* Full page background styling scoped to this view */
    body {
        background: url('https://images.unsplash.com/photo-1586528116311-ad8ed7c80a30?q=80&w=2070&auto=format&fit=crop') no-repeat center center fixed !important;
        background-size: cover !important;
    }
    
    /* Light overlay so the background isn't too dark */
    body::before {
        content: "";
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255, 255, 255, 0.3); 
        z-index: -1;
    }

    /* Override navbar just for the login page */
    .navbar-green {
        background: rgba(20, 83, 45, 0.85) !important;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(255,255,255,0.1) !important;
    }
    
    .login-wrapper {
        min-height: calc(100vh - 140px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }
    
    .login-card {
        background: rgba(255, 255, 255, 0.98);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        overflow: hidden;
        width: 100%;
        max-width: 440px;
        animation: slideUpFade 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes slideUpFade {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .login-header {
        text-align: center;
        padding: 3rem 2.5rem 1.5rem;
    }

    .login-icon-box {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--green-100) 0%, var(--green-200) 100%);
        color: var(--green-700);
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: 0 auto 1.5rem;
        box-shadow: 0 10px 25px -5px rgba(34, 197, 94, 0.3);
        transform: rotate(-5deg);
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .login-card:hover .login-icon-box {
        transform: rotate(0deg) scale(1.08);
    }

    .login-title {
        font-weight: 800;
        color: var(--gray-900);
        font-size: 1.75rem;
        letter-spacing: -0.03em;
        margin-bottom: 0.5rem;
    }

    .login-subtitle {
        color: var(--gray-500);
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 0;
    }

    .login-body {
        padding: 0 2.5rem 3.5rem;
    }

    /* Customizing form-floating for a premium feel */
    .form-floating > .form-control {
        border-radius: 14px;
        border: 1.5px solid var(--gray-200);
        background-color: var(--gray-50);
        font-weight: 500;
        color: var(--gray-900);
        transition: all 0.25s ease;
        padding-right: 3rem; /* Space for icon */
    }

    .form-floating > .form-control:focus {
        border-color: var(--green-400);
        background-color: var(--white);
        box-shadow: 0 0 0 4px rgba(74, 222, 128, 0.15);
    }

    .form-floating > label {
        color: var(--gray-500);
        padding-left: 1.25rem;
    }

    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        color: var(--green-700);
        font-weight: 600;
        transform: scale(0.85) translateY(-0.75rem) translateX(0.15rem);
    }

    .input-icon {
        position: absolute;
        top: 50%;
        right: 1.25rem;
        transform: translateY(-50%);
        color: var(--gray-400);
        font-size: 1.25rem;
        pointer-events: none;
        z-index: 5;
        transition: color 0.25s ease;
    }

    .form-floating > .form-control:focus ~ .input-icon {
        color: var(--green-500);
    }

    .btn-login {
        background: linear-gradient(135deg, var(--green-600) 0%, var(--green-700) 100%);
        color: white;
        border: none;
        border-radius: 14px;
        padding: 1.15rem;
        font-weight: 700;
        font-size: 1.1rem;
        letter-spacing: 0.5px;
        box-shadow: 0 10px 20px -5px rgba(22, 163, 74, 0.4);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        margin-top: 1rem;
    }

    .btn-login:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 25px -5px rgba(22, 163, 74, 0.5);
        color: white;
    }
    
    .btn-login:active {
        transform: translateY(0);
        box-shadow: 0 5px 10px -5px rgba(22, 163, 74, 0.4);
    }
</style>

<div class="login-wrapper">
    <div class="login-card">
        <div class="login-header">
            <div class="login-icon-box">
                <i class="bi bi-box-seam"></i>
            </div>
            <h1 class="login-title">Selamat Datang</h1>
            <p class="login-subtitle">Masuk ke Portal WMS Agrologistik untuk mengelola operasional gudang Anda.</p>
        </div>
        
        <div class="login-body">
            <!-- Alert Flasher (if any) -->
            <?php Flasher::flash(); ?>
            
            <form action="<?= BASEURL; ?>/auth/prosesLogin" method="POST">
                
                <div class="form-floating mb-4 position-relative">
                    <input type="text" class="form-control" id="username" name="username" required autocomplete="off" placeholder="Username">
                    <label for="username">Username</label>
                    <i class="bi bi-person input-icon"></i>
                </div>
                
                <div class="form-floating mb-4 position-relative">
                    <input type="password" class="form-control" id="password" name="password" required placeholder="Password">
                    <label for="password">Password</label>
                    <i class="bi bi-shield-lock input-icon"></i>
                </div>
                
                <button type="submit" class="btn-login">
                    Masuk ke Sistem <i class="bi bi-arrow-right-short fs-4"></i>
                </button>

            </form>
        </div>
    </div>
</div>