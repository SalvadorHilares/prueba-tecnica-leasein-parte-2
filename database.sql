-- ============================================
-- Base de datos para Formulario de Contacto
-- ============================================

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS formulario_contacto
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Usar la base de datos
USE formulario_contacto;

-- Eliminar la tabla si existe (útil para desarrollo)
DROP TABLE IF EXISTS contactos;

-- Crear tabla contactos
CREATE TABLE contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    mensaje TEXT NOT NULL,
    fecha_envio DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_fecha_envio (fecha_envio)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar algunos datos de ejemplo (opcional)
INSERT INTO contactos (nombre, email, mensaje, fecha_envio) VALUES
('Juan Pérez', 'juan.perez@example.com', 'Hola, me gustaría obtener más información sobre sus servicios.', NOW()),
('María García', 'maria.garcia@example.com', 'Excelente trabajo, me encantaría trabajar con ustedes en un proyecto.', NOW() - INTERVAL 1 DAY),
('Carlos López', 'carlos.lopez@example.com', 'Tengo una consulta sobre los precios de sus productos.', NOW() - INTERVAL 2 DAY);

-- Verificar que la tabla se creó correctamente
SELECT 'Tabla creada exitosamente' AS resultado;

-- Mostrar la estructura de la tabla
DESCRIBE contactos;

-- Mostrar los registros de ejemplo
SELECT * FROM contactos;

