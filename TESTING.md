# 🧪 Guía de Pruebas

Esta guía describe cómo probar todas las funcionalidades del formulario de contacto.

## 📋 Tabla de Contenidos

1. [Pruebas de Validación](#pruebas-de-validación)
2. [Pruebas de Funcionalidad](#pruebas-de-funcionalidad)
3. [Pruebas de Responsive](#pruebas-de-responsive)
4. [Pruebas de Backend](#pruebas-de-backend)
5. [Pruebas de Seguridad](#pruebas-de-seguridad)
6. [Pruebas de Rendimiento](#pruebas-de-rendimiento)

---

## 1. Pruebas de Validación

### Test 1.1: Campo Nombre Vacío
**Pasos:**
1. Dejar el campo "Nombre" vacío
2. Completar Email y Mensaje
3. Click en "Enviar"

**Resultado Esperado:**
- ❌ Campo nombre resaltado en rojo
- ❌ Mensaje: "El nombre es obligatorio"
- ❌ Formulario no se envía

### Test 1.2: Nombre Muy Corto
**Pasos:**
1. Escribir "A" en el campo Nombre
2. Completar Email y Mensaje
3. Click en "Enviar"

**Resultado Esperado:**
- ❌ Mensaje: "El nombre debe tener al menos 2 caracteres"

### Test 1.3: Email Vacío
**Pasos:**
1. Completar Nombre y Mensaje
2. Dejar Email vacío
3. Click en "Enviar"

**Resultado Esperado:**
- ❌ Campo email resaltado en rojo
- ❌ Mensaje: "El email es obligatorio"

### Test 1.4: Email Inválido
**Casos a probar:**
- `test` (sin @)
- `test@` (sin dominio)
- `test@domain` (sin extensión)
- `@domain.com` (sin usuario)

**Resultado Esperado:**
- ❌ Mensaje: "Por favor, introduce un email válido"

### Test 1.5: Email Válido
**Casos a probar:**
- `test@example.com`
- `user.name@domain.co.uk`
- `user+tag@example.com`

**Resultado Esperado:**
- ✅ Email aceptado sin errores

### Test 1.6: Mensaje Vacío
**Pasos:**
1. Completar Nombre y Email
2. Dejar Mensaje vacío
3. Click en "Enviar"

**Resultado Esperado:**
- ❌ Campo mensaje resaltado en rojo
- ❌ Mensaje: "El mensaje es obligatorio"

### Test 1.7: Mensaje Muy Corto
**Pasos:**
1. Escribir "Hola" en Mensaje (menos de 10 caracteres)
2. Completar otros campos
3. Click en "Enviar"

**Resultado Esperado:**
- ❌ Mensaje: "El mensaje debe tener al menos 10 caracteres"

### Test 1.8: Formulario Válido Completo
**Pasos:**
1. Nombre: "Juan Pérez"
2. Email: "juan@example.com"
3. Mensaje: "Este es un mensaje de prueba válido"
4. Click en "Enviar"

**Resultado Esperado:**
- ✅ Mensaje de éxito mostrado
- ✅ Formulario oculto
- ✅ Datos guardados en base de datos

---

## 2. Pruebas de Funcionalidad

### Test 2.1: Mensaje de Ayuda Flotante
**Pasos:**
1. Click en el campo "Mensaje"
2. Comenzar a escribir

**Resultado Esperado:**
- ✅ Aparece mensaje flotante: "No compartas datos sensibles"
- ✅ Mensaje tiene ícono de información
- ✅ Mensaje desaparece al salir del campo

### Test 2.2: Limpieza de Errores al Escribir
**Pasos:**
1. Intentar enviar formulario con campos vacíos
2. Comenzar a escribir en un campo con error

**Resultado Esperado:**
- ✅ Error desaparece al comenzar a escribir
- ✅ Borde rojo desaparece

### Test 2.3: Validación en Tiempo Real (onBlur)
**Pasos:**
1. Escribir email inválido
2. Salir del campo (blur)

**Resultado Esperado:**
- ✅ Error mostrado inmediatamente sin enviar formulario

### Test 2.4: Estado de Carga
**Pasos:**
1. Completar formulario válido
2. Click en "Enviar"
3. Observar botón durante el envío

**Resultado Esperado:**
- ✅ Botón muestra spinner de carga
- ✅ Botón deshabilitado durante envío
- ✅ No se puede hacer doble submit

### Test 2.5: Botón Reset
**Pasos:**
1. Enviar formulario exitosamente
2. Click en "Enviar otro mensaje"

**Resultado Esperado:**
- ✅ Formulario reaparece
- ✅ Todos los campos vacíos
- ✅ Sin errores visibles

### Test 2.6: Prevención de Múltiples Envíos
**Pasos:**
1. Completar formulario
2. Click rápido múltiples veces en "Enviar"

**Resultado Esperado:**
- ✅ Solo un registro en base de datos
- ✅ Botón deshabilitado después del primer click

---

## 3. Pruebas de Responsive

### Test 3.1: Mobile (320px - 640px)
**Dispositivos a probar:**
- iPhone SE (375x667)
- iPhone 12 (390x844)
- Samsung Galaxy S20 (360x800)

**Verificar:**
- ✅ Formulario ocupa todo el ancho
- ✅ Campos son fáciles de tocar (min 44px)
- ✅ Texto legible sin zoom
- ✅ Botón de envío accesible
- ✅ Mensaje flotante no se sale de pantalla

### Test 3.2: Tablet (641px - 1024px)
**Dispositivos a probar:**
- iPad (768x1024)
- iPad Pro (1024x1366)

**Verificar:**
- ✅ Formulario centrado
- ✅ Padding adecuado
- ✅ Tamaño de fuente apropiado

### Test 3.3: Desktop (1025px+)
**Resoluciones a probar:**
- 1366x768
- 1920x1080
- 2560x1440

**Verificar:**
- ✅ Formulario no demasiado ancho (max-width)
- ✅ Centrado verticalmente y horizontalmente
- ✅ Animaciones suaves

### Test 3.4: Orientación
**Pasos:**
1. Abrir en móvil en modo portrait
2. Rotar a landscape

**Resultado Esperado:**
- ✅ Formulario se adapta correctamente
- ✅ Sin scroll horizontal

---

## 4. Pruebas de Backend

### Test 4.1: Conexión a Base de Datos
**Comando:**
```bash
curl http://localhost:8000/api/test-connection.php
```

**Resultado Esperado:**
```json
{
  "success": true,
  "message": "Conexión exitosa a la base de datos"
}
```

### Test 4.2: Envío POST Válido
**Comando:**
```bash
curl -X POST http://localhost:8000/api/submit.php \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Test Usuario",
    "email": "test@example.com",
    "mensaje": "Este es un mensaje de prueba desde curl"
  }'
```

**Resultado Esperado:**
```json
{
  "success": true,
  "message": "Formulario enviado correctamente",
  "data": {
    "id": 1,
    "nombre": "Test Usuario",
    "email": "test@example.com"
  }
}
```

### Test 4.3: Envío POST Inválido
**Comando:**
```bash
curl -X POST http://localhost:8000/api/submit.php \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "",
    "email": "invalid-email",
    "mensaje": "corto"
  }'
```

**Resultado Esperado:**
```json
{
  "success": false,
  "message": "Errores de validación",
  "errors": [...]
}
```

### Test 4.4: Método GET (No Permitido)
**Comando:**
```bash
curl -X GET http://localhost:8000/api/submit.php
```

**Resultado Esperado:**
- HTTP 405 Method Not Allowed

### Test 4.5: Verificación en Base de Datos
**SQL:**
```sql
-- Ver últimos 5 contactos
SELECT * FROM contactos ORDER BY fecha_envio DESC LIMIT 5;

-- Contar total de contactos
SELECT COUNT(*) as total FROM contactos;

-- Buscar por email
SELECT * FROM contactos WHERE email = 'test@example.com';
```

---

## 5. Pruebas de Seguridad

### Test 5.1: SQL Injection
**Intentos:**
```json
{
  "nombre": "'; DROP TABLE contactos; --",
  "email": "test@example.com",
  "mensaje": "Test SQL injection"
}
```

**Resultado Esperado:**
- ✅ Datos sanitizados
- ✅ Tabla no eliminada
- ✅ Prepared statements previenen inyección

### Test 5.2: XSS (Cross-Site Scripting)
**Intentos:**
```json
{
  "nombre": "<script>alert('XSS')</script>",
  "email": "test@example.com",
  "mensaje": "<img src=x onerror=alert('XSS')>"
}
```

**Resultado Esperado:**
- ✅ HTML escapado
- ✅ Script no ejecutado
- ✅ Datos guardados de forma segura

### Test 5.3: CSRF (Cross-Site Request Forgery)
**Nota:** En producción, implementar tokens CSRF

### Test 5.4: Validación de Longitud Máxima
**Intentos:**
- Nombre: 200 caracteres
- Email: 200 caracteres
- Mensaje: 2000 caracteres

**Resultado Esperado:**
- ✅ Backend rechaza datos demasiado largos
- ✅ Mensaje de error apropiado

### Test 5.5: Caracteres Especiales
**Intentos:**
```json
{
  "nombre": "José María Ñoño",
  "email": "josé@example.com",
  "mensaje": "Mensaje con áéíóú ñ ¿? ¡!"
}
```

**Resultado Esperado:**
- ✅ Caracteres UTF-8 guardados correctamente
- ✅ Sin corrupción de datos

---

## 6. Pruebas de Rendimiento

### Test 6.1: Tiempo de Carga
**Herramienta:** Chrome DevTools (Lighthouse)

**Métricas Esperadas:**
- First Contentful Paint: < 1.5s
- Time to Interactive: < 3s
- Speed Index: < 2s

### Test 6.2: Tamaño de Archivos
**Verificar:**
- HTML: < 10 KB
- CSS: < 20 KB
- JS: < 15 KB
- Total: < 50 KB

### Test 6.3: Múltiples Envíos Simultáneos
**Herramienta:** Apache Bench

```bash
ab -n 100 -c 10 -p data.json -T application/json \
  http://localhost:8000/api/submit.php
```

**Resultado Esperado:**
- ✅ Todos los requests procesados
- ✅ Sin errores de conexión
- ✅ Tiempo de respuesta < 500ms

### Test 6.4: Carga de Base de Datos
**Verificar con 1000+ registros:**
```sql
-- Insertar datos de prueba
INSERT INTO contactos (nombre, email, mensaje, fecha_envio)
SELECT 
  CONCAT('Usuario ', n),
  CONCAT('user', n, '@example.com'),
  CONCAT('Mensaje de prueba número ', n),
  NOW() - INTERVAL FLOOR(RAND() * 365) DAY
FROM (
  SELECT @row := @row + 1 AS n
  FROM information_schema.columns, (SELECT @row := 0) r
  LIMIT 1000
) numbers;
```

**Resultado Esperado:**
- ✅ Inserción rápida (< 1s)
- ✅ Consultas con índices eficientes

---

## 7. Pruebas de Accesibilidad

### Test 7.1: Navegación con Teclado
**Pasos:**
1. Usar solo Tab para navegar
2. Usar Enter para enviar

**Resultado Esperado:**
- ✅ Todos los campos accesibles
- ✅ Orden lógico de tabulación
- ✅ Focus visible

### Test 7.2: Screen Reader
**Herramienta:** NVDA (Windows) o VoiceOver (macOS)

**Verificar:**
- ✅ Labels leídos correctamente
- ✅ Errores anunciados
- ✅ Mensaje de éxito anunciado

### Test 7.3: Contraste de Colores
**Herramienta:** Chrome DevTools (Lighthouse)

**Resultado Esperado:**
- ✅ Ratio de contraste > 4.5:1 para texto normal
- ✅ Ratio de contraste > 3:1 para texto grande

---

## 📊 Checklist de Pruebas Completo

### Validación
- [ ] Nombre vacío
- [ ] Nombre muy corto
- [ ] Email vacío
- [ ] Email inválido
- [ ] Mensaje vacío
- [ ] Mensaje muy corto
- [ ] Formulario válido completo

### Funcionalidad
- [ ] Mensaje de ayuda flotante
- [ ] Limpieza de errores
- [ ] Validación en tiempo real
- [ ] Estado de carga
- [ ] Botón reset
- [ ] Prevención de múltiples envíos

### Responsive
- [ ] Mobile (320px-640px)
- [ ] Tablet (641px-1024px)
- [ ] Desktop (1025px+)
- [ ] Cambio de orientación

### Backend
- [ ] Conexión a BD
- [ ] POST válido
- [ ] POST inválido
- [ ] Método GET rechazado
- [ ] Verificación en BD

### Seguridad
- [ ] SQL Injection
- [ ] XSS
- [ ] Validación de longitud
- [ ] Caracteres especiales

### Rendimiento
- [ ] Tiempo de carga
- [ ] Tamaño de archivos
- [ ] Múltiples envíos
- [ ] Carga de BD

### Accesibilidad
- [ ] Navegación con teclado
- [ ] Screen reader
- [ ] Contraste de colores

---

## 🐛 Reporte de Bugs

Si encuentras un bug durante las pruebas, reportarlo con:

1. **Título**: Descripción breve
2. **Pasos para reproducir**: Lista numerada
3. **Resultado esperado**: Qué debería pasar
4. **Resultado actual**: Qué pasó realmente
5. **Screenshots**: Si aplica
6. **Entorno**: Navegador, OS, versión

---

## ✅ Criterios de Aceptación

El proyecto pasa las pruebas si:
- ✅ Todas las validaciones funcionan correctamente
- ✅ Datos se guardan en base de datos
- ✅ Diseño responsive en todos los dispositivos
- ✅ Sin vulnerabilidades de seguridad críticas
- ✅ Tiempo de carga < 3 segundos
- ✅ Accesible con teclado y screen reader

---

**Última actualización**: Enero 2026

