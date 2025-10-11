# Sistema de Gestión de Flota y Mantenimiento

Aplicación web construida con Laravel 12 y Jetstream para controlar el ciclo de vida de los equipos de perforación de una operación minera. El sistema centraliza inventario, manuales técnicos, inspecciones, malla de perforaciones y mantenimientos programados, ofreciendo estadísticas en tiempo real sobre el estado operativo de cada activo.

## Características principales
- **Panel operativo** con indicadores de equipos operativos, en mantenimiento y fuera de servicio, además de horas desde la última inspección.
- **Catálogo de equipos** con control de estados, tipos, iconografía e historial de asignaciones.
- **Gestión de manuales** que valida combinaciones de tipo/modelo y evita duplicados mediante hashes de archivo para las cargas de PDF.
- **Inspecciones y malla de perforaciones** con conversión de PDF a imágenes para visualización rápida dentro del navegador.
- **Mantenimientos programados** que permiten iniciar, completar o cancelar intervenciones restaurando el estado operativo cuando corresponde.

## Tecnologías y dependencias clave
- Laravel 12, Jetstream, Livewire, Tailwind CSS
- Sanctum para autenticación y control de sesiones
- Pest para pruebas, Laravel Sail para entorno Dockerizado
- Intervention Image, Spatie PDF to Image e ImageMagick para manejo de archivos multimedia
- SweetAlert2 para notificaciones y tablas interactivas

## Requisitos rápidos
1. PHP 8.2+, Composer y Node.js instalados.
2. Copiar `.env.example` a `.env` y configurar base de datos y almacenamiento.
3. Instalar dependencias con `composer install` y `npm install`.
4. Ejecutar migraciones y seeders con `php artisan migrate --seed`.
5. Compilar assets con `npm run build` o iniciar Vite con `npm run dev`.

## Scripts de soporte
- `php artisan schedule:run` para tareas programadas.
- `php artisan queue:work` si se habilitan colas.
- `php artisan test` o `./vendor/bin/pest` para la batería de pruebas.

## Licencia
Este proyecto se distribuye bajo la licencia MIT.
