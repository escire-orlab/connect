# Título del paquete

## Comenzando 🚀

## Pre-requisitos 📋

### Requisitos del sistema:
- PHP 8.1 o superior
- Composer

### Dependencias

## Instalación 🔧

### Instalar el paquete de Connect y editar CONNECT_KEY
Ejecutar: `composer require escire-orlab/connect` en los proyectos de ORLAB y Proyecto Azul

Después en cada .env se debe definir una clave de conexión con el nombre CONNECT_KEY
Puedes personalizar diferentes partes de la aplicación.

Después en el archivo .env se deben configurar los sitios conectados separados por comas en la propiedad CONNECT_SITES
CONNECT_SITES=sitioa.com,sitiob.test,etc.com
Solo se deben poner los sitios conectados pero no el del host actual.

Opcionalmente tambien puedes personalizar la ruta de redirección CONNECT_REDIRECT_PATH
Ej. `CONNECT_REDIRECT_PATH="dashboard/path"`

### Personalizar los datos que se envía en la solicitud de conexión.
(Opcional) La primera personalización es la manera en la que se envian los datos
```php
\EscireOrlab\Connect\Helpers\ConfigHelper::$customConnectUrl = function ($user) {
    // Tu lógica personalizada aquí
    // Ej. 
    return $user->toJson();
};
```

### Personalizar create connection callback
(Opcional) Igualmente puedes personalizar `EscireOrlab\Connect\Services\CreateCallbackService::$customCreateConnectCallback` el cual personaliza la operación de guardado de un usuario.
Esto debe retornar el modelo `User`.

### Botón de acceso
(Requerido) En los sitios conectados se debe añadir un botón como este: 
```html
<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link 
        :href="route('orlab.connect.create', [
            'redirect_url' => 'http://connect_azul.test',
        ])" 
        :active="request()->routeIs('orlab.connect.create')">
        {{ __('Proyecto Azul') }}
    </x-nav-link>
</div>
```
Es importante que redirect_url, apunte al sitio que se desea conectar. Dicho sitio debe compartir la misma CONNECT_KEY para funcionar, así como tener instalado el parquete de escire-orlab/connect.

Otro requerimiento es que sustituyas el método para cerrar sesión en la aplicación por la ruta de orlab.connect.close con el método post.
Esta ruta se encargará, además de cerrar la sesión del usuario, cerrar las sesiones en los sitios conectados.
Ejemplo:
```html
<form method="POST" action="{{ route('orlab.connect.close') }}">
    @csrf

    <x-dropdown-link :href="route('orlab.connect.close')"
            onclick="event.preventDefault();
                        this.closest('form').submit();">
        {{ __('Log Out') }}
    </x-dropdown-link>
</form>
```

## Ejecutando las pruebas ⚙️

## Construido con 🛠️

Lista de tecnologías y herramientas utilizadas en el proyecto:
- PHP
- Laravel 10
- Composer

## Versionado 📌

El proyecto emplea un sistema de versionadao SemVer que le permite identificar la corrección de errores, la implementación de nuevas características así como actualizaciones mayores. En estos casos le proporcionaremos información detallada para realizar las actualizaciones correspondientes.

## Autores ✒️

Lista de los autores del proyecto.
 - Homero Raul Vargas Cruz

## Licencia 📄

## Notas para el desarrollador

## TODO
 - Crear las relaciones externas desde CoursePackage hacia el exterior: https://prnt.sc/Ioy_2ryn4pii