<?php
/**
 * Script para probar la conexión a la base de datos
 * 
 * Ejecutar este script para verificar que la configuración de la base de datos es correcta
 */

require_once __DIR__ . '/config.php';

header('Content-Type: application/json; charset=utf-8');

try {
    // Intentar conectar
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Verificar conexión
    if ($conn->connect_error) {
        throw new Exception('Error de conexión: ' . $conn->connect_error);
    }
    
    // Configurar charset
    $conn->set_charset('utf8mb4');
    
    // Verificar que la tabla existe
    $result = $conn->query("SHOW TABLES LIKE 'contactos'");
    
    if ($result->num_rows === 0) {
        throw new Exception('La tabla "contactos" no existe. Por favor, ejecuta el script database.sql');
    }
    
    // Obtener información de la base de datos
    $version = $conn->server_info;
    $charset = $conn->character_set_name();
    
    // Contar registros
    $count_result = $conn->query("SELECT COUNT(*) as total FROM contactos");
    $count = $count_result->fetch_assoc()['total'];
    
    $conn->close();
    
    // Respuesta exitosa
    echo json_encode([
        'success' => true,
        'message' => 'Conexión exitosa a la base de datos',
        'data' => [
            'host' => DB_HOST,
            'database' => DB_NAME,
            'mysql_version' => $version,
            'charset' => $charset,
            'total_contactos' => $count
        ]
    ], JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}
?>

