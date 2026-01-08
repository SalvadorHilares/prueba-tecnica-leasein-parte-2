<?php
/**
 * API para procesar y guardar datos del formulario de contacto
 * 
 * Este script recibe los datos del formulario vía POST (JSON),
 * los valida y los guarda en la base de datos MySQL
 */

// Configuración de headers para CORS y JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Solo aceptar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido. Use POST.'
    ]);
    exit();
}

// Incluir configuración de base de datos
require_once __DIR__ . '/config.php';

/**
 * Función para validar email
 */
function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Función para sanitizar datos
 */
function sanitizar($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

try {
    // Leer datos JSON del body
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    // Verificar que se recibieron datos
    if (!$data) {
        throw new Exception('No se recibieron datos válidos');
    }
    
    // Obtener y sanitizar datos
    $nombre = isset($data['nombre']) ? sanitizar($data['nombre']) : '';
    $email = isset($data['email']) ? sanitizar($data['email']) : '';
    $mensaje = isset($data['mensaje']) ? sanitizar($data['mensaje']) : '';
    
    // Array para almacenar errores de validación
    $errores = [];
    
    // Validar nombre
    if (empty($nombre)) {
        $errores[] = 'El nombre es obligatorio';
    } elseif (strlen($nombre) < 2) {
        $errores[] = 'El nombre debe tener al menos 2 caracteres';
    } elseif (strlen($nombre) > 100) {
        $errores[] = 'El nombre no puede exceder 100 caracteres';
    }
    
    // Validar email
    if (empty($email)) {
        $errores[] = 'El email es obligatorio';
    } elseif (!validarEmail($email)) {
        $errores[] = 'El email no tiene un formato válido';
    } elseif (strlen($email) > 100) {
        $errores[] = 'El email no puede exceder 100 caracteres';
    }
    
    // Validar mensaje
    if (empty($mensaje)) {
        $errores[] = 'El mensaje es obligatorio';
    } elseif (strlen($mensaje) < 10) {
        $errores[] = 'El mensaje debe tener al menos 10 caracteres';
    } elseif (strlen($mensaje) > 1000) {
        $errores[] = 'El mensaje no puede exceder 1000 caracteres';
    }
    
    // Si hay errores, retornarlos
    if (!empty($errores)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Errores de validación',
            'errors' => $errores
        ]);
        exit();
    }
    
    // Conectar a la base de datos
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Verificar conexión
    if ($conn->connect_error) {
        throw new Exception('Error de conexión a la base de datos');
    }
    
    // Configurar charset
    $conn->set_charset('utf8mb4');
    
    // Preparar consulta SQL
    $stmt = $conn->prepare("INSERT INTO contactos (nombre, email, mensaje, fecha_envio) VALUES (?, ?, ?, NOW())");
    
    if (!$stmt) {
        throw new Exception('Error al preparar la consulta');
    }
    
    // Vincular parámetros
    $stmt->bind_param("sss", $nombre, $email, $mensaje);
    
    // Ejecutar consulta
    if (!$stmt->execute()) {
        throw new Exception('Error al guardar los datos');
    }
    
    // Obtener ID del registro insertado
    $insertId = $stmt->insert_id;
    
    // Cerrar statement y conexión
    $stmt->close();
    $conn->close();
    
    // Respuesta exitosa
    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Formulario enviado correctamente',
        'data' => [
            'id' => $insertId,
            'nombre' => $nombre,
            'email' => $email
        ]
    ]);
    
} catch (Exception $e) {
    // Log del error (en producción, usar un sistema de logs apropiado)
    error_log('Error en submit.php: ' . $e->getMessage());
    
    // Respuesta de error
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al procesar la solicitud: ' . $e->getMessage()
    ]);
}
?>

