# Proyecto Laravel con Google Sheets

Este proyecto es una API para gestionar empleados, con la funcionalidad de exportar datos a un documento de Google Sheets. A continuación, se detallan los pasos para configurar y ejecutar el proyecto.

## Requisitos

-   PHP >= 7.4
-   Composer
-   Credenciales para la API de Google Sheets
-   Tener una sesión iniciada en Google para abrir el documento

## Instrucciones de Instalación

1. **Clonar el repositorio:**

```
git clone https://github.com/tu-usuario/tu-repositorio.git
cd tu-repositorio
```

2. **Instalar dependencias de Composer:**

```
composer install
```

3. **Copiar el archivo de configuración de entorno:**

```
cp .env.example .env
```

4. **Generar la clave de la aplicación:**

```
php artisan key:generate
```

5. **Instalar la librería de Google API Client:**

```
composer require google/apiclient:^2.15.0
```

6. **Configurar las variables de entorno en el archivo .env:**

```
configura base de datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_bd
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
configura la autenticación de Google:
GOOGLE_SERVICE_ACCOUNT_CREDENTIALS=credentials/google.json
```

1. **Ejecutar migraciones y seeders:**

```
php artisan migrate --seed
```

**Ejecución del Proyecto
Para iniciar el servidor, ejecuta:**

```
php artisan serve
```

**Rutas de la API**

**_Obtener todos los empleados_**

```
GET api/employee
```

**_Crear un empleado_**

```
POST api/employee
```

Requiere JSON con los campos: email, name, emp_title, salary, emp_stated, birthday

**_Obtener un empleado específico_**

```
GET api/employee/{employee}
```

**_Actualizar un empleado_**

```
PUT api/employee/{employee}
```

Requiere JSON con los campos: email, name, emp_title, salary, emp_stated, birthday

**_Eliminar un empleado_**

```
DELETE api/employee/{employee}
```

**_Exportar empleados a Google Sheets_**

```
GET api/employee/googlesheet
```

Extrae todos los datos y los sube a Google Sheets, devolviendo el enlace del documento.

**_Leer datos desde Google Sheets_**

```
GET api/googlesheet
```

Lee el documento de Google Sheets y muestra los datos en un JSON.
Nota
Debes tener una sesión de Google abierta en el navegador para poder visualizar el documento generado.
