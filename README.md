# Formulario de Contacto - Bloque Personalizado Elementor

Proyecto de formulario de contacto con validación en JavaScript puro, backend PHP y base de datos MySQL. Diseñado para ser insertado como bloque personalizado en Elementor.

## 📋 Características

- ✅ Formulario HTML con validación completa
- ✅ Validación en tiempo real con JavaScript puro (sin frameworks)
- ✅ Diseño responsive (mobile-first)
- ✅ Mensajes de error dinámicos
- ✅ Ayuda flotante en campo de mensaje
- ✅ Backend PHP para procesar datos
- ✅ Base de datos MySQL para almacenar contactos
- ✅ Animaciones y transiciones suaves
- ✅ Accesibilidad mejorada

## 🚀 Tecnologías Utilizadas

- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Backend**: PHP 7.4+
- **Base de datos**: MySQL 8.0
- **Contenedores**: Docker & Docker Compose

## 📁 Estructura del Proyecto

```
prueba-tecnica-leasein-parte-2/
├── index.html              # Página principal con el formulario
├── styles.css              # Estilos CSS responsive
├── script.js               # Lógica de validación y envío
├── database.sql            # Script SQL para crear la base de datos
├── docker-compose.yml      # Configuración de Docker Compose
├── Dockerfile              # Imagen Docker para despliegue
├── install.sh              # Script de instalación (Linux/Mac)
├── install.bat             # Script de instalación (Windows)
├── api/
│   ├── config.php         # Configuración de base de datos
│   ├── config.example.php # Ejemplo de configuración
│   ├── submit.php         # API para procesar el formulario
│   └── test-connection.php # Script para probar la conexión DB
└── README.md              # Este archivo
```

### Instalación Manual

Si prefieres hacerlo manualmente:

1. **Iniciar los contenedores:**
```bash
docker-compose up -d
```

2. **Esperar a que MySQL inicialice (30-60 segundos)**

3. **Verificar que todo esté funcionando:**
```bash
docker ps
```

Deberías ver 3 contenedores corriendo:
- `formulario-web` (PHP + Apache)
- `formulario-db` (MySQL)
- `formulario-phpmyadmin` (phpMyAdmin)

## 🌐 Acceder a la Aplicación

Una vez que los contenedores estén corriendo:

- **Aplicación Web**: http://localhost:8000
- **phpMyAdmin**: http://localhost:8080
  - Usuario: `root`
  - Contraseña: `rootpassword`
  - Servidor: `db`

## 🧪 Probar el Formulario

1. Abrir http://localhost:8000 en tu navegador
2. Completar el formulario con datos válidos:
   - **Nombre**: Tu nombre completo
   - **Email**: tu@email.com
   - **Mensaje**: Tu mensaje (mínimo 10 caracteres)
3. Click en "Enviar"
4. Deberías ver el mensaje: "¡Gracias por contactarnos!"

### Verificar en la Base de Datos

Puedes ver los contactos guardados en phpMyAdmin (http://localhost:8080) o ejecutando:

```bash
docker exec -it formulario-db mysql -u root -prootpassword -e "SELECT * FROM formulario_contacto.contactos ORDER BY fecha_envio DESC;"
```

## 📊 Base de Datos

### Tabla: contactos

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | INT | ID autoincremental (PK) |
| nombre | VARCHAR(100) | Nombre del contacto |
| email | VARCHAR(100) | Email del contacto |
| mensaje | TEXT | Mensaje del contacto |
| fecha_envio | DATETIME | Fecha y hora del envío |

La base de datos se crea automáticamente al iniciar los contenedores usando el archivo `database.sql`.
