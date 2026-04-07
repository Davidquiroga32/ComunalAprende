# Comunal Aprende

Plataforma web de formación y capacitación para organizaciones de acción comunal en Colombia. Permite a líderes comunitarios acceder a cursos en línea, realizar evaluaciones y obtener certificados de participación verificables.

---

## Tabla de contenido

1. [Descripción general](#descripción-general)
2. [Tecnologías utilizadas](#tecnologías-utilizadas)
3. [Requisitos previos](#requisitos-previos)
4. [Instalación y configuración](#instalación-y-configuración)
5. [Variables de entorno](#variables-de-entorno)
6. [Estructura del proyecto](#estructura-del-proyecto)
7. [Módulos principales](#módulos-principales)
8. [Roles y permisos](#roles-y-permisos)
9. [Base de datos](#base-de-datos)
10. [Comandos útiles](#comandos-útiles)
11. [Autor](#autor)

---

## Descripción general

**Comunal Aprende** es una aplicación web desarrollada con Laravel 12 orientada a la capacitación de integrantes de organismos de acción comunal (OAC) en Colombia. La plataforma ofrece:

- Catálogo de cursos organizados por módulos y lecciones
- Reproductor de contenido (texto enriquecido con imágenes, video de YouTube/Vimeo o video propio, PDF)
- Sistema de evaluaciones (quizzes) con múltiples tipos de pregunta
- Seguimiento de progreso por lección y curso
- Generación y descarga de certificados en PDF con código QR de verificación
- Panel de administración para gestión de cursos, módulos, lecciones y quizzes
- Autenticación con registro, login y recuperación de contraseña en español (Laravel Breeze)

---

## Tecnologías utilizadas

| Capa | Tecnología | Versión |
|---|---|---|
| Backend | PHP + Laravel | 8.2 / 12.x |
| Frontend | Blade + Tailwind CSS + Alpine.js | Tailwind 3.x / Alpine 3.x |
| Build tool | Vite + Node.js + npm | Vite 7.x |
| Base de datos | MySQL | 8.x |
| Editor de texto enriquecido | TinyMCE | 7.x (CDN) |
| Generación de PDF | Spatie Browsershot + Puppeteer | Browsershot 5.x |
| Código QR | SimpleSoftwareIO/simple-qrcode | 4.x |
| Autenticación | Laravel Breeze | 2.x |
| Testing | PestPHP | 3.x |

---

## Requisitos previos

Antes de instalar el proyecto, asegúrate de tener:

- **PHP** >= 8.2 con extensiones: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`
- **Composer** >= 2.x
- **Node.js** >= 18.x y **npm**
- **MySQL** 8.x corriendo en el puerto configurado (por defecto `3307` en este proyecto)
- **Puppeteer** instalado vía npm (necesario para generación de certificados PDF)

---

## Instalación y configuración

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd proyecto
```

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Instalar dependencias Node.js

```bash
npm install
```

> Esto también instala **Puppeteer**, que descarga Chromium automáticamente (~150 MB). Es necesario para la generación de certificados en PDF.

### 4. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

Edita el archivo `.env` con tus credenciales de base de datos y correo (ver sección [Variables de entorno](#variables-de-entorno)).

### 5. Crear la base de datos y ejecutar migraciones

```bash
php artisan migrate
```

### 6. Crear el enlace simbólico de storage

```bash
php artisan storage:link
```

> Necesario para que los archivos subidos (imágenes de lecciones, videos propios, PDFs, certificados) sean accesibles desde el navegador.

### 7. Compilar assets

```bash
# Desarrollo (con hot reload)
npm run dev

# Producción
npm run build
```

### 8. Levantar el servidor de desarrollo

```bash
php artisan serve
```

O usando el script combinado que levanta todo a la vez:

```bash
composer run dev
```

La aplicación estará disponible en `http://127.0.0.1:8000`.

---

## Variables de entorno

Configura el archivo `.env` con los siguientes valores clave:

```env
APP_NAME="Comunal Aprende"
APP_ENV=local
APP_KEY=             # Se genera con php artisan key:generate
APP_URL=http://127.0.0.1:8000

# Base de datos MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307          # Puerto personalizado del proyecto
DB_DATABASE=comunal_aprende
DB_USERNAME=root
DB_PASSWORD=

# Correo (SMTP Gmail)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-correo@gmail.com
MAIL_PASSWORD=tu-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu-correo@gmail.com
MAIL_FROM_NAME="Comunal Aprende"

# Sesiones y caché
SESSION_DRIVER=database
CACHE_STORE=database
```

---

## Estructura del proyecto

```
proyecto/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/               # Controladores del panel admin
│   │   │   │   ├── AdminCursosController.php
│   │   │   │   ├── AdminDashboardController.php
│   │   │   │   ├── AdminLeccionesController.php
│   │   │   │   ├── AdminModulosController.php
│   │   │   │   └── AdminQuizController.php
│   │   │   ├── Auth/                # Controladores de autenticación (Breeze)
│   │   │   ├── CertificadoController.php
│   │   │   ├── CursoPlayerController.php
│   │   │   ├── CursosController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── PaginasController.php
│   │   │   ├── ProfileController.php
│   │   │   └── QuizController.php
│   │   └── Middleware/
│   │       └── EsAdmin.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Curso.php
│   │   ├── Modulo.php
│   │   ├── Leccion.php
│   │   ├── ProgresoLeccion.php
│   │   ├── Quiz.php, QuizPregunta.php, QuizOpcion.php
│   │   ├── QuizIntento.php, QuizRespuesta.php
│   │   └── Certificado.php
│   ├── Notifications/
│   │   └── ResetPasswordNotification.php  # Correo de reset en español
│   └── Providers/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── admin/                   # Vistas del panel administrador
│       ├── auth/
│       │   ├── reset-password-email.blade.php  # Plantilla del correo de reset
│       │   └── ...                  # Demás vistas de auth
│       ├── certificados/
│       ├── cursos/
│       ├── layouts/
│       ├── partials/
│       └── quiz/
├── public/
│   ├── images/
│   └── storage -> ../storage/app/public  # Enlace simbólico
├── storage/
│   └── app/public/
│       ├── lecciones/               # PDFs subidos
│       │   ├── imagenes/            # Imágenes insertadas en editor TinyMCE
│       │   └── videos/              # Videos propios subidos por el admin
│       └── certificados/
├── .env.example
├── composer.json
├── package.json
├── tailwind.config.js
└── vite.config.js
```

---

## Módulos principales

### Catálogo de cursos
Los cursos se organizan en **categorías** (Gestión Comunal, Normatividad, Liderazgo, Formulación de Proyectos, Participación Ciudadana, Contabilidad) y se componen de módulos y lecciones.

### Reproductor de curso
Permite navegar entre lecciones y marcar cada una como completada. El sistema calcula el porcentaje de avance automáticamente.

### Tipos de contenido en lecciones

| Tipo | Descripción |
|---|---|
| Texto | Editor TinyMCE con soporte de imágenes, tablas, listas y formato enriquecido |
| Video | URL de YouTube/Vimeo embebido, o archivo de video propio (MP4, MOV, WEBM) subido al servidor |
| PDF | Archivo subido y visualizado en iframe |
| Quiz | Evaluación con preguntas configurables |
| Tarea | Instrucciones en texto enriquecido |

#### Editor de texto con imágenes (TinyMCE)
Al crear o editar una lección de tipo texto, el campo de contenido usa TinyMCE. El admin puede insertar imágenes directamente desde el editor — las imágenes se suben automáticamente al servidor y se almacenan en `storage/app/public/lecciones/imagenes/`. La ruta de subida es `POST /admin/lecciones/upload-imagen`.

#### Videos propios
Al seleccionar tipo Video, el admin puede elegir entre pegar una URL de YouTube/Vimeo o subir un archivo de video directamente. Los videos se guardan en `storage/app/public/lecciones/videos/` y se reproducen con el reproductor nativo HTML5 en el player del estudiante.

### Sistema de quizzes
Configuración por lección con intentos, tiempo límite y puntaje aprobatorio. Tipos de pregunta: opción múltiple, múltiple respuesta, verdadero/falso y texto libre.

### Certificados
Al completar un curso al 100% el usuario puede descargar un certificado en PDF generado con Spatie Browsershot. Cada certificado tiene un código QR con URL pública de verificación.

### Correo de recuperación de contraseña
Completamente en español con diseño personalizado de Comunal Aprende. La notificación personalizada está en `app/Notifications/ResetPasswordNotification.php` y la plantilla del correo en `resources/views/auth/reset-password-email.blade.php`.

### Panel de administración
Accesible desde `/admin` para usuarios con rol `admin`. Gestión completa de cursos, módulos, lecciones (con editor TinyMCE y subida de videos), quizzes y estudiantes.

---

## Roles y permisos

| Rol | Acceso |
|---|---|
| `student` | Catálogo, inscripción, reproductor, quizzes, dashboard personal, certificados |
| `admin` | Todo lo anterior + panel `/admin` completo |

El middleware `EsAdmin` protege todas las rutas del panel de administración.

---

## Base de datos

| Tabla | Descripción |
|---|---|
| `users` | Usuarios con datos personales, ubicación y rol |
| `cursos` | Cursos con categoría, tipo (free/paid), duración e imagen |
| `inscripciones` | Tabla pivote usuario-curso con progreso y estado |
| `modulos` | Módulos agrupadores de lecciones |
| `lecciones` | Contenido individual (texto, video, PDF, quiz). Incluye `video_local` para videos subidos al servidor |
| `progreso_lecciones` | Progreso por usuario y lección |
| `quizzes` | Configuración de evaluación |
| `quiz_preguntas` | Preguntas de cada quiz |
| `quiz_opciones` | Opciones de respuesta |
| `quiz_intentos` | Registro de intentos |
| `quiz_respuestas` | Respuestas por intento |
| `quiz_respuesta_opciones` | Pivote respuesta-opción |
| `certificados` | Certificados con código único |

---

## Comandos útiles

```bash
# Levantar entorno completo
composer run dev

# Crear enlace simbólico de storage (solo primera vez)
php artisan storage:link

# Ejecutar migraciones pendientes
php artisan migrate

# Agregar una nueva columna a una tabla existente
php artisan make:migration add_columna_to_tabla --table=nombre_tabla

# Limpiar cachés
php artisan config:clear
php artisan route:clear
php artisan cache:clear

# Recrear base de datos desde cero
php artisan migrate:fresh

# Ejecutar pruebas
composer run test

# Compilar assets para producción
npm run build
```

---

## Autor

**David Quiroga**
Proyecto de formación — Comunal Aprende · Colombia