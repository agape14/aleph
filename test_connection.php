<?php
/**
 * Script de prueba de conexión SSL para Azure MySQL usando variables de entorno de Laravel
 * Ejecutar desde la línea de comandos: php test_connection.php
 */

// Cargar variables de entorno como lo hace Laravel
function loadEnv($path) {
    if (!file_exists($path)) {
        return [];
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];

    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $env[trim($name)] = trim($value);
    }

    return $env;
}

// Cargar variables de entorno
$env = loadEnv('.env');

echo "=== PRUEBA DE CONEXIÓN SSL A AZURE MYSQL (CONFIGURACIÓN LARAVEL) ===\n\n";

// Configuración de base de datos usando variables de entorno
$config = [
    'host' => $env['DB_HOST'] ?? 'sql-prod-001-eximio.mysql.database.azure.com',
    'port' => $env['DB_PORT'] ?? 3306,
    'database' => $env['DB_DATABASE'] ?? 'aleph',
    'username' => $env['DB_USERNAME'] ?? 'aleph',
    'password' => $env['DB_PASSWORD'] ?? '3ximio@2024$',
    'ssl_cert' => $env['DB_SSL_CERT'] ?? '/var/www/certificado/DigiCertGlobalRootCA.crt.pem',
    'ssl_mode' => $env['DB_SSL_MODE'] ?? 'true',
];

echo "Configuración desde .env:\n";
echo "- Host: {$config['host']}\n";
echo "- Puerto: {$config['port']}\n";
echo "- Base de datos: {$config['database']}\n";
echo "- Usuario: {$config['username']}\n";
echo "- Certificado SSL: {$config['ssl_cert']}\n";
echo "- Modo SSL: {$config['ssl_mode']}\n\n";

// Mostrar variables de entorno cargadas
echo "Variables de entorno DB_* encontradas:\n";
foreach ($env as $key => $value) {
    if (strpos($key, 'DB_') === 0) {
        echo "- {$key}: " . (strpos($key, 'PASSWORD') !== false ? '***' : $value) . "\n";
    }
}
echo "\n";

// Verificar si el certificado existe
echo "1. Verificando certificado SSL...\n";
if (file_exists($config['ssl_cert'])) {
    echo "✅ Certificado encontrado: {$config['ssl_cert']}\n";
    echo "   Tamaño: " . filesize($config['ssl_cert']) . " bytes\n";
    echo "   Permisos: " . substr(sprintf('%o', fileperms($config['ssl_cert'])), -4) . "\n";
} else {
    echo "❌ Certificado NO encontrado: {$config['ssl_cert']}\n";
    echo "   Intentando descargar...\n";

    $cert_content = file_get_contents('https://www.digicert.com/CACerts/DigiCertGlobalRootCA.crt.pem');
    if ($cert_content) {
        $dir = dirname($config['ssl_cert']);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        if (file_put_contents($config['ssl_cert'], $cert_content)) {
            echo "✅ Certificado descargado exitosamente\n";
        } else {
            echo "❌ Error al guardar certificado\n";
        }
    } else {
        echo "❌ Error al descargar certificado\n";
    }
}

echo "\n2. Probando conexiones con diferentes configuraciones SSL...\n\n";

// Configuraciones SSL a probar - INCLUYENDO LA CONFIGURACIÓN EXACTA DE LARAVEL
$ssl_configs = [
    'Laravel Actual (database.php)' => [
        'dsn' => "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']}",
        'options' => [
            PDO::ATTR_TIMEOUT => 600,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Configuración SSL exacta que funciona (según test_connection.php)
            PDO::MYSQL_ATTR_SSL_CA => $config['ssl_cert'],
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
        ]
    ],
    'Sin SSL' => [
        'dsn' => "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']}",
        'options' => [
            PDO::ATTR_TIMEOUT => 30,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]
    ],
    'SSL Requerido' => [
        'dsn' => "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']}",
        'options' => [
            PDO::ATTR_TIMEOUT => 30,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_SSL_CA => $config['ssl_cert'],
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
        ]
    ],
    'SSL con verificación' => [
        'dsn' => "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']}",
        'options' => [
            PDO::ATTR_TIMEOUT => 30,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_SSL_CA => $config['ssl_cert'],
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true,
        ]
    ],
    'SSL solo requerido' => [
        'dsn' => "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};sslmode=require",
        'options' => [
            PDO::ATTR_TIMEOUT => 30,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]
    ]
];

$successful_config = null;

foreach ($ssl_configs as $name => $ssl_config) {
    echo "Probando: {$name}...\n";

    try {
        $pdo = new PDO(
            $ssl_config['dsn'],
            $config['username'],
            $config['password'],
            $ssl_config['options']
        );

        // Probar consulta simple
        $stmt = $pdo->query("SELECT 1 as test");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['test'] == 1) {
            echo "✅ {$name}: CONEXIÓN EXITOSA\n";
            if (!$successful_config) {
                $successful_config = $name;
            }

            // Probar consulta a la tabla configuraciones
            try {
                $stmt = $pdo->query("SELECT * FROM configuraciones WHERE nombre = 'registro_solicitud' LIMIT 1");
                $config_result = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "   ✅ Consulta a configuraciones exitosa\n";
                if ($config_result) {
                    echo "   📊 Datos encontrados: " . json_encode($config_result) . "\n";
                } else {
                    echo "   ⚠️  No se encontraron datos en configuraciones\n";
                }
            } catch (Exception $e) {
                echo "   ❌ Error en consulta configuraciones: " . $e->getMessage() . "\n";
            }
        } else {
            echo "❌ {$name}: Respuesta inesperada\n";
        }

    } catch (PDOException $e) {
        echo "❌ {$name}: ERROR - " . $e->getMessage() . "\n";
    } catch (Exception $e) {
        echo "❌ {$name}: ERROR GENERAL - " . $e->getMessage() . "\n";
    }

    echo "\n";
}

// Mostrar recomendación
echo "=== RECOMENDACIÓN ===\n";
if ($successful_config) {
    echo "✅ Configuración exitosa encontrada: {$successful_config}\n";
    echo "\nPara usar esta configuración en Laravel, actualiza tu config/database.php:\n\n";

    switch ($successful_config) {
        case 'Laravel Actual (database.php)':
            echo "✅ La configuración actual de Laravel FUNCIONA correctamente!\n";
            echo "Tu config/database.php está bien configurado.\n";
            echo "El problema puede estar en:\n";
            echo "- Caché de configuración (ejecutar: php artisan config:clear)\n";
            echo "- Variables de entorno no cargadas correctamente\n";
            echo "- Otro problema en la aplicación\n";
            break;
        case 'Sin SSL':
            echo "DB_SSL_MODE=false\n";
            break;
        case 'SSL Requerido':
            echo "DB_SSL_MODE=true\n";
            echo "DB_SSL_CERT=/var/www/certificado/DigiCertGlobalRootCA.crt.pem\n";
            break;
        case 'SSL con verificación':
            echo "DB_SSL_MODE=verify\n";
            echo "DB_SSL_CERT=/var/www/certificado/DigiCertGlobalRootCA.crt.pem\n";
            break;
        case 'SSL solo requerido':
            echo "DB_SSL_MODE=require\n";
            break;
    }
} else {
    echo "❌ Ninguna configuración SSL funcionó.\n";
    echo "Posibles problemas:\n";
    echo "- Verificar conectividad de red\n";
    echo "- Verificar credenciales de base de datos\n";
    echo "- Verificar configuración de firewall\n";
    echo "- Contactar soporte de Azure MySQL\n";
}

echo "\n=== INFORMACIÓN DEL SISTEMA ===\n";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "PDO MySQL: " . (extension_loaded('pdo_mysql') ? '✅ Disponible' : '❌ No disponible') . "\n";
echo "OpenSSL: " . (extension_loaded('openssl') ? '✅ Disponible' : '❌ No disponible') . "\n";
echo "Sistema: " . php_uname() . "\n";

echo "\n=== FIN DE PRUEBA ===\n";
