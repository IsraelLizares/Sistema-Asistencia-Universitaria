<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Sistema de Asistencia Universitaria

Este proyecto es una aplicación web desarrollada en Laravel que permite la gestión de carreras, materias y estudiantes en una universidad. Incluye funcionalidades completas de CRUD (Crear, Leer, Actualizar, Eliminar) para cada módulo.

## Módulos principales

### 1. Carrera
- **Campos:** nombre, descripción, estado.
- **Funcionalidad:** Permite registrar, listar, editar y eliminar carreras universitarias.
- **Ejemplo de carreras:** Ingeniería de Sistemas, Administración de Empresas, Contabilidad, Derecho, Psicología.

### 2. Materia
- **Campos:** nombrea, código, id_carrera (relación), estado.
- **Funcionalidad:** Permite registrar, listar, editar y eliminar materias asociadas a una carrera.
- **Ejemplo de materias:** Programación I, Bases de Datos, Administración General, Contabilidad Básica, Derecho Civil.

### 3. Estudiante
- **Campos:** nombre, ap_paterno, ap_materno, ci, teléfono, email, dirección, fecha_nacimiento, id_carrera (relación), turno, matrícula, estado.
- **Funcionalidad:** Permite registrar, listar, editar y eliminar estudiantes, asignando cada uno a una carrera y turno.
- **Ejemplo de estudiantes:** Juan Perez (Ingeniería de Sistemas), Maria Gomez (Administración de Empresas), etc.

## Características técnicas

- CRUD completo para cada módulo usando controladores, modelos, migraciones y vistas.
- Relación entre Materia y Carrera, y entre Estudiante y Carrera.
- Uso de seeders para poblar la base de datos con datos de ejemplo.
- Interfaz moderna con AdminLTE y Bootstrap.
- Validaciones en backend y frontend.
- Menú lateral con iconos representativos para cada módulo.

## Instalación y uso

1. Clona el repositorio y ejecuta `composer install` y `npm install`.
2. Configura tu base de datos en `.env`.
3. Ejecuta las migraciones y seeders:
   ```
   php artisan migrate --seed
   ```
4. Inicia el servidor:
   ```
   php artisan serve
   ```
5. Accede a la aplicación en tu navegador.
