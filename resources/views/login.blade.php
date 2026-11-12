<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | MAS YPI SUMBER HARJO</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px;
            background: #eef2f7;
        }

        .login-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            min-height: 590px;
            background: #ffffff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 15px 45px rgba(15, 23, 42, 0.12);
        }

        /* Panel identitas sekolah */
        .school-panel {
            width: 46%;
            padding: 40px 38px;
            background: #142d4e;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 22px;
        }

        .school-logo {
            width: 400px;
            height: 250px;
            object-fit: contain;
            background: #142d4e;
            border-radius: 12px;
            padding: 5px;
        }

        .school-name {
            font-size: 27px;
            font-weight: bold;
            line-height: 1.4;
            text-align: center;
            margin-bottom: 15px;
            color: #ffffff;
        }

        .school-divider {
            width: 65px;
            height: 4px;
            border-radius: 5px;
            background: #60a5fa;
            margin: 0 auto 20px;
        }

        .school-address {
            color: #dbeafe;
            font-size: 13px;
            line-height: 1.9;
            text-align: center;
            margin-bottom: 22px;
        }

        .school-description {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 18px;
            color: #dbeafe;
            font-size: 13px;
            line-height: 1.8;
            text-align: center;
        }

        /* Panel formulir login */
        .login-panel {
            flex: 1;
            padding: 55px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0;
        }

        .login-heading {
            font-size: 29px;
            color: #142d4e;
            margin-bottom: 12px;
        }

        .login-subtitle {
            font-size: 14px;
            line-height: 1.8;
            color: #64748b;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            color: #334155;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            background: #ffffff;
            font-size: 14px;
            color: #1e293b;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .password-input {
            padding-right: 75px;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #2563eb;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
        }

        .login-button {
            display: block;
            width: 100%;
            padding: 15px;
            margin-top: 5px;
            border: none;
            border-radius: 9px;
            background: #2563eb;
            color: #ffffff;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }

        .login-button:hover {
            background: #1d4ed8;
        }

        .login-button:focus-visible,
        .toggle-password:focus-visible {
            outline: 3px solid #93c5fd;
            outline-offset: 3px;
        }

        .error-message {
            margin-bottom: 22px;
            padding: 13px 15px;
            border-radius: 8px;
            color: #991b1b;
            background: #fee2e2;
            border: 1px solid #fecaca;
            font-size: 13px;
            line-height: 1.7;
        }

        .session-message {
            margin-bottom: 20px;
            padding: 12px 14px;
            border-radius: 8px;
            color: #166534;
            background: #dcfce7;
            font-size: 13px;
        }

        .login-footer {
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            line-height: 1.8;
            margin-top: 30px;
        }

        /* Tampilan tablet dan HP */
        @media (max-width: 760px) {
            body {
                padding: 15px;
                align-items: flex-start;
            }

            .login-container {
                max-width: 480px;
                margin: auto;
                flex-direction: column;
            }

            .school-panel {
                width: 100%;
                padding: 30px 25px;
            }

            .school-logo {
                width: 110px;
                height: 110px;
            }

            .school-name {
                font-size: 23px;
            }

            .school-address {
                margin-bottom: 15px;
            }

            .school-description {
                padding-top: 15px;
            }

            .login-panel {
                padding: 35px 25px;
            }

            .login-heading {
                font-size: 25px;
            }
        }
    </style>
</head>

<body>

    <main class="login-container">

        <!-- Identitas sekolah -->
        <section class="school-panel">

            <div class="logo-wrapper">
                <img
                    src="{{ asset('images/logo-mas-ypi.png') }}"
                    alt="Logo resmi MAS YPI Sumber Harjo"
                    class="school-logo"
                >
            </div>

            <h1 class="school-name">
                MAS YPI SUMBER HARJO
            </h1>

            <div class="school-divider"></div>

            <p class="school-address">
                Jln. Masjid Nurul Iman,<br>
                Desa Sumber Harjo,<br>
                Kecamatan Buay Madang Timur,<br>
                Kabupaten OKU Timur,<br>
                Sumatera Selatan.
            </p>

            <p class="school-description">
                Sistem Informasi Administrasi dan Arsip Digital Sekolah
                (SIADDS).<br>
                Satu sistem untuk mendukung pengelolaan administrasi
                dan dokumen sekolah secara terintegrasi.
            </p>

        </section>

        <!-- Formulir login -->
        <section class="login-panel">

            <h2 class="login-heading">
                Selamat Datang!
            </h2>

            <p class="login-subtitle">
                Silakan masuk menggunakan akun Anda untuk mengakses
                sistem administrasi sekolah.
            </p>

            <!-- Pesan kesalahan validasi -->
            @if ($errors->any())
                <div class="error-message" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Pesan informasi -->
            @if (session('status'))
                <div class="session-message" role="status">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Alamat Email</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="Masukkan alamat email"
                        value="{{ old('email') }}"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>

                    <div class="input-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control password-input"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            id="togglePassword"
                            class="toggle-password"
                            aria-label="Tampilkan password"
                            aria-pressed="false"
                        >
                            Lihat
                        </button>
                    </div>
                </div>

                <button type="submit" class="login-button">
                    Masuk ke Sistem
                </button>
            </form>

            @includeIf('partials.login-sosial')

            <footer class="login-footer">
                &copy; {{ date('Y') }} MAS YPI SUMBER HARJO<br>
                Sistem Informasi Administrasi dan Arsip Digital Sekolah
            </footer>

        </section>

    </main>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';
            togglePassword.textContent = isPassword ? 'Sembunyikan' : 'Lihat';
            togglePassword.setAttribute('aria-pressed', String(isPassword));
            togglePassword.setAttribute(
                'aria-label',
                isPassword ? 'Sembunyikan password' : 'Tampilkan password'
            );
        });
    </script>

</body>
</html>