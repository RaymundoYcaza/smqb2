<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .login-container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #d4edda;
        }

        .login-form {
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
        }

        h1,
        h4 {
            text-align: center;
        }

        .login-form input[type="text"] {
            font-weight: bold;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .login-form button {
            border-radius: 20px;
            background-color: #ff6600;
            border: 2px solid #cc5200;
            color: white;
        }

        .logo-container {
            display: flex;
        }

        .logo {
            width: 250px;
            margin-left: auto;
            margin-right: auto;
        }

        @media (max-width: 1280px) {
            .login-form {
                padding: 20px;
                width: 95vw;
                font-size: 1.5rem;
            }

            h1 {
                font-size: 4rem;
            }

            h4 {
                font-size: 3rem;
            }

            .btn {
                font-size: 4rem;
            }

            input[type="text"] {
                font-size: 3rem;
                min-height: 4em;
            }

            input,
            input::placeholder {
                font: 3rem sans-serif;
                margin: 6rem 0 6rem 0;
            }

            button {
                margin: 6rem 0 6rem 0;
            }

            .logo-container {
                display: flex;
            }

            .logo {
                width: 500px;
                margin-left: auto;
                margin-right: auto;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-form">
            <h1>Acceder</h1>
            <div class="logo-container">
                <img src="<?= base_url('assets/images/logo-dole.png'); ?>" class="logo" />
            </div>
            <h4>Ingresa tu código personal</h4>
            <form action="<?= base_url('index.php/auth/loginDole') ?>" method="post">
                <input type="text" name="username" placeholder="Código personal" class="form-control" required>
                <input type="hidden" name="redirect_url" value="<?= isset($redirect_url) ? $redirect_url : '' ?>">
                <button type="submit" class="btn btn-block">Ingresar</button>
            </form>
            <?= $this->session->flashdata('error'); ?>
        </div>
    </div>
</body>

</html>