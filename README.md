# Comunal Aprende

Plataforma web de formación y capacitación para organizaciones de acción comunal en Colombia. Permite a líderes comunitarios acceder a cursos en línea, realizar evaluaciones y obtener certificados de participación verificables.

---

## Tabla de contenido

1. [Descripción general](#descripción-general)
2. [Tecnologías utilizadas](#tecnologías-utilizadas)
3. [Requisitos previos](#requisitos-previos)
4. [Instalación local](#instalación-local)
5. [Variables de entorno](#variables-de-entorno)
6. [Estructura del proyecto](#estructura-del-proyecto)
7. [Módulos principales](#módulos-principales)
8. [Roles y permisos](#roles-y-permisos)
9. [Base de datos](#base-de-datos)
10. [Despliegue en Railway](#despliegue-en-railway)
11. [Comandos útiles](#comandos-útiles)
12. [Autor](#autor)

---

## Descripción general

**Comunal Aprende** es una aplicación web desarrollada con Laravel 12 orientada a la capacitación de integrantes de organismos de acción comunal (OAC) en Colombia. La plataforma ofrece:

- Catálogo de cursos organizados por módulos y lecciones con diseño responsive
- Reproductor de contenido (texto enriquecido con imágenes vía TinyMCE, video de YouTube/Vimeo o video propio, PDF)
- Sistema de evaluaciones (quizzes) con múltiples tipos de pregunta
- Seguimiento de progreso por lección con orden secuencial obligatorio y tiempo mínimo de lectura
- Generación y descarga de certificados en PDF con código QR de verificación pública
- Panel de administración completo para gestión de contenido
- Autenticación con registro, login y recuperación de contraseña en español (Laravel Breeze)
- Almacenamiento de imágenes, videos y archivos en Cloudinary
- Despliegue en Railway con base de datos MySQL

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
| Almacenamiento de archivos | Cloudinary | cloudinary-laravel 2.x |
| Autenticación | Laravel Breeze | 2.x |
| Testing | PestPHP | 3.x |
| Despliegue | Railway | — |

---

## Requisitos previos

- **PHP** >= 8.2 con extensiones: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `gd`, `curl`, `zip`
- **Composer** >= 2.x
- **Node.js** >= 18.x y **npm**
- **MySQL** 8.x
- **Cuenta en Cloudinary** (plan gratuito suficiente para desarrollo)

---

## Instalación local

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

> Esto también instala **Puppeteer** (~150 MB de Chromium) para generación de certificados PDF.

### 4. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

Edita `.env` con tus credenciales (ver sección [Variables de entorno](#variables-de-entorno)).

### 5. Migraciones y enlace de storage

```bash
php artisan migrate
php artisan storage:link
```

### 6. Compilar assets

```bash
npm run dev      # desarrollo con hot reload
npm run build    # producción
```

### 7. Levantar el servidor

```bash
php artisan serve
# o todo junto:
composer run dev
```

### 8. Crear el primer administrador

```bash
php artisan crear:admin
```

---

## Variables de entorno

```env
APP_NAME="Comunal Aprende"
APP_ENV=local
APP_KEY=             # php artisan key:generate
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

# Base de datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=comunal_aprende
DB_USERNAME=root
DB_PASSWORD=

# Cloudinary
CLOUDINARY_CLOUD_NAME=
CLOUDINARY_API_KEY=
CLOUDINARY_API_SECRET=

# Correo SMTP
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="Comunal Aprende"

# Sesiones y caché
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local
```

---

## Estructura del proyecto

```
proyecto/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/                   # CRUD de contenido (cursos, módulos, lecciones, quiz)
│   │   ├── Auth/                    # Autenticación Breeze
│   │   ├── CertificadoController.php
│   │   ├── CursoPlayerController.php
│   │   ├── CursosController.php
│   │   ├── DashboardController.php
│   │   ├── PaginasController.php
│   │   └── QuizController.php
│   ├── Http/Middleware/
│   │   └── EsAdmin.php
│   ├── Models/                      # Eloquent ORM
│   ├── Notifications/
│   │   └── ResetPasswordNotification.php  # Reset password en español
│   └── Services/
│       └── CloudinaryService.php    # Subida/eliminación de archivos
├── bootstrap/
│   └── app.php                      # trustProxies para Railway HTTPS
├── config/
│   └── cloudinary.php
├── database/migrations/
├── resources/views/
│   ├── admin/
│   ├── auth/
│   │   └── reset-password-email.blade.php
│   ├── certificados/
│   ├── cursos/
│   ├── layouts/
│   ├── partials/
│   │   └── header.blade.php         # Navbar responsive con panel móvil deslizable
│   └── quiz/
├── .env.example
├── railway.toml                     # Configuración de despliegue Railway
├── nixpacks.toml                    # Build: PHP 8.3 + Node 20 + Chromium
├── composer.json
└── vite.config.js
```

---

## Módulos principales

### Catálogo de cursos
Cursos con categorías, módulos y lecciones. Diseño responsive en desktop y móvil.

### Tipos de contenido en lecciones

| Tipo | Descripción |
|---|---|
| Texto | Editor TinyMCE con imágenes (guardadas en Cloudinary) |
| Video | URL de YouTube/Vimeo o archivo propio subido (guardado en Cloudinary) |
| PDF | Archivo subido (guardado en Cloudinary) y visualizado en iframe |
| Quiz | Evaluación configurable con múltiples tipos de pregunta |
| Tarea | Instrucciones en texto enriquecido |

### Progreso secuencial
Las lecciones deben completarse **en orden** — no se puede iniciar la lección N+1 sin completar la N. Si un usuario intenta interactuar con una lección bloqueada, aparece un modal informativo. Las lecciones teóricas (texto/tarea) requieren un mínimo de **5 minutos** de tiempo activo antes de poder marcarse como completadas.

### Certificados
Al completar un curso al 100% se genera un certificado PDF con diseño personalizado, código QR y URL pública de verificación. Generado con Spatie Browsershot (Chromium).

### Correo de recuperación
Email completamente en español con diseño de marca, compatible con Gmail (CSS inline, sin gradientes ni flexbox).

### Almacenamiento en Cloudinary
Todos los archivos subidos (imágenes de cursos, avatares, imágenes del editor TinyMCE, videos propios, PDFs) se guardan en Cloudinary. La base de datos solo almacena las URLs.

### Navegación responsive
El header incluye un **panel deslizable desde la derecha** en móvil (hamburger menu) con logo, links de navegación, información del usuario autenticado y botones de acción.

---

## Roles y permisos

| Rol | Acceso |
|---|---|
| `student` | Catálogo, inscripción, reproductor, quizzes, dashboard personal, certificados |
| `admin` | Todo lo anterior + panel `/admin` completo |

---

## Base de datos

| Tabla | Descripción |
|---|---|
| `users` | Usuarios con datos personales, ubicación y rol |
| `cursos` | Cursos con categoría, tipo, duración e imagen (URL Cloudinary) |
| `inscripciones` | Tabla pivote usuario-curso con progreso y estado |
| `modulos` | Agrupadores de lecciones |
| `lecciones` | Contenido con campo `video_local` (public_id Cloudinary para videos propios) |
| `progreso_lecciones` | Progreso y tiempo visto por usuario y lección |
| `quizzes` | Configuración de evaluaciones |
| `quiz_preguntas` | Preguntas por quiz |
| `quiz_opciones` | Opciones de respuesta |
| `quiz_intentos` | Intentos por usuario |
| `quiz_respuestas` | Respuestas por intento |
| `quiz_respuesta_opciones` | Pivote respuesta-opción (múltiple respuesta) |
| `certificados` | Certificados emitidos con código único |

---

## Despliegue en Railway

El proyecto está configurado para desplegarse en [Railway](https://railway.app) con MySQL como base de datos.

### Archivos de configuración

- **`railway.toml`** — healthcheck en `/up`, sin startCommand (lo maneja nixpacks)
- **`nixpacks.toml`** — instala PHP 8.3, Node 20, Chromium y todas las extensiones necesarias

### Variables de entorno en Railway

Además de las variables locales, en producción agregar:

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-app.up.railway.app
ASSET_URL=https://tu-app.up.railway.app
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
PUPPETEER_EXECUTABLE_PATH=/run/current-system/sw/bin/chromium
```

### Crear administrador en producción

Desde la terminal con Railway CLI vinculado al proyecto:

```bash
railway run php artisan crear:admin
```

> Nota: este comando requiere acceso a la base de datos. Usa el host público de MySQL (disponible en la variable `MYSQL_PUBLIC_URL` del servicio MySQL en Railway), no el host interno.

---

## Comandos útiles

```bash
# Levantar entorno completo (servidor + queue + logs + vite)
composer run dev

# Crear enlace simbólico de storage (primera vez)
php artisan storage:link

# Migraciones
php artisan migrate
php artisan migrate:fresh    # recrear desde cero

# Agregar columna a tabla existente
php artisan make:migration add_columna_to_tabla --table=nombre_tabla

# Crear administrador
php artisan crear:admin

# Limpiar cachés
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Compilar assets
npm run build

# Pruebas
composer run test
```

---

## Autor

**David Quiroga**
Proyecto de formación — Comunal Aprende · Colombia