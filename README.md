# Iglesia El Buen Pastor - Página Web

Aplicación web para una iglesia, desarrollada en **Laravel 13** (arquitectura MVC) con **Tailwind CSS** (vía CDN, sin necesidad de compilar assets).

Permite mostrar los **anuncios de la iglesia** en la página principal, y administrarlos (crear, editar, eliminar, activar/desactivar) desde un panel sencillo en `/admin/anuncios`.

## Estructura MVC

- **Modelo**: `app/Models/Anuncio.php`
- **Vista**: `resources/views/anuncios/*.blade.php`
- **Controlador**: `app/Http/Controllers/AnuncioController.php`
- **Rutas**: `routes/web.php`
- **Migración**: `database/migrations/2024_06_01_000000_create_anuncios_table.php`

## Requisitos

- PHP 8.3 o superior
- Composer
- Extensión `sqlite3` habilitada en PHP (viene por defecto en la mayoría de instalaciones)

## Instalación (pasos para dejarla funcionando)

1. Descomprime el ZIP y entra a la carpeta del proyecto:
   ```bash
   cd iglesia-web
   ```

2. Instala las dependencias de PHP:
   ```bash
   composer install
   ```

3. Copia el archivo de entorno y genera la clave de la aplicación:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. El proyecto ya viene configurado para usar **SQLite** (no necesitas instalar MySQL). Solo asegúrate de que exista el archivo de base de datos:
   ```bash
   touch database/database.sqlite
   ```
   (En Windows, simplemente crea un archivo vacío llamado `database.sqlite` dentro de la carpeta `database/`.)

5. Corre las migraciones y carga los anuncios de ejemplo:
   ```bash
   php artisan migrate --seed
   ```

6. Levanta el servidor:
   ```bash
   php artisan serve
   ```

7. Abre en tu navegador:
   - **Página pública de anuncios:** http://localhost:8000
   - **Panel de administración:** http://localhost:8000/admin/anuncios
   - **Acceso de miembros:** http://localhost:8000/acceder

## Acceso de miembros

El botón **"Acceder"** (arriba a la derecha, o dentro del menú ☰ en móvil) permite a los miembros de la iglesia iniciar sesión.

El seeder crea un usuario de prueba:
- **Correo:** miembro@iglesia.com
- **Contraseña:** miembro123

Para crear más cuentas de miembros, puedes usar Tinker:
```bash
php artisan tinker
>>> App\Models\User::create(['name' => 'Nombre', 'email' => 'correo@ejemplo.com', 'password' => bcrypt('contraseña')]);
```

Por ahora, el panel de miembros (`/panel`) solo muestra un mensaje de bienvenida. El panel de administración (`/admin/anuncios`) sigue sin protección por login, tal como lo pediste — si más adelante quieres que solo los miembros o un administrador puedan entrar ahí, es fácil agregarlo.

## ¿Cómo modificar los anuncios?

Desde `/admin/anuncios` puedes:
- **Crear** un anuncio nuevo (título, contenido, fecha de evento opcional, y si está activo o no).
- **Editar** cualquier anuncio existente.
- **Eliminar** un anuncio.
- Desmarcar la casilla "Mostrar en la página pública" para ocultar un anuncio sin borrarlo.

Todos los anuncios activos aparecen automáticamente en la página principal, ordenados por fecha de evento.

## ¿Quieres usar MySQL en vez de SQLite?

Abre el archivo `.env` y cambia:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=iglesia
DB_USERNAME=root
DB_PASSWORD=
```
Luego crea la base de datos `iglesia` en tu gestor (phpMyAdmin, MySQL Workbench, etc.) y vuelve a correr `php artisan migrate --seed`.

## Notas

- El diseño usa Tailwind CSS por CDN, así que no necesitas correr `npm install` ni configurar Vite para ver el diseño funcionando.
- Si en el futuro quieres agregar autenticación para proteger el panel `/admin`, se puede integrar Laravel Breeze fácilmente.
