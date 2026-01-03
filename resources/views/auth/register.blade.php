<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - LastBite</title>

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

        .register-container {
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(63, 35, 5, 0.08);
        }

        .register-header {
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

        .register-content {
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
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group.full-width {
            grid-column: span 2;
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

        .form-input,
        .form-select {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            font-size: 1rem;
            color: var(--text-primary);
            background: white;
            transition: all 0.3s ease;
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(63, 35, 5, 0.1);
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%233F2305' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
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

        .role-selection {
            display: flex;
            gap: 20px;
            margin-bottom: 18px;
        }

        .role-option {
            flex: 1;
        }

        .role-input {
            display: none;
        }

        .role-label {
            display: block;
            padding: 20px;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            user-select: none;
        }

        .role-input:checked+.role-label {
            border-color: var(--primary-color);
            background: rgba(63, 35, 5, 0.05);
            color: var(--primary-color);
        }

        .role-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            display: block;
        }

        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 30px;
        }

        .checkbox-group input {
            margin-top: 4px;
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .checkbox-group label {
            font-size: 0.9rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .checkbox-group a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .checkbox-group a:hover {
            text-decoration: underline;
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
            border: 2px solid var(--primary-color);
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

        @media (max-width: 900px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: span 1;
            }

            .register-content {
                padding: 40px 30px;
            }

            .register-header {
                padding: 40px 30px 30px;
            }

            .back-link {
                left: 30px;
                top: 30px;
            }
        }

        @media (max-width: 768px) {
            .role-selection {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .register-content {
                padding: 30px 20px;
            }

            .register-header {
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
        }
    </style>
</head>

<body>
    @php
    // Normalisasi role dari URL ke role yang backend ngerti (pembeli / penjual)
    $roleFromUrl = request()->query('role', 'pembeli');

    $map = [
        'buyer' => 'pembeli',
        'customer' => 'pembeli',
        'pembeli' => 'pembeli',

        'seller' => 'penjual',
        'penjual' => 'penjual',
    ];

    $selectedRole = $map[$roleFromUrl] ?? 'pembeli';
@endphp


    <div class="register-container">
        <div class="register-header">
            <a href="{{ route('login', ['role' => $selectedRole]) }}" class="back-link">← Back to Login</a>

            <div class="brand-logo">🍽️</div>
            <h1 class="brand-name">LastBite</h1>
            <p class="page-title">Join us in reducing food waste</p>
        </div>

        <div class="register-content">
            <div class="form-header">
                <h2 class="form-title">Create an account</h2>
                <p class="form-subtitle">Fill in your details to start your journey with LastBite</p>
            </div>

            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register.submit') }}" method="POST">
                @csrf

                <!-- nilai yang benar-benar dikirim ke backend -->
                <input type="hidden" name="role" id="selected-role" value="{{ old('role', $selectedRole) }}">

                <!-- Role Selection -->
                <div class="form-group">
                    <label class="form-label">Register as <span class="required">*</span></label>

                    <div class="role-selection">
                        <div class="role-option">
                            <input type="radio" name="role_selector" id="role-customer" value="pembeli"
                                class="role-input" {{ old('role', $selectedRole) === 'pembeli' ? 'checked' : '' }}>
                            <label for="role-customer" class="role-label" onclick="setRole('pembeli')">
                                <span class="role-icon">🛒</span>
                                <span>Customer</span>
                            </label>
                        </div>

                        <div class="role-option">
                            <input type="radio" name="role_selector" id="role-seller" value="penjual"
                                class="role-input" {{ old('role', $selectedRole) === 'penjual' ? 'checked' : '' }}>
                            <!-- FIX: class harus role-label -->
                            <label for="role-seller" class="role-label" onclick="setRole('penjual')">
                                <span class="role-icon">🏪</span>
                                <span>Seller</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name <span class="required">*</span></label>
                        <input type="text" id="name" name="name" class="form-input"
                            value="{{ old('name') }}" placeholder="Enter your full name" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address <span class="required">*</span></label>
                        <input type="email" id="email" name="email" class="form-input"
                            value="{{ old('email') }}" placeholder="Enter your email" required>
                    </div>

                    <!-- Only for seller -->
                    <div class="form-group" id="company-based-group" style="display:none;">
                        <label for="company_based" class="form-label">Company Location</label>
                        <input type="text" id="company_based" name="company_based" class="form-input"
                            value="{{ old('company_based') }}" placeholder="Where is your company based?">
                    </div>

                    <div class="form-group" id="industry-group" style="display:none;">
                        <label for="industry" class="form-label">Industry</label>

                        @php
                            $industryOptions =
                                $industries ??
                                (config('lastbite.industries', null) ?? [
                                    'Restaurant / Warung',
                                    'Bakery / Pastry',
                                    'Cafe / Coffee Shop',
                                    'Catering',
                                    'Supermarket / Minimarket',
                                    'Hotel',
                                    'UMKM Makanan & Minuman',
                                    'Produk Olahan / Frozen Food',
                                    'Other',
                                ]);
                        @endphp

                        <select id="industry" name="industry" class="form-select">
                            <option value="">Please select an industry</option>

                            @foreach ($industryOptions as $industry)
                                <option value="{{ $industry }}"
                                    {{ old('industry') == $industry ? 'selected' : '' }}>
                                    {{ $industry }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="form-input"
                            value="{{ old('phone') }}" placeholder="Enter your phone number">
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password <span class="required">*</span></label>
                        <div class="password-container">
                            <input type="password" id="password" name="password" class="form-input"
                                placeholder="Create a strong password" minlength="8" required>
                            <button type="button" class="toggle-password"
                                onclick="togglePasswordVisibility('password')">Show</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password <span
                                class="required">*</span></label>
                        <div class="password-container">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-input" placeholder="Confirm your password" required>
                            <button type="button" class="toggle-password"
                                onclick="togglePasswordVisibility('password_confirmation')">Show</button>
                        </div>
                    </div>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="privacy_policy" name="privacy_policy" value="1"
                        {{ old('privacy_policy') ? 'checked' : '' }} required>
                    <label for="privacy_policy">
                        I accept the <a href="#">Privacy Policy</a> and <a href="#">Terms & Conditions</a>
                        <span class="required">*</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">Create an Account</button>

                <div class="login-link">
                    Already have an account?
                    <a href="{{ route('login', ['role' => $selectedRole]) }}">Sign in here</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function setRole(role) {
            document.getElementById('selected-role').value = role;

            // sync radio UI
            const radio = document.querySelector(`input[name="role_selector"][value="${role}"]`);
            if (radio) radio.checked = true;

            const companyGroup = document.getElementById('company-based-group');
            const industryGroup = document.getElementById('industry-group');

            const companyInput = document.getElementById('company_based');
            const industrySelect = document.getElementById('industry');

            const isSeller = role === 'penjual';

            if (companyGroup) companyGroup.style.display = isSeller ? 'block' : 'none';
            if (industryGroup) industryGroup.style.display = isSeller ? 'block' : 'none';

            if (companyInput) companyInput.required = isSeller;
            if (industrySelect) industrySelect.required = isSeller;
        }

        function togglePasswordVisibility(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleButton = passwordInput.parentElement.querySelector('.toggle-password');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.textContent = 'Hide';
            } else {
                passwordInput.type = 'password';
                toggleButton.textContent = 'Show';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const selectedRole = document.getElementById('selected-role')?.value || 'pembeli';
            setRole(selectedRole);

            const nameField = document.getElementById('name');
            if (nameField && !nameField.value) nameField.focus();
        });
    </script>

</body>

</html>
