<?php
/**
 * Configuración de la base de datos
 * 
 * IMPORTANTE: En producción, estas credenciales deben estar en variables de entorno
 * y NO en el código fuente
 */

// Configuración usando variables de entorno (Docker) o valores por defecto (local)
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'formulario_contacto');

// Zona horaria
date_default_timezone_set('America/Lima');

// Configuración de errores (desactivar en producción)
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);
?>

