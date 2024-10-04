# Instrucciones para ejecutar el Proyecto Laravel

## Requisitos previos:

-   Asegúrate de tener **Redis** instalado y en funcionamiento en tu computadora.
-   **Composer** debe estar instalado para gestionar dependencias de PHP.

## Pasos para configurar y ejecutar el proyecto:

### 1. Clonar el repositorio:

```bash
git clone https://github.com/danthor11/prueba.git
cd prueba/api-transferencia
```

### 2. Instalar las dependencias del proyecto con Composer:

```bash
composer install
```

### 3. Crear el archivo `.env`:

```bash
cp .env.example .env
```

### 4. Generar la clave de la aplicación:

```bash
php artisan key:generate
```

### 5. Instalar Redis y el cliente predis:

Redis debe estar instalado y corriendo en tu computadora. Si no lo tienes instalado, puedes usar los siguientes comandos según tu sistema operativo:

-   **Ubuntu**:
    ```bash
    sudo apt install redis-server
    sudo systemctl enable redis-server
    sudo systemctl start redis-server
    ```

Una vez que Redis esté en funcionamiento, instala el paquete `predis/predis` para manejar Redis en Laravel:

```bash
composer require predis/predis
```

### 6. Configurar las variables de entorno:

Abre el archivo `.env` y configura las siguientes variables con los valores correctos para tu entorno de base de datos y conexión de Redis:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<NOMBRE_DE_TU_BASE_DE_DATOS>
DB_USERNAME=<USUARIO_DE_LA_BD>
DB_PASSWORD=<CONTRASEÑA_DE_LA_BD>

QUEUE_CONNECTION=redis
```

### 7. Ejecutar las migraciones y seeding:

Esto creará las tablas necesarias en la base de datos y poblará datos iniciales.

```bash
php artisan migrate --seed
```

### 8. Ejecutar el servidor de Laravel:

Para iniciar el servidor de desarrollo, ejecuta:

```bash
php artisan serve
```

### 9. Ejecutar los workers de colas:

Para procesar las colas usando Redis, inicia los workers en paralelo:

```bash
php artisan queue:work redis
```

## Glosario de Rutas de la API:

-   `GET|HEAD   /api/table1`: Obtener todos los registros de la tabla 1.
-   `POST      /api/table1`: Crear un registro en la tabla 1, recibir JSON con los campos `name`, `email`, `birthday`.
-   `GET|HEAD   /api/table2`: Obtener todos los registros de la tabla 2.
-   `GET|HEAD   /api/transferir-datos`: Obtener todos los registros de la tabla 1 y la tabla 2.
-   `GET|HEAD   /api/transferir-datos/{n}`: Ejecuta la transferencia de datos donde `n` es la cantidad de workers a usar. Debe ser un número entero.
-   `GET|HEAD   /api/transferir-datos/check-queue-status`: Muestra la cantidad de colas pendientes.
