<!DOCTYPE html>
<html lang="es" data-theme="ligth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.classless.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.colors.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="/assets/css/Styles2.css">
    <title>Iniciar Sesión</title>
</head>

<body>
    <main>
        <form method="post" action="index.php?accion=autenticar" class="modern-form animate__animated animate__bounceInLeft">
            <div class="form-title">Iniciar sesión</div>

            <div class="form-body">

                <div class="input-group">
                    <div class="input-wrapper">
                        <svg fill="none" viewBox="0 0 24 24" class="input-icon">
                            <path
                                stroke-width="1.5"
                                stroke="currentColor"
                                d="M3 8L10.8906 13.2604C11.5624 13.7083 12.4376 13.7083 13.1094 13.2604L21 8M5 19H19C20.1046 19 21 18.1046 21 17V7C21 5.89543 20.1046 5 19 5H5C3.89543 5 3 5.89543 3 7V17C3 18.1046 3.89543 19 5 19Z"></path>
                        </svg>
                        <input name="correo" required placeholder="Email" class="form-input" type="email"/>
                    </div>
                </div>

                <div class="input-group">
                    <div class="input-wrapper">
                        <svg fill="none" viewBox="0 0 24 24" class="input-icon">
                            <path
                                stroke-width="1.5"
                                stroke="currentColor"
                                d="M12 10V14M8 6H16C17.1046 6 18 6.89543 18 8V16C18 17.1046 17.1046 18 16 18H8C6.89543 18 6 17.1046 6 16V8C6 6.89543 6.89543 6 8 6Z"></path>
                        </svg>
                        <input name="contraseña" required placeholder="Password" class="form-input" type="password" />
                    </div>
                </div>
            </div>
            <button type="submit" name="iniciar-sesion" class="submit-button">
                <span class="button-text">Iniciar sesión</span>
                <div class="button-glow"></div>
            </button>

            <div class="form-footer">
                <a class="login-link" href="index.php?accion=default">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M20 11v2H8l5.5 5.5l-1.42 1.42L4.16 12l7.92-7.92L13.5 5.5L8 11z" stroke-width="0.5" stroke="currentColor" />
                    </svg>
                    Regresar
                </a>
            </div>
        </form>
    </main>

</body>

</html>