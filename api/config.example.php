<?php
/**
 * Ejemplo de configuración de la base de datos
 * 
 * Copia este archivo como config.php y actualiza con tus credenciales
 */

// Configuración para desarrollo local
define('DB_HOST', 'localhost');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');
define('DB_NAME', 'formulario_contacto');

// Configuración para producción (usando variables de entorno)
// Descomenta estas líneas en producción y comenta las de arriba
/*
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'formulario_contacto');
*/

// Zona horaria
date_default_timezone_set('America/Lima');

// Configuración de errores (desactivar en producción)
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);
?>

