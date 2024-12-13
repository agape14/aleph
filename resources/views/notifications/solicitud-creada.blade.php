<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud Creada</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Fuente más moderna y limpia */
            margin: 0;
            padding: 0;
        }
        /* Estilos para la caja principal */
        .email-container {
            background-color: #EDF2F6;
            width: 100%; /* Ajusta el ancho del contenedor */

        }

        /* Estilo para el header, donde se encuentra el logo */
        .email-header {
            text-align: center;
        }

        /* Estilo para el pie de la notificación */
        .email-footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }

        /* Estilo para la tabla de contenido */
        table {
            margin: 0 auto; /* Centrado horizontal */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); /* Sombra para el contenedor */
            width: 50%;
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
            background-color: #FFFFFF;
        }

        /* Estilo del enlace que simula un botón */
        .email-button {
            background-color: #3d78a8;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        .email-button {
            background-color: #3d78a8;
            color: white;
            padding: 10px 20px;
            text-decoration: none; /* Elimina el subrayado */
            border-radius: 5px;
            display: inline-block;
        }

        .email-button:hover {
            background-color: #2c5f7b; /* Cambiar color de fondo en hover si es necesario */
            color: white;
        }

        /* Asegúrate de que no haya estilo heredado para los enlaces */
        a {
            text-decoration: none;
            color: inherit; /* El color heredará de la clase .email-button */
        }

        /* Mejorar el aspecto de la tabla */
        td {
            padding: 8px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <br><br><br><br>
        <div class="email-header">
            <!-- Asegúrate de tener el logo adecuado en la ruta correcta -->
            <img src="{{ asset('images/Aleph-school.png') }}" alt="Logo" style="width: 200px; height: auto;">
        </div>

        <!-- Tabla para organizar la información -->
        <table>
            <tr>
                <td colspan="2">
                    <h1>Hola {{ $usuario }}</h1>

                    <p>Se ha registrado una nueva solicitud de beca.</p>

                    <h2>Detalles de la solicitud:</h2>
                    <ul>
                        <li><strong>Nombre:</strong> {{ $nombre }}</li>
                        <li><strong>Apellido:</strong> {{ $apellido }}</li>
                    </ul>

                    <div style="width: 100%;text-align: center;">
                        <a href="https://aleph.eximio.com.pe/login" class="email-button" target="_blank">
                            Ver Solicitud
                        </a>
                    </div>

                    <p>
                        Si tienes problemas haciendo clic en el botón "Ver Solicitud", copia y pega la URL siguiente en tu navegador:
                        <br>
                        {{ $url_alternativa }}
                    </p>
                </td>
            </tr>
        </table>

        <div class="email-footer">
            <p>Saludos, <strong>Aleph</strong></p>
            <br><br><br><br>
        </div>
    </div>
</body>
</html>

