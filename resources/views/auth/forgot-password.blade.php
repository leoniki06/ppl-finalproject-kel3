<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - LastBite</title>

    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #3F2305;
            --secondary-color: #f5f5f5;
            --accent-color: #d4a574;
            --text-primary: #333333;
            --text-secondary: #666666;
            --border-color: #e0e0e0;
            --success-color: #4CAF50;
            --error-color: #f44336;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f9f7f3 0%, #f0ebe4 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(63, 35, 5, 0.08);
        }

        .header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #5a3510 100%);
            padding: 40px;
            text-align: center;
            color: white;
            position: relative;
        }

        .back-link {
            position: absolute;
            left: 40px;
            top: 40px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            opacity: 0.9;
        }

        .back-link:hover {
            opacity: 1;
        }

        .brand-logo {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .brand-name {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .page-title {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 300;
        }

        .content {
            padding: 50px;
        }

        .form-header {
            margin-bottom: 40px;
            text-align: center;
        }

        .form-title {
            font-size: 2rem;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-subtitle {
            color: var(--text-secondary);
            font-size: 0.95rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .form-subtitle a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .form-subtitle a:hover {
            text-decoration: underline;
        }

        /* Step Indicator */
        .step-indicator {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .step-number {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--border-color);
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .step.active .step-number {
            background: var(--primary-color);
            color: white;
        }

        .step.completed .step-number {
            background: var(--success-color);
            color: white;
        }

        .step-text {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .step.active .step-text {
            color: var(--primary-color);
            font-weight: 600;
        }

        .step-line {
            flex: 1;
            height: 2px;
            background: var(--border-color);
            max-width: 100px;
        }

        .step-line.active {
            background: var(--primary-color);
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-primary);
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-label .required {
            color: var(--error-color);
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            font-size: 1rem;
            color: var(--text-primary);
            background: white;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(63, 35, 5, 0.1);
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: block;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
            border: 2px solid var(--primary-color);
        }

        .btn-primary:hover {
            background: white;
            color: var(--primary-color);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-primary:disabled:hover {
            background: var(--primary-color);
            color: white;
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            background: rgba(244, 67, 54, 0.1);
            color: var(--error-color);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: center;
            border-left: 4px solid var(--error-color);
        }

        .success-message {
            background: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: center;
            border-left: 4px solid var(--success-color);
        }

        /* User Info Box */
        .user-info-box {
            background: rgba(63, 35, 5, 0.05);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 4px solid var(--primary-color);
        }

        .user-info-box p {
            margin: 5px 0;
            color: var(--text-primary);
        }

        .user-info-box strong {
            color: var(--primary-color);
        }

        /* Form Sections */
        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 900px) {
            .content {
                padding: 40px 30px;
            }

            .header {
                padding: 40px 30px 30px;
            }

            .back-link {
                left: 30px;
                top: 30px;
            }

            .step-indicator {
                gap: 10px;
            }

            .step-line {
                max-width: 50px;
            }
        }

        @media (max-width: 480px) {
            .content {
                padding: 30px 20px;
            }

            .header {
                padding: 30px 20px 25px;
            }

            .back-link {
                left: 20px;
                top: 20px;
                font-size: 0.9rem;
            }

            .form-title {
                font-size: 1.7rem;
            }

            .step-text {
                font-size: 0.75rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <a href="{{ route('login') }}" class="back-link">
                ← Kembali ke Login
            </a>

            <div class="brand-logo">🔐</div>
            <h1 class="brand-name">LastBite</h1>
            <p class="page-title">Reset Password Anda</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="form-header">
                <h2 class="form-title">Lupa Password</h2>
                <p class="form-subtitle">
                    Masukkan email Anda untuk mereset password.
                    Ingat password? <a href="{{ route('login') }}">Login di sini</a>
                </p>
            </div>

            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step active" id="step1">
                    <div class="step-number">1</div>
                    <div class="step-text">Masukkan Email</div>
                </div>
                <div class="step-line" id="line1"></div>
                <div class="step" id="step2">
                    <div class="step-number">2</div>
                    <div class="step-text">Password Baru</div>
                </div>
                <div class="step-line" id="line2"></div>
                <div class="step" id="step3">
                    <div class="step-number">3</div>
                    <div class="step-text">Selesai</div>
                </div>
            </div>

            <!-- Error/Success Messages -->
            <div class="error-message" id="globalError" style="display: none;"></div>
            <div class="success-message" id="globalSuccess" style="display: none;"></div>

            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <!-- Section 1: Enter Email -->
            <form id="emailForm" class="form-section active">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">
                        Alamat Email <span class="required">*</span>
                    </label>
                    <input type="email" id="email" name="email" class="form-input"
                        placeholder="contoh: nama@email.com" required>
                    <div class="error-message" id="emailError" style="display: none; margin-top: 8px;"></div>
                </div>

                <button type="submit" class="btn btn-primary" id="checkEmailBtn">
                    Cek Email
                </button>
            </form>

            <!-- Section 2: Reset Password -->
            <form id="resetForm" class="form-section">
                @csrf
                <input type="hidden" id="user_id" name="user_id">
                <input type="hidden" id="user_email" name="email">

                <!-- User Info Display -->
                <div class="user-info-box" id="userInfoBox" style="display: none;">
                    <p><strong>Email yang diverifikasi:</strong> <span id="displayEmail"></span></p>
                    <p><strong>Nama:</strong> <span id="displayName"></span></p>
                </div>

                <div class="form-group">
                    <label for="new_password" class="form-label">
                        Password Baru <span class="required">*</span>
                    </label>
                    <div class="password-container">
                        <input type="password" id="new_password" name="new_password" class="form-input"
                            placeholder="Minimal 8 karakter" minlength="8" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('new_password')">
                            Tampilkan
                        </button>
                    </div>
                    <div class="error-message" id="passwordError" style="display: none; margin-top: 8px;"></div>
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation" class="form-label">
                        Konfirmasi Password Baru <span class="required">*</span>
                    </label>
                    <div class="password-container">
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                            class="form-input" placeholder="Ulangi password baru" required>
                        <button type="button" class="toggle-password"
                            onclick="togglePassword('new_password_confirmation')">
                            Tampilkan
                        </button>
                    </div>
                    <div class="error-message" id="confirmError" style="display: none; margin-top: 8px;"></div>
                </div>

                <button type="submit" class="btn btn-primary" id="resetBtn">
                    Reset Password
                </button>

                <div class="login-link">
                    <a href="javascript:void(0)" onclick="backToEmail()">
                        ← Ganti email lain
                    </a>
                </div>
            </form>

            <!-- Section 3: Success -->
            <div id="successSection" class="form-section">
                <div class="success-message" style="display: block; text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 15px;">✅</div>
                    <h3 style="margin-bottom: 10px; color: var(--success-color);">Password Berhasil Direset!</h3>
                    <p>Password Anda telah diperbarui. Sekarang Anda dapat login dengan password baru.</p>
                </div>

                <a href="{{ route('login') }}" class="btn btn-primary" style="margin-top: 30px;">
                    Login Sekarang
                </a>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let currentStep = 1;

        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const button = field.parentElement.querySelector('.toggle-password');

            if (field.type === 'password') {
                field.type = 'text';
                button.textContent = 'Sembunyikan';
            } else {
                field.type = 'password';
                button.textContent = 'Tampilkan';
            }
        }

        // Update step indicator
        function updateStepIndicator(step) {
            // Reset all
            document.querySelectorAll('.step').forEach(s => {
                s.classList.remove('active', 'completed');
            });
            document.querySelectorAll('.step-line').forEach(l => {
                l.classList.remove('active');
            });

            // Update based on current step
            for (let i = 1; i <= step; i++) {
                const stepEl = document.getElementById('step' + i);
                if (stepEl) {
                    if (i === step) {
                        stepEl.classList.add('active');
                    } else {
                        stepEl.classList.add('completed');
                    }
                }

                if (i < step) {
                    const lineEl = document.getElementById('line' + i);
                    if (lineEl) {
                        lineEl.classList.add('active');
                    }
                }
            }
        }

        // Show specific form section
        function showSection(sectionNumber) {
            // Hide all sections
            document.querySelectorAll('.form-section').forEach(section => {
                section.classList.remove('active');
            });

            // Show selected section
            const sectionId = sectionNumber === 1 ? 'emailForm' :
                sectionNumber === 2 ? 'resetForm' :
                'successSection';
            document.getElementById(sectionId).classList.add('active');

            // Update step indicator
            updateStepIndicator(sectionNumber);
            currentStep = sectionNumber;
        }

        // Go back to email form
        function backToEmail() {
            showSection(1);
            document.getElementById('email').focus();
        }

        // Email validation
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // Password validation
        function validatePassword(password) {
            return password.length >= 8;
        }

        // Handle email form submission
        document.getElementById('emailForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value.trim();
            const errorDiv = document.getElementById('emailError');
            const button = document.getElementById('checkEmailBtn');

            // Reset error
            errorDiv.style.display = 'none';
            button.disabled = true;
            button.textContent = 'Memeriksa...';

            // Validate email format
            if (!validateEmail(email)) {
                errorDiv.textContent = 'Format email tidak valid';
                errorDiv.style.display = 'block';
                button.disabled = false;
                button.textContent = 'Cek Email';
                return;
            }

            try {
                // Send request to check email
                const response = await fetch('{{ route('password.check') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Store user data
                    document.getElementById('user_id').value = data.user_id;
                    document.getElementById('user_email').value = data.user_email;

                    // Display user info
                    document.getElementById('displayEmail').textContent = data.user_email;
                    document.getElementById('displayName').textContent = data.user_name || 'User';
                    document.getElementById('userInfoBox').style.display = 'block';

                    // Move to step 2
                    showSection(2);

                    // Focus on password field
                    setTimeout(() => {
                        document.getElementById('new_password').focus();
                    }, 300);
                } else {
                    errorDiv.textContent = data.message;
                    errorDiv.style.display = 'block';
                }
            } catch (error) {
                errorDiv.textContent = 'Koneksi error. Periksa internet Anda.';
                errorDiv.style.display = 'block';
            } finally {
                button.disabled = false;
                button.textContent = 'Cek Email';
            }
        });

        // Handle reset form submission
        document.getElementById('resetForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const password = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('new_password_confirmation').value;
            const userId = document.getElementById('user_id').value;
            const userEmail = document.getElementById('user_email').value;

            const passwordError = document.getElementById('passwordError');
            const confirmError = document.getElementById('confirmError');
            const button = document.getElementById('resetBtn');

            // Reset errors
            passwordError.style.display = 'none';
            confirmError.style.display = 'none';

            // Validate password
            if (!validatePassword(password)) {
                passwordError.textContent = 'Password minimal 8 karakter';
                passwordError.style.display = 'block';
                return;
            }

            if (password !== confirmPassword) {
                confirmError.textContent = 'Password tidak cocok';
                confirmError.style.display = 'block';
                return;
            }

            button.disabled = true;
            button.textContent = 'Memproses...';

            try {
                const response = await fetch('{{ route('password.reset') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        user_id: userId,
                        email: userEmail,
                        new_password: password,
                        new_password_confirmation: confirmPassword
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Move to success section
                    showSection(3);
                } else {
                    passwordError.textContent = data.message;
                    passwordError.style.display = 'block';
                }
            } catch (error) {
                passwordError.textContent = 'Koneksi error. Silakan coba lagi.';
                passwordError.style.display = 'block';
            } finally {
                button.disabled = false;
                button.textContent = 'Reset Password';
            }
        });

        // Auto-focus email field on load
        document.addEventListener('DOMContentLoaded', function() {
            const emailField = document.getElementById('email');
            if (emailField) {
                emailField.focus();
            }
        });
    </script>
</body>

</html>
