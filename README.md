# 🎓 Sistema de Asistencia Universitaria

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/PostgreSQL-14+-336791?style=for-the-badge&logo=postgresql&logoColor=white" alt="PostgreSQL">
  <img src="https://img.shields.io/badge/AdminLTE-3.x-3C8DBC?style=for-the-badge" alt="AdminLTE">
</p>

Sistema web desarrollado en Laravel para la gestión integral de asistencia universitaria. Permite a docentes registrar asistencias por sesión, a estudiantes consultar su historial y a administradores generar reportes detallados con gráficos y exportación a PDF.

---

## 📋 Tabla de Contenidos

- [Características Principales](#-características-principales)
- [Tecnologías Utilizadas](#-tecnologías-utilizadas)
- [Módulos del Sistema](#-módulos-del-sistema)
- [Estructura de Base de Datos](#-estructura-de-base-de-datos)
- [Requisitos Previos](#-requisitos-previos)
- [Instalación](#-instalación)
- [Usuarios de Prueba](#-usuarios-de-prueba)
- [Arquitectura del Sistema](#-arquitectura-del-sistema)
- [Capturas de Pantalla](#-capturas-de-pantalla)
- [Licencia](#-licencia)

---

## ✨ Características Principales

- ✅ **Registro de Asistencias**: Control por sesión con estados (presente, ausente, justificado, tardanza)
- 📊 **Dashboard Analítico**: Gráficos interactivos con Chart.js (tendencias, top faltas)
- 📄 **Reportes PDF**: Exportación de reportes generales, por estudiante y por materia
- 👥 **Sistema de Roles**: Administrador, Admin Parámetros, Docente, Coordinador, Estudiante
- 🔐 **Autenticación Segura**: Sistema de login con encriptación BCrypt
- 📱 **Diseño Responsive**: Interfaz adaptable a dispositivos móviles
- 🎨 **UI Moderna**: AdminLTE 3 con Bootstrap 5, DataTables, Select2, SweetAlert2
- 📈 **Estadísticas en Tiempo Real**: Contadores y métricas instantáneas
- 🔍 **Búsqueda Avanzada**: Filtros por materia, semestre, estudiante, fechas
- 💾 **Gestión Completa**: CRUD para estudiantes, docentes, grupos, inscripciones

---

## 🛠️ Tecnologías Utilizadas

### Backend
- **Laravel 12** - Framework PHP
- **PostgreSQL** - Base de datos relacional
- **Eloquent ORM** - Manejo de modelos y relaciones
- **Laravel UI** - Scaffolding de autenticación
- **Filament** - Panel administrativo adicional

### Frontend
- **AdminLTE 3** - Template administrativo
- **Bootstrap 5** - Framework CSS
- **jQuery** - Librería JavaScript
- **DataTables** - Tablas interactivas
- **Select2** - Selects mejorados
- **Chart.js** - Gráficos estadísticos
- **SweetAlert2** - Alertas elegantes
- **Font Awesome** - Iconografía

### Exportación y Reportes
- **DomPDF** - Generación de PDFs (barryvdh/laravel-dompdf)

---

## 📦 Módulos del Sistema

### 1. 👨‍💼 Gestión de Usuarios y Roles
- **Roles disponibles**: Administrador, Admin Parámetros, Docente, Coordinador, Estudiante
- **Permisos granulares**: Control de acceso por rol
- **Gestión de usuarios**: CRUD completo con asignación de roles

### 2. 👨‍🎓 Estudiantes
- **Campos**: nombre, apellidos, CI, teléfono, email, dirección, fecha nacimiento, carrera, turno, matrícula
- **Funcionalidad**: Registro completo, búsqueda, edición, eliminación
- **Vista personal**: Cada estudiante puede ver su historial de asistencias

### 3. 👨‍🏫 Docentes
- **Campos**: nombre, apellidos, CI, celular, email, dirección, profesión, fecha contratación
- **Funcionalidad**: Gestión completa, asignación a grupos
- **Vínculo con usuario**: Cada docente tiene cuenta de acceso

### 4. 📚 Grupos Académicos
- **Campos**: materia, semestre, docente, aula, turno
- **Funcionalidad**: Creación de grupos para registro de asistencias
- **Relaciones**: Materia → Grupo → Inscripciones → Asistencias

### 5. 📝 Inscripciones
- **Funcionalidad**: Matricular estudiantes a grupos específicos
- **Control**: Validaciones para evitar duplicados
- **Filtros**: Por carrera y grupo

### 6. ✅ Registro de Asistencias
- **Estados**: Presente, Ausente, Justificado, Tardanza
- **Por sesión**: Fecha, tema, observaciones individuales
- **Validaciones**: Prevención de duplicados, verificación de inscripciones
- **Modo lectura**: Sesiones existentes son de solo lectura

### 7. 📊 Reportes y Estadísticas
- **Reporte General**: Listado de sesiones con contadores
- **Reporte por Estudiante**: Historial individual con estadísticas
- **Reporte por Materia**: Análisis por grupo y sesiones
- **Exportación PDF**: Todos los reportes exportables
- **Gráficos**: Tendencias diarias, top faltas por materia

### 8. 🔧 Parámetros del Sistema
- **Carreras**: Ingenierías, Administración, Contabilidad, etc.
- **Materias**: Con código y nombre por carrera
- **Semestres**: Gestión por año y periodo
- **Turnos**: Mañana, Tarde, Noche
- **Aulas**: Salones y laboratorios

---

## 🗄️ Estructura de Base de Datos

El sistema utiliza **PostgreSQL** con las siguientes tablas principales:

### Tablas Core
- `users` - Usuarios del sistema
- `user_rol` - Relación usuarios-roles (many-to-many)
- `param_rol` - Catálogo de roles

### Tablas Paramétricas
- `param_carrera` - Carreras universitarias
- `param_materia` - Materias/asignaturas
- `param_semestre` - Semestres académicos
- `param_turno` - Turnos (mañana/tarde/noche)
- `param_aula` - Aulas y salones

### Tablas Operativas
- `estudiantes` - Perfil de estudiantes
- `docentes` - Perfil de docentes
- `grupos` - Grupos académicos (materia-semestre-docente)
- `inscripciones` - Matrícula estudiante-grupo
- `sesiones` - Sesiones de clase (fecha, tema)
- `asistencias` - Registro de asistencia por sesión
- `justificaciones` - Justificaciones de ausencias

### Tablas del Sistema
- `cache` - Cache del sistema
- `jobs` - Cola de trabajos
- `password_reset_tokens` - Tokens de recuperación

---

## 📋 Requisitos Previos

- **PHP** >= 8.2
- **Composer** >= 2.x
- **Node.js** >= 18.x y NPM
- **PostgreSQL** >= 14
- **Git**

---

## 🚀 Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/IsraelLizares/Sistema-Asistencia-Universitaria.git
cd Sistema-Asistencia-Universitaria
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de Node.js

```bash
npm install
```

### 4. Configurar variables de entorno

```bash
cp .env.example .env
```

Editar el archivo `.env` con tus credenciales de base de datos:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=db_asistencia
DB_USERNAME=postgres
DB_PASSWORD=tu_contraseña
```

### 5. Generar clave de aplicación

```bash
php artisan key:generate
```

### 6. Crear la base de datos

```bash
# Acceder a PostgreSQL
psql -U postgres

# Crear la base de datos
CREATE DATABASE db_asistencia;

# Salir
\q
```

### 7. Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

Esto creará todas las tablas y poblará la base de datos con:
- Roles del sistema
- Usuarios de prueba
- Datos paramétricos básicos

### 8. Compilar assets

```bash
npm run build
```

Para desarrollo con hot reload:

```bash
npm run dev
```

### 9. Iniciar el servidor

```bash
php artisan serve
```

La aplicación estará disponible en: **http://localhost:8000**

---

## 👥 Usuarios de Prueba

Después de ejecutar los seeders, tendrás acceso con las siguientes credenciales:

### 🔑 Credenciales de Acceso

| Rol | Email | Contraseña | Permisos |
|-----|-------|------------|----------|
| **Administrador** | `admin@asistencia.edu` | `admin123` | Acceso total al sistema |
| **Admin Parámetros** | `admin.param@asistencia.edu` | `param123` | Gestión de parámetros |
| **Docente** | `docente@asistencia.edu` | `docente123` | Registro de asistencias, grupos |
| **Coordinador** | `coordinador@asistencia.edu` | `coord123` | Gestión estudiantes, inscripciones |
| **Estudiante** | `estudiante@asistencia.edu` | `estudiante123` | Ver historial personal |

> ⚠️ **Importante**: Cambia estas contraseñas en producción por seguridad.

---

## 🏗️ Arquitectura del Sistema

### Patrón MVC (Modelo-Vista-Controlador)

```
app/
├── Http/
│   └── Controllers/
│       ├── AsistenciaController.php    # Registro y consulta de asistencias
│       ├── ReporteController.php       # Generación de reportes y PDFs
│       ├── EstudianteController.php    # CRUD de estudiantes
│       ├── DocenteController.php       # CRUD de docentes
│       ├── GrupoController.php         # CRUD de grupos
│       ├── InscripcionController.php   # Matriculación
│       └── ParamController.php         # Parámetros del sistema
├── Models/
│   ├── User.php                        # Usuario del sistema
│   ├── Estudiante.php                  # Modelo de estudiante
│   ├── Docente.php                     # Modelo de docente
│   ├── Grupo.php                       # Modelo de grupo
│   ├── Sesion.php                      # Modelo de sesión
│   ├── Asistencia.php                  # Modelo de asistencia
│   ├── ParamMateria.php                # Materias
│   ├── ParamSemestre.php               # Semestres
│   └── ParamCarrera.php                # Carreras
└── Middleware/
    ├── AdminMiddleware.php             # Protección rutas admin
    ├── DocenteMiddleware.php           # Protección rutas docente
    ├── CoordinadorMiddleware.php       # Protección rutas coordinador
    └── EstudianteMiddleware.php        # Protección rutas estudiante
```

### Flujo de Registro de Asistencias

1. **Docente** selecciona grupo y fecha
2. Sistema carga estudiantes inscritos en ese grupo
3. Docente marca estados (presente/ausente/justificado/tardanza)
4. Añade observaciones opcionales por estudiante
5. Sistema valida y guarda en transacción (sesión + asistencias)
6. Sesión queda en modo lectura (no editable)

### Generación de Reportes

1. Usuario selecciona tipo de reporte y filtros
2. Controller ejecuta consultas agregadas (COUNT, SUM, GROUP BY)
3. Calcula porcentajes y estadísticas
4. Renderiza vista Blade con datos
5. DomPDF convierte HTML a PDF
6. Se descarga o visualiza en navegador

---

## 📸 Capturas de Pantalla

### Pantalla de Bienvenida
*Diseño moderno con gradientes y animaciones*

### Login y Registro
*Interfaz split-screen con branding institucional*

### Dashboard Principal
*Estadísticas en tiempo real con gráficos interactivos*

### Registro de Asistencias
*Formulario dinámico con validaciones y estados codificados por color*

### Mi Asistencia (Estudiante)
*Vista personal con historial completo y estadísticas*

### Reportes PDF
*Exportación profesional con tablas y totales*

---

## 🔒 Seguridad

- ✅ Contraseñas encriptadas con BCrypt
- ✅ Protección CSRF en todos los formularios
- ✅ Middleware de autenticación y autorización
- ✅ Validación de datos en servidor
- ✅ Prevención de SQL Injection (Eloquent ORM)
- ✅ Sanitización de inputs
- ✅ Control de acceso basado en roles

---

## 🐛 Solución de Problemas Comunes

### Error de conexión a PostgreSQL
```bash
# Verificar que PostgreSQL esté corriendo
sudo systemctl status postgresql

# Reiniciar PostgreSQL
sudo systemctl restart postgresql
```

### Error de permisos en storage
```bash
chmod -R 775 storage bootstrap/cache
```

### Cache de vistas desactualizado
```bash
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```

---

## 📝 Comandos Útiles

```bash
# Ejecutar migraciones
php artisan migrate

# Revertir última migración
php artisan migrate:rollback

# Refrescar base de datos y seeders
php artisan migrate:fresh --seed

# Limpiar todas las cachés
php artisan optimize:clear

# Generar usuario específico
php artisan db:seed --class=RolesSeeder
```

---

## 👨‍💻 Desarrollado por

**Israel Lizares**
- GitHub: [@IsraelLizares](https://github.com/IsraelLizares)
