<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Requisitos

- PHP 8.x
- Composer
- MySQL o MariaDB
- Laravel 11
- Node.js y NPM

## Instalación

1. Clonar el repositorio:  
   ```bash
   git clone <URL_DEL_REPOSITORIO>
   cd <nombre_del_proyecto>
2. Instalar dependencias PHP: `composer install`
3. Copiar el archivo de entorno y configurarlo: `.env` Luego editar .env con los datos de conexión a tu base de datos.
4. En caso de fallo generar llave `php artisan key:generate`
5. Ejecutar migraciones y seeders `php artisan migrate --seed`
6. Instalar dependencias de Node.js `npm install`
7. Compilar los assets `npm run dev`
8. Iniciar el servidor local `php artisan serve`

### Uso
- Ir a `http://localhost:8000`
- CRUD disponible en `/vehiculos`

## Autor
Nombre y Apellido: Nestor Navarro Prado
