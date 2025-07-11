# Proyecto de Citas Médicas
## C00A: Instalación
Los pasos de la instalación para la creación del proyecto son:

```ts
❯ laravel new citas_medicas

   _                               _
  | |                             | |
  | |     __ _ _ __ __ ___   _____| |
  | |    / _` | '__/ _` \ \ / / _ \ |
  | |___| (_| | | | (_| |\ V /  __/ |
  |______\__,_|_|  \__,_| \_/ \___|_|


 ┌ Would you like to install a starter kit? ────────────────────┐
 │ No starter kit                                               │
 └──────────────────────────────────────────────────────────────┘

 ┌ Which testing framework do you prefer? ──────────────────────┐
 │ Pest                                                         │
 └──────────────────────────────────────────────────────────────┘

 > @php -r "file_exists('.env') || copy('.env.example', '.env');"

   INFO  Application key set successfully.

 ┌ Which database will your application use? ───────────────────┐
 │ SQLite                                                       │
 └──────────────────────────────────────────────────────────────┘

 ┌ Would you like to run the default database migrations? ──────┐
 │ Yes                                                          │
 └──────────────────────────────────────────────────────────────┘

   INFO  Application ready in [citas_medicas]. You can start your local development using:

➜ cd citas_medicas
➜ npm install && npm run build
➜ composer run dev
 ```


En este fihcero estarán los comentarios "extensos" del proyecto. En donde se explicarán partes del código com más detalle
## C00B: Jetstream
*comentario no vinculado con ningun fichero*
Es un paquete de Laravel que proporciona un scaffolding (andamiaje) para aplicaciones web modernas. Es un paquete desarrollado por el equipo de Laravel y está diseñado para simplificar la configuración inicial de proyectos, especialmente aquellos que requiren autenticación y gestión de usuarios.
Además su instalación puede venir con Livewire(con Alpine) o con Inertia (con Vue/React)
- Livewire (con Alpine.js) → Enfoque más tradicional con PHP.
- Inertia.js con Vue/React → Para una experiencia más SPA (Single Page Application).

Para instalarlo:
```bash
composer create-project laravel/laravel example-app
cd example-app
composer require laravel/jetstream
```
En el caso del proyecto se estará utilizando Jetstream v5

Luego de su instalación será importante elegir si se trabajará con Livewire o con Inertia, en el caso del proyecto será con Livewire: `php artisan jetstream:install livewire`
## C01: Livewire
*comentario no vinculado con ningun fichero*
Livewire es un micro-framework **full-stack para Laravel**, permite crear interfaces dinámicas y reactivas **sin necesidad de escribir JavaScript puro** (aunque se puede combinar con Alpine.js para más interactividad). Permite trabajar con componentes dinámicos usando **PHP en el backend** y actualizaciones en tiempo real en el frontend **sin necesidad de una API REST**
- Desarrollar aplicaciones dinámicas como si fueran tradicionales (PHP + HTML) pero con reactividad similar a Vue/React.
- Evitar escribir JavaScript complejo para acciones comunes (ej: validaciones, filtros, modales, tabs, etc.).
- Integración directa con Laravel: Accede a modelos, validaciones, sesiones, etc., desde el componente PHP.
- Ideal para devs que prefieren PHP pero quieren una experiencia moderna (SPA-like).
## C02: MySQL
*comentario no vinculado con ningun fichero*
En el desarrollo del proyecto se está utilizando WSL 🐧, por lo que se deberá instalar MySQL para seguir con el proyecto.
```bash
sudo apt install mysql-server -y       # Instalar MySQL
sudo service mysql start               # Iniciar el servicio
```
Luego de su intalación faltaría ejecutar un "script de seguridad" (establece constraseña root y elimina configuraciones inseguras): `sudo mysql_secure_installation`

Luego del script de seguridad, falta acceser a MySQL: `sudo mysql -u root -p`, **importante**: la parte de `root`, aquí sería el usuario el cual se utiliza para la BD, pues en este caso, y más adalente en este comentario se crea el usuario `citas_user`, el cual se debería poner aquí, es decir:

```bash
❯ mysql -u citas_user -p <------- aquí el usuario 
Enter password:
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 11
Server version: 8.0.42-0ubuntu0.22.04.1 (Ubuntu)

Copyright (c) 2000, 2025, Oracle and/or its affiliates.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.


mysql> SELECT CURRENT_USER(); <--- Verificar si está el usuario correcto
+----------------------+
| CURRENT_USER()       |
+----------------------+
| citas_user@localhost |
+----------------------+
1 row in set (0.00 sec)

```


Ahora dentro de MySQL para la creación de la BD:
`CREATE DATABASE citas_medicas;`. Con esta línea estará creada la BD:
```bash
mysql> SHOW DATABASES;
+--------------------+
| Database           |
+--------------------+
| citas_medicas      |
| information_schema |
| mysql              |
| performance_schema |
| sys                |
+--------------------+
5 rows in set (0.00 sec)
```

Luego se deberá crear un usuario dedicado
`CREATE USER 'citas_user'@'localhost' IDENTIFIED BY 'unaContraseñaBuena';`

Luego faltaría asignarle los privelegios necesarios:
```bash
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX, DROP 
ON citas_medicas.* TO 'citas_user'@'localhost';
```
Este script hace que el usuario "citas_user" solo tenga acceso a la BD `citas_medicas`.

Se espera un resultado como este:
```bash 
mysql> CREATE USER 'citas_user'@'localhost' IDENTIFIED BY 'unaContraseñaBuena';
Query OK, 0 rows affected (0.02 sec)

mysql> GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX, DROP ON citas_medicas.* TO 'citas_user'@'localhost';
Query OK, 0 rows affected (0.01 sec)
```

**algunos comandos importantes para guiarse:**
```bash
-- Muestra todos los usuarios registrados
SELECT User, Host FROM mysql.user;

-- Muestra el usuario actual de la sesión
SELECT CURRENT_USER();

-- Muestra el usuario utilizado para conectarse
SELECT USER();
```

Luego para finalizar faltaría hacer uso del usuario creado, esto se deberá especificar en el fichero `.env`
```bash
DB_DATABASE=citas_medicas
DB_USERNAME=citas_user
DB_PASSWORD=UnaContraseñaFuerte123!
```

Ahora para segurarse de que todo está bien, se correrán las migraciones:
```bash
php artisan migrate
INFO  Preparing database.

Creating migration table .. 44.03ms DONE

INFO  Running migrations.

  0001_01_01_000000_create_users_table . 191.27ms DONE
  0001_01_01_000001_create_cache_table .. 67.68ms DONE
  0001_01_01_000002_create_jobs_table .. 166.03ms DONE
  2025_06_30_155412_add_two_factor_columns_to_users_table .. 213.09ms DONE
  2025_06_30_155434_create_personal_access_tokens_table ... 85.11ms DONE
```

Una de las formas además de utilizar **Tinker** para la gestión de la BD, y es el caso que se utilzará en el desarrollo del proyecto es la extención de vscode [MySQL Database Client](https://database-client.com/)
### Permiso de Llaves foráneas
En la instalación de Laravel Permission apareció este error:
```bash
SQLSTATE[42000]: Syntax error or access violation: 1142 REFERENCES command denied to user 'citas_user'@'localhost' for table 'citas_medicas.permissions'
```
El usuario `citas_user` no tiene los permisos suficientes para crear las clavez foráneas(`FOREIGN KEY`) Y Laravel Permission usa relaciones foráneas en sus migraciones(`model_has_permissions`, `model_has_roles`, etc). 

Para solucionkarlo se deberá dar los permisos necesarios en MySQL, especialmente, `REFERENCES`.:
```SQL
mysql -u root -p /* <-- Conectase a la MySQL como root */

GRANT ALL PRIVILEGES ON citas_medicas.* TO 'citas_user'@'localhost';
FLUSH PRIVILEGES; /* <-- Comando para otorgar todos los privilegios sobre la BD `citas_medicas` al usuario `citas_user` */

EXIT;
```
Luego faltaría correr la migraciones para saber si todo funcionó:
```bash
php artisan migrate:fresh --seed
```
## C03: Laravel Lang (español)
Una caracteristica de Laravel pero opcional, es traducir la app, para eso está [Laravel Lang](https://laravel-lang.com/basic-usage.html).
**Laravel Lang** es una colección de paquetes de traducción que amplían el soporte de idiomas en Laravel.
Por defecto Laravel incluye algunso ficheros de idioma básicos en ingles(como validación, auth, paginación, etc) Laravel Lang es un proyecto de la comunidad que:
- Proporciona archivos de traducción completos en múltiples idiomas.
- Traduce automáticamente los mensajes comunes: validaciones, errores de autenticación, paginación, contraseñas, etc.
-  Facilita que una app sea multilingüe sin tener que traducir todo manualmente.
### Instalación
Para instalar Lang bastará con el comando `composer require laravel-lang/common` dentro del proyecto. Luego bastará con `php artisan lang:add es` para tener las traducciones en español.
Ahora dentro de `lang/es` estará la configuración general del idioma
### Uso de las traducciones
Ahora falta configurar Laravel para que utilice las traducciones descargadas.
Dentro del fichero `config/app.php` estará esto:
```bash
'locale' => env('APP_LOCALE', 'en'),
'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),
```
Aquí el idioma (`locale`) se establece que la sace de la variable de entorno (`.env`). entonces dentro de `.env` se deberá cambiar:
```bash
APP_LOCALE=es
```
Solo agregando "es" los cambios efectuarán en nuestra app.
## C04: Imagen de Usuario
Con Jetstream al darnos cosas ya creadas, podemos tuilizar imagenes de perfil para los usuarios del sistema. Primero en el fichero `config/jetstream.php` estará lo siguiente:
```bash
  'features' => [
        // Features::termsAndPrivacyPolicy(),
        // Features::profilePhotos(),
        // Features::api(),
        // Features::teams(['invitations' => true]),
        Features::accountDeletion(),
    ],
```
Como se puede apreciar hay varias opciones comentadas, las cuales no están por defecto, entonces hay que descomentar: `Features::profilePhotos(),`. Con ese cambio por defecto se actualizará nuestro usuario logeado en Jetstream y se mostrará una foto de perfil adaptado a su nombre de usuario, pero se pueden añadir imagenes personalizadas.
Para que se pueda subir una imagen a un perfil faltarían un par de cosas.
Si se está utilizando un Virtual Host en `.env` la variable `APP_URL` deberá estar con el URL de dicho virtual host.
Y dentro del mismo fichero, la variable `FILESYSTEM_DISK` debería estar en `public`
## C05: Zona Horaria
Para que los registros en la BD y otras configuraciones estén establecidas en el horario local, dentro del fichero `config/app.php`, en `timezone` se establecerá la zona horaria.
## C06: Ruta Admin
Para crear una ruta de forma separada se deberá crear el fichero `routes/admin.php`. Separar la rutas es útil para:
- Se mantienen las rutas ordenadas por responsabilidad (admin, frontend, API, etc.).
- En proyectos grandes, es más limpio que tener todo en web.php.
- Se puede aplicar middlewares específicos a cada grupo de rutas.

Entonces, siguiendo con `routes/admin.php`, dentro del fichero se deberán crear las rutas orientadas al "admin", y su utilidad es la misma que `routes/web.php`, solo que está en otro fichero para mantener un mejor orden.
Tambien dentro de `bootstrap/app.php` se deberá añadir por ejemplo:
```php
 then: function (){
            Route::middleware('web')
                ->group(base_path('routes/admin.php'));
        }
```
Estás líneas le indican a Laravel que después de configurar las rutas principales (web.php, api.php, etc), también debe cargar el archivo `routes/admin.php`, y que todas las rutas dentro de ese archivo usen el middleware `web`.

De esta forma se podrá acceder la nueva ruta admin así: `http://127.0.0.1:8000/admin`.

` ->name('admin.')`: 
El método `->name()` en Laravel se utiliza para **asignar un prefijo de nombre a un grupo de rutas**. En este caso, `'admin.'` se aplicará como prefijo a todas las rutas definidas dentro del archivo `routes/admin.php`.

Esto permite que las rutas puedan ser referenciadas por un nombre completo en el código, facilitando su uso en redirecciones o generación de URLs.
Por ejemplo, si dentro del grupo defines una ruta con `->name('dashboard')`, su nombre completo será `admin.dashboard`, y podrás acceder a ella mediante `route('admin.dashboard'`.
## C07: Qué es un middleware?
Un middleware es una **capa intermedia** que se ejecuta antes o después de una solicitud HTTP. Sirve para filtrar, modificar o validar una petición.
Algunso Middleware del Laravel:
| Middleware       | ¿Qué hace?                                                          |
| ---------------- | ------------------------------------------------------------------- |
| `web`            | Habilita sesiones, cookies, protección CSRF, etc. (para rutas web). |
| `auth`           | Solo permite acceso si el usuario está autenticado.                 |
| `verified`       | Solo permite acceso si el email del usuario está verificado.        |
| `throttle`       | Limita la cantidad de peticiones por tiempo.                        |
| `admin` (custom) | Puedes crear uno para permitir solo a administradores.              |
## C08: Redirección a Raíz
Cuando se inicia sesión de Jetstream con email y contraseña, por defecto Jetstream redirecciona al Dashboard de Jetstream, es decir, luego de un logeo manda directo a `http://127.0.0.1:8000/dashboard`. Para cambiar esto se deberá hacer en `config/fortify.php`
>El archivo config/fortify.php pertenece a Laravel Fortify, que es el backend de autenticación utilizado por Laravel Breeze, Jetstream y otros stacks de Laravel. Entonces este fortify es el paquete que se encarga del proceso de autenticación.
Dentro de `config/fortify.php` en la parte:
```bash
'home' => '/dashboard',
```
Cambiarémos "dashboard" solo por la raíz: `'home' => '/',`

Con esto luego cuando se está en `http://127.0.0.1:8000/login` y se completan las credenciales ya no redireccionará al dashboard de Jetstream, sino que lo hará en la raíz: `http://127.0.0.1:8000/`.
## C09: Componente con clase
Siguiendo con los pasos del desarrollo, ahora toca la creación de un Componente con Clase, para eso en la terminal se deberá ejecutar:
```bash 
php artisan make:component AdminLayout
INFO  Component [app/View/Components/AdminLayout.php] created successfully.
INFO  View [resources/views/components/admin-layout.blade.php] created successfully. 
```
Pero antes de seguir es importante saber lo siguiente:
### 1. Componente de Línea 
Un **componente de línea** es aquel que se define directamente en un solo archivo Blade, sin lógica PHP adicional en una clase. Ejemplo
```bash
php artisan make:component Button --inline
```
Esta comando creará:
```bash
resources/views/components/button.blade.php
```
y el fichero podría tener solo esto:
```php
<button {{ $attributes->merge(['class' => 'bg-blue-500 text-white px-4 py-2 rounded']) }}>
    {{ $slot }}
</button>
```
Entonces un componente inline se basa en:
- Solo tiene una vista Blade (.blade.php).
- No hay una clase PHP asociada.
- Útil para componentes simples y reutilizables de interfaz (botones, etiquetas, badges).
### 2. Componente de Clase
Un componente de clase tiene 2 partes:
- Una clase PHP, que maneja la lógica
- Una vista Blase, que muestra contenido.
Un ejemplo sería:
```bash
php artisan make:component Alert
```
Y este comando crearía 2 ficheros:
```bash
app/View/Components/Alert.php          ← la lógica
resources/views/components/alert.blade.php  ← la vista
```

Y el contenido de `Alert.php` cómo se dijo, mantiene la lógica, ejemplo:
```php
class Alert extends Component
{
    public $type;

    public function __construct($type = 'info')
    {
        $this->type = $type;
    }

    public function render()
    {
        return view('components.alert');
    }
}
```
Y `alert.blade.php` sería la vista que está conectada a la lógica el fichero previo:
```php
<div class="alert alert-{{ $type }}">
    {{ $slot }}
</div>
```

Entonces, cuándo utilizar uno u otro:
| Necesidad                      | Tipo recomendado    |
| ------------------------------ | ------------------- |
| Solo HTML reusable             | Componente de línea |
| Necesitas pasar datos / lógica | Componente de clase |
## C10: Estrucura de las view/routes/controller/layouts/etc
Sin seguir con ejemplos simulados, sino con ejemplos reales ahora toca definir la estrucura de las views de admin. En el comentario **C09** se menciona que se creó 2 ficheros con `make:component`, esos ficheros son
- `View/Components/AdminLayout.php`
- `views/components/admin-layout.blade.php`
Ahora como se está buscando crear un `layout` el fichero `components/admin-layout.blade.php` no será un componente común, será un `layout`, por lo que se moverá y renombrará a `resources/views/layouts/admin.blade.php`, ya que su funcion será un `layout` tiene más sentido que esté dentro de dicha carpeta y que solo se llame `admin.blade.php`, evitando redundancia.

Dentro de `resources/views/layouts/admin.blade.php` estará la estructura principal de las vistas de **admin**, y con la estrucura de componente se reutilizará el código repetitivo. 

Para mantener un mayor orden aun, se creó 2 ficheros:
- `resources/views/layouts/includes/app/navigation.blade.php`
- `resources/views/layouts/includes/app/sidebar.blade.php`
Ambos ficheros separados para un mejor orden del código, estos ficheros ahora deberán estar incluidos dentro de `layouts/admin.blade.php`, para eso en Laravel están las [Blade Templates](https://documentacionlaravel.com/docs/11.x/blade). Como ya se mencionó **Blade** es el motor de plantillas que se incluye con Laravel. 

En este punto, dentro del fichero `resources/views/layouts/admin.blade.php`, se hace uso de la directiva `@include` de Blade **para incluir otras plantillas parciales** que contienen secciones reutilizables del layout, en este caso:
```php
@include('layouts.includes.app.navigation')
@include('layouts.includes.app.sidebar')
``` 
Estas instrucciones indican que, al renderizar la vista, Laravel insertará el contenido de los archivos `navigation.blade.php` y `sidebar.blade.php` dentro del Layout principal. Esto permite **mantener el código limpio y organizado**, separando las distintas partesl del diseño en archivos individuales.
Por ejemplo, si en el futuro se desea modificar la barra lateral, solo se debe editar el archivo `sidebar.blade.php` sin necesidad de tocar el layout completo. 
Además, el uso de `includes` facilita la reutilización del mismo layout para múltiples vistas de administración, centralizando los elementos comunes como encabezados, navegación y scripts globales.
## C11: Estrucura general del panel de adminstración
Se ha creado una estrucura **modular y limpia** para el panel de administración.
📁`resources/views/admin/dashboard.blade.php`:
Este fichero **usa el componente de layout** `<x-admin-layout>`, el cual está conectado internamente a:
📁`resources/views/layouts/admin.blade.php`:
Aquí es donde entra el contenido que está dentro de `<x-admin-layout>`, el contenido ahora se mostraría por el `{{ $slot }}`. Laravel, por detras transforma el componente `x-admin-layout` en una clase (`App\View\Components\AdminLayout`) que renderiza la vista `layouts.admin`, y ahí inyecta el contendido de `slot`
📄 `routes/admin.php`:
```php
Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');
```
El archivo `routes/admin.php` define las rutas exclusivas del panel admin. Gracias a la configuración del `bootstrap/app.php`, no es necesario anteponer `/admin` ni `admin.` en cada ruta manualmente, ya que se definen de forma global con:
```php
->prefix('admin')
->name('admin.')
```
Esta ruta(`routes/admin.php`) define que cuando un usuario accede a `/admin`, Laravel responderá con la vista `admin.dashboard`, es decir
- Usa `<x-admin-layout>` como estrucura
- Y el contenido se inyecta dentro del `{{ $slot }}` del layout `layouts.admin`.
## C12: Flowbite
Para **reducir el tiempo de desarrollo**, se optó por la utilización de [Flowbite](https://flowbite.com/), la cual porpociona una gran librería de componentes en Tailwind. 
Si por ejemplo en el pantel y vista `resources/views/layouts/includes/app/sidebar.blade.php` posee un `nav-bar` interactivo y responsivo en la página de **Flowbite** y no funciona las animaciones en el proyecto, es porque falta integrar Flowbite especialmente a [Laravel](https://flowbite.com/docs/getting-started/laravel/) *<-- Documentación de Flowbite sobre la integración con Laravel*

Dentro de la documentación, en la sección [Install Flowbite](https://flowbite.com/docs/getting-started/laravel/#install-flowbite). Indica se deberá instalar la dependencia de Flowbite usando NPM en el proyecto.
`npm install flowbite --save`

Luego de la instalación ir al fichero main de css `resources/css/app.css` e importar lo siguiente:
```css
@import "flowbite/src/themes/default";
@plugin "flowbite/plugin";
@source "../../node_modules/flowbite";
```
Luego de la importación se deberá correr en la terminal `npm run build`, para que se incorporen los cambios realizados

Finalmente, faltaría agregar el script de Flowbite en la plantilla de admin en este caso:
` <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>`, quedaría:
```php
 @stack('modals')

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
```
Con eso ya funcionaría los los efectos de las plantillas de Flowbite
## C13: Componentes ya creados
Jetstream viene con distintos componentes ya creados, los cuales se le puede dar un uso propio (por ejemplo los ficheros `resources/views/components/button.blade.php`, `resources/views/components/dropdown.blade.php`, `resources/views/components/nav-link.blade.php`, etc) **son componentes Blade predefinidos por Jetstream**

Laravel Jetstream incluye una colección de componentes Blade reutilizables ubicados usualmente en `resources/views/components/`.
Estos componentes forman parte de la interfaz visual del sistema de autenticación y funcionalidades incluidas en Jetstream, como:
- Formularios (login, registro, actualización de perfil, etc.)
- Modalidades (confirmación, eliminación, etc.)
- Navegación y menús (dropdown, nav-link)
- Feedback visual (action-message, input-error, etc.)

Jetstream también utiliza **Livewire**(en este caso) y  y estos componentes ayudan a componer interfaces dinámicas rápidamente, manteniendo el código limpio y desacoplado.
## C14: Reutilización de la plantilla admin para el perfil de usuario de Jetstream
Por defecto, en el archivo `resources/views/profile/show.blade.php`, se utiliza el componente `<x-app-layout>`, que corresponde al layout base proporcionado por Jetstream. Este layout incluye la estructura general del frontend para las páginas del usuario autenticado.

Sin embargo, se puede integrar el perfil de usuario dentro de tu panel de administración personalizado, reemplazando `<x-app-layout>` por `<x-admin-layout>`.

Esto hará que la plantilla `admin` se cargue, incluyendo elementos como el **sidebar** y la **navbar** que se definió en layouts.admin. El contenido del perfil de usuario se mostrará dentro del `{{ $slot }}` del layout, permitiendo así reutilizar toda la estructura de administración sin perder la funcionalidad del panel de perfil.
## C15: Composición dinámica de vistas mediante datos estructurados
Dentro del fichero `resources/views/layouts/includes/app/sidebar.blade.php`, se hace una reutilización de código con un array de configuración, esto se llama: **composición dinámica de vistas mediante datos estructurados**, es una práctica común y recomendada.
Para seguir el ejmplo del fichero lo que pasa es lo siguiente:

**1. Definición de array `$links`**
Este array tiene toda la infromación que necesita el sidebar:
 - Enlaces normales(`name`, `icon`, `href`, `active`)
- Encabezados de sección (`header`)
- Submenús(`submenu` con más enlaces dentro)
Esto permite cambiar el contenido del sidebar sin tocar HTML directamente. Solo se editará el array.

**2. Uso de un `@foreach`**
Recorrer ese array y se decide qué tipo de ítem se motrará:
- Si tiene `header` -> muestra un título
- Si tiene `submenu` -> se genera un dropdown
- Si no tiene niguno de esos -> es un enlace normal
```php
@isset($link['header'])   // título
@isset($link['submenu'])  // dropdown
else                      // link simple
```

**3. Resuable, limpio y desacoplado**
- Se puede añadir, quitar o cambiar secciones sin duplicar HTML
- Separa los **datos de la vista**, lo cual es muy mantenible
- Se puede mover este `$links` a un fichero PHP o incluso a BD si se quiere escalar

Entonces si hace un Renderizado condicional basado en configuración, se hace una Generación dinámica de interfaces y se tiene un Menú dinámico con estructura de datos. en otras palabras, se usa un array como fuente de vedad para generar dinámicacmente el contenido HTML del menú.
## C16: @Props
`@props()` sirve para definir **valores que recibirá un componente Blade**. Son como los "atributos" que se puede pasarle al componente, y se comportan como variables internas.
Relacionado a los ficheros vinculados a `@props` está el componente `admin.blade.php`:
```php
@props([
    'title' => config('app.name', 'Laravel'),
    'breadcrumbs' => [],
])
```
Aquí lo que pasa es lo siguiente:
- Se puede pasar un `title`, y si no se hace, será el nombre de la app por defecto(el nombre de la app por defecto está en `.env`: `APP_NAME="Citas Médicas"`)
- Se puede pasar un array llamado `breadcrumbs`, que si no se hace será un array vacío.

Otro fichero vinculado es `dashboard.blade.php`:
```php
<x-admin-layout
    title="Dashboard | Citas médicas"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Prueba',
        ],
    ]"
>
    HOLA DESDE EL ADMIN
</x-admin-layout>
```
**Estos envía esos valores como props al layout:**
- `"Dashboard | Citas médicas"` llega a la variable `$title`.
- El array de rutas llega a `$breadcrumbs`
## C17: Migas de pan (breadcrumb)
En el fichero `admin.blade.php`, está incluyendo la vista:
```php
@include('layouts.includes.admin.breadcrumb')
```
Como ya se definió `$breadcrumbs` con `@rops`, **esa variable estará disponible dentro del include.**
Y en el fichero `breadcrumb.blade.php` está lo siguiente:
```php
@if (count($breadcrumbs)) // Solo si hay elementos

    <ol>
        @foreach ($breadcrumbs as $item)
            <li>
                @isset($item['href'])
                    <a href="{{ $item['href'] }}">{{ $item['name'] }}</a>
                @else
                    {{ $item['name'] }}
                @endisset
            </li>
        @endforeach
    </ol>

    @if (count($breadcrumbs) > 1)
        <h6>{{ end($breadcrumbs)['name'] }}</h6>
    @endif

@endif
```
Esto musetra el listado de rutas, como:
```bash
Dashboard / Prueba
```
Y luego el título principal es el último elemento ('prueba')
## C18: WireUI
Para lograr una mayor personalización y ahorrar tiempo al crear clases, estilos y componentes, se ha añadido al proyecto WireUI.
Según el sitio oficial, WireUI es:
>Un potente conjunto de herramientas diseñado para revolucionar tu flujo de trabajo de desarrollo. Nuestra biblioteca de componentes ofrece un completo conjunto de utilidades para mejorar tu productividad y ofrecer resultados excepcionales.

**🛠️ Instalación**
Para comenzar, se deben ejecutar los siguientes comandos:
```bash
composer require wireui/wireui
php artisan vendor:publish --tag="wireui.lang"
php artisan vendor:publish --tag="wireui.config"
```
Los dos últimos comandos:
- wireui.lang: publica los archivos de traducción de los componentes.
- wireui.config: publica el archivo de configuración config/wireui.php, el cual es fundamental para personalizar el comportamiento de WireUI.
### ⚠️ Conflicto con Jetstream + Flowbite**
Al instalar WireUI, puede surgir un conflicto con Jetstream y Flowbite, ya que WireUI registra automáticamente sus propios componentes Blade, sobrescribiendo algunos que Jetstream también utiliza, como: `<x-dropdown>`, `<x-input>`, `<x-button>`, entre otros.
Esto puede provocar que dejen de funcionar los componentes en formularios como el de login.
**✅ Solución: Usar prefijo (alias) para WireUI**
Para evitar el conflicto, debes editar el archivo `config/wireui.php` y agregar un prefijo (alias) para los componentes de WireUI. Por ejemplo: `'component_alias' => 'wireui',`
Esto hará que los componentes de WireUI se usen con el prefijo: `<x-wireui-input />`, `<x-wireui-button />`.
De esta forma, los componentes originales de Jetstream y Flowbite (`<x-input>`, `<x-button>`, etc.) seguirán funcionando correctamente.
### ♻️ Importante: limpiar cachés
Después de realizar el cambio, es fundamental limpiar la caché de Laravel para que los cambios surtan efecto:
```bash
php artisan optimize:clear
```
Este comando borra el caché de configuración, rutas, vistas y otros archivos compilados por Laravel.
## C19: Rappasoft 
**Rappasoft** es una organización/desarrollador que ofrece **paquetes y recursos avanzados para Laravel** especialmente enfocados en **boilerplates** y **starters** para construir aplicaciones administrativas.
### Laravel Livewire Tables 📦
Enlace a la documentación: -> [Documentación Livewire Table](https://rappasoft.com/docs/laravel-livewire-tables/v3/introduction).
Es un paquete que permite construir **tablas interactivas** fácilmente en Laravel con:
- Búsqueda en tiempo real
- Ordenamiento de columnas
- Paginación automática
- Filtros dinámicos
- Acciones por fila (editar, eliminar, etc.)
- Soporte para relaciones Eloquent
Todo esto sin **necesidad de JavaScript personalizado**, gracias a que está basado en Livewire

### Instalación:
```bash
❯ composer require rappasoft/laravel-livewire-tables

php artisan vendor:publish --provider="Rappasoft\LaravelLivewireTables\LaravelLivewireTablesServiceProvider" --tag=livewire-tables-config

❯ php artisan vendor:publish --provider="Rappasoft\LaravelLivewireTables\LaravelLivewireTablesServiceProvider" --tag=livewire-tables-translations
```
El segundo comando lo que hace es publicar la configuración del paquete. en dicha configuración permite personalizar el comportamiento global del paquete, como:
- Estilo de los componentes (Tailwind, Bootstrap, etc.)
- Ubicación de vistas
- Componente de paginación
- Prefijos de columnas
- Vista por defecto de botones, filtros, etc.
El tercer comando publica las traducciones, lo que permite traducir o personalizar los textos que se muestran en la tablas como: 
- "Search"
- "No results"
- "Showing x to y of z results"
- Botones: "Edit", "Delete", etc.

Y para que todo funcione bien, en el fichero `tailwind.config.js`, se deberá agregar en `content` lo siguiente:
```css
'./vendor/rappasoft/laravel-livewire-tables/resources/views/**/*.blade.php'
```

| Comando                              | ¿Qué hace?                                         | ¿Para qué sirve?                   |
| ------------------------------------ | -------------------------------------------------- | ---------------------------------- |
| `--tag=livewire-tables-config`       | Copia el archivo `config/livewire-tables.php`      | Personalizar configuración global  |
| `--tag=livewire-tables-translations` | Copia traducciones a `lang/vendor/livewire-tables` | Personalizar o traducir los textos |
## C20: Laravel Permission
>Importante tener en cuenta lo comentado de `C02` en la sección de "Permiso de llaves foráneas". Ya que va vinculado a este comentario extenso, en caso de tener error al correr las migraciones luego de instalar Laravel Permission
**Laravel Permission es un paquete Laravel que permite agregar roles y permisos** a los usuarios de forma sencilla y robusta. Con el se puede:
- Asiganr roles a usuarios (ej: `admin`, `editor`, `client`, etc)
- Asignar permisos (ej: `ver post`, `editar usuarios`)
- Contraolar el acceso con middleware como: `Route::get('/admin', fn() => 'Solo admins')->middleware('role:admin');`
- Verificar permisso con métodos como: `$user->hasRole('admin');` o `$user->can('editar post');`
### Instalación
Dentro de la [documentación oficial](https://spatie.be/docs/laravel-permission/v6/installation-laravel) estarán los pasos y otra información imporntante.
```php
 composer require spatie/laravel-permission   /* <--- Instalación de paquete */

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" /*  */
```
Luego antes de realizar las migraciones de las nuevas tablas creadas, es importante ejecutar `php artisan optimize:clear`, luego bastará con correr las migraciones: `php artisan migrate` o ` php artisan migrate:fresh`.

Y lo úlitmo sería agregar el trait: ` use HasRoles;` en el modelo de `User`
## C21: Semillas (Role)
Para crear un fichero de semilla para Roles, bastará con el comando: `php artisan make:seeder RoleSeeder`, luego dentro de Role se establecieron los roles necesarios para el sistema de Gestión de Consultas Médicas. Luego dentro de `database/seeders/DatabaseSeeder.php` se deberá llamar con `$this->call()` a la semilla de Role: 
```php
$this->call([
            RoleSeeder::class,
           
        ]);
```
**Importante:**
dentro de la semilla de rol (`database/seeders/RoleSeeder.php`) en la parte del foreach:
```php
foreach ($roles as $role) {
            Role::create([ /* <-- este model de rol */
                'name' => $role
            ]);
        }
``` 
Ese modelo de `Role::` deberá ser sacado de Laravel Permission, es decir que se deberá importar:
```php
use Spatie\Permission\Models\Role;
```
## C22: Ruta para los roles (Route::resource):
Antes de crear las rutas el falta un controller para **Role**, para crearlo bastará en la terminal con el comando: ` php artisan make:controller Admin/RoleController -r`. con el `Admin/` además de crear la ruta, creará el fichero dentro de esa ruta, para mantener un control más organizado.
El `-r` es para que dentro del controlador se creen los métodos tipicos de para un CRUD, es decir:
```php
public function index()    // Listar todos los roles
public function create()   // Mostrar formulario de creación
public function store(Request $request)   // Guardar nuevo rol
public function show($id)  // Mostrar un rol en detalle
public function edit($id)  // Mostrar formulario de edición
public function update(Request $request, $id)  // Actualizar rol
public function destroy($id)  // Eliminar rol
```
Además en `routes/admin.php` se deberá agregar lo siguiente:
```php
Route::resource('roles', RoleController::class);
```
En Laravel con `::resource` hace que se generen todas las rutas clasicas, esto se llama rutas `RESTful`, el cual genera en este caso:
- `GET /roles` → index
- `GET /roles/create` → create
- `POST /roles` → store
- `GET /roles/{id}` → show
- `GET /roles/{id}/edit` → edit
- `PUT/PATCH /roles/{id}` → update
- `DELETE /roles/{id}` → destroy
Un ejemplo de su uso está está en `resources/views/layouts/includes/admin/sidebar.blade.php`, dentro del array de `$links` está:
```js
    'name' => 'Roles y Permisos',
    'icon' => 'fa-solid fa-shield-halved',
    'href' => route('admin.roles.index'),
    'active' => request()->routeIs('admin.roles'),...
```
Pues ahí en `href`, se llama a la ruta `index` que está dentro de el grupo de ruta `admin` con `roles`, pues al usar `Route::resource('roles', RoleController::class);` como se mencionó, esto ya crea las rutas necesarias, en dicho caso hace uso de`GET /roles -> index`, el cual en el controller de Roles(`Controllers/Admin/RoleController.php`) está definido aquí:
```php
public function index()
    {
        return view('admin.roles.index');
    }
```
el cual la view que llama está dentro de la ruta `admin/roles` y el fichero `index`, es decir: `resources/views/admin/roles/index.blade.php`.
## C23: Tabla de roles (Laravel Livewire Table, "Table DSL")
Anteriormente en `C19` se instalaó [Laravel Livewire Tables](https://rappasoft.com/docs/laravel-livewire-tables/v3/introduction). Ahora se hace su uso.
En la terminal se deberá añadir el siguiente comando:
```bash
php artisan make:datatable Admin/Datatables/RoleTable

 ┌ What is the name of the model you want to use in this table? ┐
 │ User                                                         │
 └──────────────────────────────────────────────────────────────┘
```
Luego del primer comando, preguntará el nombre del model en el cual se deberá basar la tabla, de momento se utilizará User, **ya el el model de Role está con LaravelPermission**, luego se cambiará eso.
Entonces generará el fichero: `app/Livewire/Admin/Datatables/RoleTable.php`. Ahora si se deberá cambiar el modelo:
`protected $model = User::class;`, por:`protected $model = Role::class;`, además de añadir el import: `use Spatie\Permission\Models\Role`.

Laravel Livewire Table su uso está inspirado en una idea llamada "**Table DSL**" (Domain Specific Language), donde se definen las columnas y configuración en un array de PHP estrucurado. Esto hace que sea **muy declarativo y legible**. 
*FilamentPHP tambien está basado en DLS*

Entonces con "Laravel Livewire Tables", dentro el fichero `app/Livewire/Admin/Datatables/RoleTable.php` para definir la estrucura de las tablas, será importante trabajar con **métodos encadenables**, es decir: `->sortable(),`, `->searchable(),`, etc.
## C24: Creación de un nuevo registo
Para crear por ejemplo un nuevo **Rol** será importante tener lo siguiente
Dentro del fichero: `resources/views/admin/roles/create.blade.php`, está lo siguiente:
```php
<x-wire-card>
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <x-wire-input
                label="Nombre" name="name" placeholder="Nombre del rol" value="{{ old('name') }}"

                />
                <div class="flex justify-end mt-4">
                    <x-wire-button type="submit" blue >
                        Guardar
                    </x-wire-button>
                </div>

        </form>
    </x-wire-card>
```
- `<x-wire-card>`: Componente de WireUI
- `@csrf`: Encriptación segura de los datos enviados a la BD
- `value="{{ old('name') }}"`: En caso que no funcione el **CREATE** al recargar la view, recupera el último dato introducido en el input
- `action="{{ route('admin.roles.store') }}"`: Establecer la ruta a la cual se le pasaran los datos, en este caso se hará uso del método `store` del controller de Roles(`app/Http/Controllers/Admin/RoleController.php`)
Luego en `RoleController.php` en `store` deberá estar lo siguiente:
```php
public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name',
        ]);

        Role::create(['name' => $request->name]);

        return redirect()->route('admin.roles.index');
    }
```
Define un método público llamado `store`, que recibe una instancia de `Request` (contiene todos los datos del formulario enviado por POST).  
Este método es parte del **CRUD**, y se encarga de **guardar un nuevo rol** en la base de datos.

```php
$request->validate([
    'name' => 'required|string|max:50|unique:roles,name',
]);
```
Valida los datos recibidos del formulario, asegurándose de que:
- 'name' esté presente (required)
- Sea una cadena de texto (string) 
- Tenga un máximo de 50 caracteres (max:50) 
- Sea único en la columna name de la tabla roles (unique:roles,name)
Si la validación falla, Laravel **redirecciona automáticamente de vuelta** con los errores y no ejecuta el resto del método.

```php
Role::create(['name' => $request->name]);
```
**Crea un nuevo registro en la tabla `roles`** usando el modelo `Role` (de `Spatie\Permission\Models\Role`), con el campo `name` que viene desde el formulario.
Este método hace internamente un `INSERT INTO roles (name) VALUES (...)`.
>Será importante asegúrate de que el modelo `Role` tenga habilitada la asignación masiva para ese campo (`fillable`).

---
## C25: Uso de Slot
Dentro del fihcero `resources/views/layouts/admin.blade.php` ya previamente se añadio lo siguiente:
```php
 @isset($action)
                <div class="ml-auto">
                    {{ $action }}
                </div>
            @endisset
```
Entonces "si existe **$action** que lo muestre", ahora se hace uso de ello. Dentro del `resources/views/admin/dashboard.blade.php` está:
```php
<x-slot name="action"> </x-slot>
```
Aquí se define un slot llamado `action`, que puede ser rellenado por cualquier contenido Blade.En este caso, está vacío y sirve como marcador para ser completado desde una vista hija.

Entonces dentro de ese `slot` estará lo siguiente, dentro del fichero `resources/views/admin/roles/index.blade.php` está lo siguiente:
```php
<x-slot name="action">
        <x-wire-button blue href="{{ route('admin.roles.create') }}" xs>
            <i class="fa-solid fa-plus"></i>
            Nuevo
        </x-wire-button>
</x-slot>
```
Esta sección completa el slot `action` definido en la plantilla padre. Se utiliza el componente de WireUI `x-wire-button` para renderizar un botón que enlaza a la ruta `admin.roles.create`. Esto es útil para agregar acciones contextuales(como "Nuevo registro") en la interfaz de administración.
## C26: SweetAlert2 (con Session->fash())
Dentro del fichero `resources/views/layouts/admin.blade.php` se añade el `<script>` de [SweetAlert2](https://sweetalert2.github.io/#download). **SweetAlert2** es una biblioteca de JavaScript que permite crear ventanas emergentes personalizadas y atractivas en lugar de las alertas estándar de JavaScript.

Ahora dentro del fichero `Admin/RoleController.php` en le método `store`, luego de la creación del registro de crea una sesión:
```php
session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol creado correctamente',
            'text' => 'El rol ha sido creado exitosamente.',
        ]);
```
`session()->flash()` **sirve para almacenar temporalmente un dato en la sesión**, **solo durante la siguiente petición** (es decir, se borra automáticamente después de usarse una vez), ideal para mostrar mensaje como: 
- Notificaciones de éxito (por ejemplo: "Usuario creado correctamente")
- Alertas o errores
- Mensajes de confirmación

**Flash o Put?**
Tambien existe `session()->put()`, con `put()`, el dato se mantendría en la sesion **hasta que se borre manualmente**, pero con `flash()` es temporal.

Entonces de establecer que se guardará ese array temporalmente
>la estrucura del array está basada en la estructura que debería tener un array para su uso con sweetAler2
Dentro del fichero `admin.blade.php`, está el bloque si revisa si existe esa clave y dispara el arte, es decir la clave **"swal"**:
```php
@if (session('swal'))
    <script>
        Swal.fire(@json(session('swal')))
    </script>
@endif
```
El flujo general sería:
- Se crea el `Rol` y se guarda un mensaje flash en la sesión.
- Se redirige a `admin.roles.index`.
- En esa vista se carga el layout, y si existe `session('swal')`, se genera el `Swal.fire(...).`
- Se muestra la alerta.
- Laravel elimina automáticamente ese valor flash de la sesión.
## C27: Controller User
*Esto será algo ya visto, pero igual estará los pasos*
Ahora estará la gestión de los usuarios, para ello lo primero será crear un controller de usuarios:
```bash
php artisan make:controller Admin/UserController --
model=User
```
El controller estará dentro de `app/Http/Controllers/Admin/`, además con `--model=User`, se especifica que **el controller deberá utilizar el modelo de User**. el mensaje de exito será:
```bash
INFO  Controller [app/Http/Controllers/Admin/UserController.php] created successfully.
```

Luego será la creación de las **views**:
```bash
views
└── admin
    ├── roles
    └── users
        ├── create.blade.php
        ├── edit.blade.php
        └── index.blade.php
```

Luego de esto, se deberá crear las rutas. Dentro de `routes/admin.php` deberá estar lo siguiente: 
```php
Route::resource('users', UserController::class);
```
Dento del comentario `C22: Ruta para los roles (Route::resource)` se explia mas en detalle como funciona `resource`.

Ahora se añade en el sidebar la ruta de usuario junto con los breadcrumbs:
```php
 'name' => 'Usuarios',
 'icon' => 'fa-solid fa-users',
 'href' => route('admin.users.index'),
 'active' => request()->routeIs('admin.users.*'),
```
El ejemplo del breadcrumb será el de la view de `users/create`:
```php
<x-admin-layout title="Usuarios | CitasMédicas" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',
        'href' => route('admin.users.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">
```
## C28: Asignación de Rol a User con Laravel Permission:
Ya se mencionó como funciona previtamente **Laravel Permission** en el comentario `C20: Laravel Permission`, ahora se pasa a su uso pero en `User`.
Primero se deberá crear el seeder de User:
```bash
php artisan make:seeder UserSeeder
```
creando el fichero `database/seeders/UserSeeder.php`, ahora dentro del `foreach` deberá estar lo siguiente:
```php
foreach ($users as $userData) {
            $user = User::factory()->create($userData);
            $user->assignRole('Doctor'); 
        }
```
Entonces a `$user` le decimos `->assignRole('Doctor')`, esto hará que se le asigne el rol de Doctor, pero para saber como funciona debemos tener en cuenta lo siguiente:
Previamente del del model de user: `app/Models/User.php` se añadió el siguiente `trait`: `use Spatie\Permission\Traits\HasRoles;`, este `trait` lo que hace es agregar distintos métodos como:
- assignRole()
- hasRole()
- getRoleNames()
- syncRoles()
- y mucho más

Entonces cuando se llama a:
```php
$user->assignRole('Doctor');
```
Spatite hace una consulta en la tabla `roles` para encontrar el registro con `name = 'Doctor`. es decir algo como esto:
```sql
SELECT * FROM roles WHERE name = 'Doctor' LIMIT 1;
```

Luego cuando se crea el registro, además se crea una relación en la tabla `model_has_roles`. Esta tabal es una tabla intermedia con lo siguiente:
- role_id (el ID del rol que encontró)
- model_type = 'App\Models\User'
- model_id = ID del usuario
Esto funciona gracias a una **relación polimórfica**, así se puede asignar roles no solo a `User`, sino también a otros modelos si se desea. Aría algo así:
```sql
INSERT INTO model_has_roles (role_id, model_type, model_id)
VALUES (2, 'App\Models\User', 1);
```

La relación creada queda activa para futuras validaciones, entonces luego ya se puede usar:
```php
$user->hasRole('Doctor'); // true
```
Laravel Permission carga esa relación internamente usando Eloquent
### Lo que estaría en la BD sería:
```bash
mysql -u citas_user -p
Enter password: "contraseña"
mysql> USE citas_medicas;

SELECT id, name FROM roles;
+----+---------------+
| id | name          |
+----+---------------+
|  3 | Administrador |
|  2 | Doctor        |
|  1 | Paciente      |
|  4 | Recepcionista |
+----+---------------+

mysql> select * from model_has_roles;
+---------+-----------------+----------+
| role_id | model_type      | model_id |
+---------+-----------------+----------+
|       2 | App\Models\User |        1 |
|       2 | App\Models\User |        2 |
+---------+-----------------+----------+

mysql> select id, name from users;
+----+----------------------+
| id | name                 |
+----+----------------------+
|  1 | Maximiliano Gallegos |
|  2 | José Alarcón         |
+----+----------------------+
```
Estan serían las tres tablas que están relacionadas en este caso, `model_has_role`, es decir, la tabla intermedia que asocia roles a models, como `user`, tiene esto:
```bash
| role\_id | model\_type     | model\_id |
| -------- | --------------- | --------- |
| 2        | App\Models\User | 1         |
| 2        | App\Models\User | 2         |
```
Esto significa que los usuarios 1 y 2 tiene el rol con ID 2 (Doctor)


Diagrama:
```bash
          ┌────────────┐
          │  User (id) │
          └─────┬──────┘
                │ assignRole('Doctor')
                ▼
        ┌────────────────────┐
        │  Busca en roles    │ ◀─── name = 'Doctor'
        └─────────┬──────────┘
                  │
                  ▼
     ┌──────────────────────────────┐
     │ Inserta en model_has_roles   │
     │ (role_id, model_type, model_id) │
     └──────────────────────────────┘
```
## C29: Laravel Permission VS Laravel Vanilla
*Comentario no vinculado a un fichero en especifico, solo se plantea si ¿vale la pena usar Laravel Permission o manejar roles y permisos de forma manual?*
### Con Laravel Permission
**Ventajas de usar Laravel Permission (Spatie)**
| Ventaja                                   | Detalle                                                                               |
| ----------------------------------------- | ------------------------------------------------------------------------------------- |
| **Estandarizado**                         | Es una solución probada, usada por miles de proyectos Laravel.                        |
| **Polimórfico**                           | Puedes asignar roles/permisos a otros modelos (no solo `User`).                       |
| **Relación muchos-a-muchos lista**        | Ya vienen con `roles`, `permissions`, `model_has_roles`, `role_has_permissions`, etc. |
| **Métodos útiles ya listos**              | Como `hasRole()`, `hasPermissionTo()`, `assignRole()`, `syncPermissions()`, etc.      |
| **Middleware incorporado**                | Puedes proteger rutas fácilmente: `->middleware('role:Admin')`                        |
| **Permite múltiples roles por usuario**   | Sin esfuerzo extra.                                                                   |
| **Permisos directos o a través de roles** | Puedes dar permisos a un usuario sin asignarle un rol.                                |
| **Buen soporte y documentación**          | Comunidad activa y bien mantenido.                                                    |

Desventajas al utilizarlo:
| Desventaja                                       | Detalle                                                            |
| ------------------------------------------------ | ------------------------------------------------------------------ |
| **Aprendizaje inicial**                          | Requiere entender cómo funciona el sistema de Spatie y sus tablas. |
| **Puede ser "overkill" para proyectos pequeños** | Si solo necesitas "Admin" y "Usuario", puede ser innecesario.      |
| **Dependencia externa**                          | Si algún día cambias de enfoque, tienes que migrar datos y lógica. |
### Sin Laravel Permissions
Ventajas:
- Control total: manualmente se decide cómo es la tabla `roles`, cómo se asocian, cómo se valida, etc.
- Simple en proyectos muy pequeños (por ejemplo, solo 2 roles, admin y user)

Desventajas:
- Cosas que se tienen que implementar de manera manual:
    - Relaciones
    - Middleware para roles
    - Comprobaciones (ej: `if ($user->role === 'admin')`)
    - Permisos personalizados
- Difícil de escalar (si se quiere más de 2 o 3 roles/permisos, puede complicarse)
- No se puede usar helpers como `@can`, `@role`, `@assignRole()`.
## C30: Laravel Livewire Table personalizada
Primero se deberá crear una nueva tabla, con el siguiente comando: 
```bash
php artisan make:datatable Admin/Datatables/UserTable User
```
eso creará el fichero `app/Livewire/Admin/Datatables/UserTable.php`, dentro de el pasará lo siguiente:
### Formateo de datos
Con Laravel Livewire Table se pueden crear métodos dentro del fichero de las tablas para su uso, por ejemplo en este caso se crearon dos métodos, uno para el formateo del número teléfonico y el DNI que en este caso sería RUN:
**FORMATEO DE RUN**:
```php
protected function formatRun($run)
    {
        $run = preg_replace('/[^0-9kK]/', '', $run);
        $dv = strtoupper(substr($run, -1));
        $num = substr($run, 0, -1);
        $formatted = number_format($num, 0, '', '.');

        return $formatted . '-' . $dv;
    }
```
El método `formatRun()` lo que hace es converitr un **RUN** chileno (sin formato) en un formato legible como: "12345678k  →  12.345.678-K"
- `$run = preg_replace('/[^0-9kK]/', '', $run)`: Limpi el valor recibido y **elimina todo lo que no sea un número del 0 al 9 o la letra "k" (mayúzcula o minuscula)**, entonces si llega: `'12.345.678-k'`, lo convierte en:`12345678k`
- `$dv = strtoupper(substr($run, -1))`: Toma el último carácter(el dígito verificador) y lo convierte a maúscula (K en ves de k), es decir: 12345678k → dv = 'K'
- `$num = substr($run, 0, -1)`: Toma **todos los caracteres menos el último**, es deir, **la parte numérica del RUN**. Ejemplo: `12345678k` → `num = '12345678'`.
- `$formatted = number_format($num, 0, '', '.')`: Aplica puntos de miles al número. 12345678 → 12.345.678
- `return $formatted . '-' . $dv;`: Une el número formateado con su dígito verificador usando `-`. 
Entonces si de entrada está el DNI(Run): 12345678k, su salida al usuario será "12.345.678-K", mejorando la legibilidad para el usuario sin alterar los datos originales

**FORMATEO DE NÚMERO DE TELÉFONO**:
En Chile los números de celular tienen el siguiente formato: **"56930608642 → 11 dígitos"**, para poder limpiar vien los datos de salida se creó el siguiente método:
```php
protected function formatPhone($phone)
    {
        $digits = preg_replace('/\D/', '', $phone);

        if (strlen($digits) === 11 && substr($digits, 0, 3) === '569') {
            $country = substr($digits, 0, 2); // 56
            $carrier = substr($digits, 2, 1); // 9
            $part1 = substr($digits, 3, 4);   // XXXX
            $part2 = substr($digits, 7);      // XXXX
            return "{$country} {$carrier} {$part1} {$part2}";
        }
        return $phone;
    }
```
## C31: Uso de builder() con with('roles') para cargar roles en Livewire Table
Dentro del fichero `Admin/Datatables/UserTable.php` está lo siguiente:
```php
// protected $model = User::class;
public function builder(): Builder
    {
        return User::query()->with('roles');
    }
```
Primero se comenta `$mode. = User::class`. Laravel Livewire Tables permite definir el modelo de dos maneras:

**Opción A - Usando `$model` directamente:**:
```php
protected $model = User::class;
```
Esto usa el modelo `User` como fuente de datos **sin aplicar relaciones personalizadas o scopes adicionales**

**Opción B - Usando `builder()`:**
```php
public function builder(): Builder
{
    return User::query()->with('roles');
}
```
Esta es una **opción más flexible**, y permite agregar relaciones, filtros, scopes, etc. En este caso:
- Se hace `->with('roles')`, lo cual **carga la relación** `roles` usando Eager Loading
- Esto evita múltiples consultas N+1 al acceder a `$user->roles` en cada fila de la tabla

Entonce al hacer el uso del método `builder()` hace uso de Laravel Permission (Spatie), dentro del model de user: `app/Models/User.php` está el siguiente `trait`:
```php
use Spatie\Permission\Traits\HasRoles;
```
y dento del Extends está 
```php
use HasRoles;
```
Esto le da el model `User` un método `roles()` como si se hubiera definido:
```php
public function roles()
{
    return $this->belongsToMany(Role::class, 'model_has_roles');
}
```
*esta tabla es la intermedia de User y Role*
Por lo tanto cuando se hace:
```php
User::query()->with('roles');
```
Se está **extrayendo los datos de la tabla** `model_has_roles` + `roles` asociadas al usuario, para que luego se pueda usar:
```php
$row->roles->first()?->name ?? 'Sin rol';
```
en la tabla sin generar múltiples queries.
## C32: Creación de nuevo Usuario
Para la creación de un nuevo usuario se utilizaron componentes de WireUI, dentro del fichero `resources/views/admin/users/create.blade.php` se  encontrará lo siguiente:

**Creación del Form**:
```php
<x-wire-card>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        ...
</x-wire-card>
```
Primero el `action` deberá apuntar a la ruta de **"admin/user/store"**, como es una creación deberá ser de `method` tipo `POST`, además de añadirle el `csrf` para cifrar los datos:

**Uso de inputs de WireUI**:
```php
<x-wire-input name="name" label="Nombre"
```
La ventaja de usar los inputs de [WireUI](https://wireui.dev/components/input) es la itegración del `label` de forma más simple dentro del formulario, además de que se pueden agregar más cosas, ver la documentación en el enlace previo para más detalle.

**Uso de iconos con Hericons**:
WireUI trabaja con iconos de [Heroicons](https://heroicons.com/), entonces para su uso se deberá saber el nombre de un icono y agregarlo en este caso al input así:
```php
<x-wire-input name="address" label="Dirección" icon="home" 
```
Con el nombre de **"home"** WireUI agrega el icono de la biblioteca de Heroicons.

**Campo de Rol**:
Ahora para poder cargar un **SELECT** de todos los roles se deberá además utilizar el controller de User:
```php
public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }
```
La variable `$roles` tendrá todos los registro de **Role**, en este caso la importación del modelo de rol tiene que ser de Spite, es decir, su trait es: `use Spatie\Permission\Models\Role;`

```php
<x-wire-native-select label="Rol" name="role_id" icon="user-circle" required>
    <option value="" disabled selected>Selecione un rol</option>

    @foreach ($roles as $role)
        <option value="{{ $role->id }}">
            @selected(old('role_id') == $role->id)
            {{ $role->name }}
        </option>
    @endforeach
</x-wire-native-select>
```
Gracías al `compact('roles')` utilizado en el controller de User, **dicha variable ahora estará disponible dentro de la view de creación**, es decir, tendrémos todos los valores de rol para su uso. Ahora con un `@foreach` se **recorren los roles y se van agregando como opciones en el `<option>`**. Importante será que se le asigne como `value` el `$role->id`, ya que se **ID será que deberá ir en el registro de creación**.

**Visualizar los datos de envio**:
Ahora si por ejemplo en el método `store` está lo siguiente:
```php
public function store(Request $request)
    {
        return $request->all();
    }
```
Esto retornará en el navegador la petición completa que se acaba de enviar, si como ejemplo llenamos los datos del formulario de cración y lo enviamos al llegar al `store` se mostrará en el navegador:
```json
{
  "_token": "2tut2bNKV4U65i2qLoglOo4qwOup2XuUnzedzKnf",
  "name": "Dalpo Chi",
  "email": "dalpo@gmail.com",
  "password": "dalpoElGuapo",
  "password_confirmation": "dalpoElGuapo",
  "address": "Chonchi #4232, San Gatos",
  "phone": "56913141516",
  "dni": "259874562",
  "role_id": "1"
}
```
## C33: CSRF token
Siguiendo el comentario `C32` previo, ahi dentro de los datos recibidos por el método store está entre dichos datos el campo `_token`.
Dentro de un formulario al utilizar `@csrf` hace que Laravel **automáticamente genera un token CSRF único por sesión de usuario y lo inlcuye como un campo oculto en los formularios HTML** cuando se usa el helper `@csrf`
Por ejemplo si tengo el siguiente formulario:
```php
<form method="POST" action="/usuarios">
    @csrf
    <!-- otros inputs -->
</form>
```
Internamente ese envio se convierte en algo como:
```php
<input type="hidden" name="_token" value="2tut2bNKV4U65i2qLoglOo4qwOup2XuUnzedzKnf">
```
Y cuando se envía el formulario, Laravel verifica que ese token coincida con el que está almacenado en la sesión del usuario. Si no coincide, Laravel lanzará una excepción `419 Page Expired`.
Entonces el **token CSRF** que Laravel genera es para proteger la aplicación contra ataques de tipo **Cross-Site Request Forgery (CSRF).**

### Qué es CSRF:
Un ataque CSRF intenta engañar al navegador de un usuario autenticado para que realice una acción no deseada en una aplicación web en la que ya está autenticado. Laravel usa tokens CSRF para asegurarse de que el formulario que se envía realmente proviene de tu aplicación y no de una fuente externa maliciosa.
## C34: Guardar usuario en la BD
Dentro del controller de User, en el método **Store** deberá primero tener una validación de los datos:
```php
$data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'dni' => 'required|string|max:20|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role_name' => 'required|exists:roles,name',
        ]);
```
Este es un ejemplo de validaciones simples en Laravel, hay otras formas mejores, pero con esto bastará de momento.

Luego se crea la variable `$user` en la cual se guardará el modelo de **User** que tendrá el método `create` en la cual estarán los datos de la validación: 
```php
$user = User::create($data);
```

**Asignación de rol al user**:
```php
$user->assignRole($data['role_name']);
```
El método `assingRole` es un método que viene del **trati** `HasRoles`, el cual se está usando en el model de `Uuser`:
```php
use Spatie\Permission\Traits\HasRoles;
```
Este método sirve para **asignar uno o más roles** a un modelo (ej. un usuario), y funciona de forma segura con validaciones, relaciones y registros automáticos.
Entonces cuando se llama a  `$user->assignRole('admin');` internamente pasa lo siguiente:
1. **Verifica qué tipo de valor se está pasando**: Puede ser un string, un ID, un array de nombres, o incluso una coleccioón de modelos `Role`
2. **Busca los roles en la BD** usando el nombre (o ID), a través del modelo `patie\Permission\Models\Role`, validando que existan y que pertenezcan al `guard` correcto (por efecto `web`)
3. **Relaciona el rol con el usuario** guardando el vínculo en la tabla intermedia `model_has_roles`, usando una relación polimórfica (`model_type`, `model_id` y `role_id`)
4. **Evita duplicados**: Si el usuario ya tiene asignado ese rol, no lo vuelve a insertar

**Uso de `attach`**:
En lugar de usar el assing: `$user->assignRole($data['role_name'])`, tambien se puede usar lo siguiente:
```php
$user->roles()->attach($data['role_id']);
``` 
El método `attach()` es un método estaándar de Eloquent que solo sirve para relaciones *muchos a muchos* normales, no polimórficas. Si se usa directaente se podría:
- Insertar el rol en una tabla equivocada
- Omitir el `model_type`
- Dañar las funciones de `hasRole()`, `getRoleNames()`, etc.  

**Qué hace `assingRole()` que `attach()` no?**:
Cuando se usa Spatie, los roles están definidos en la tabla `roles` y relacionados con cualquier modelo (`User`, `Team`, etc) a través de la tabla `model_has_roles`
```bash
model_has_roles
---------------
role_id
model_type → ej. 'App\Models\User'
model_id   → ej. 3
```
Spatie usa esta relación polimórfica, y métodos como `assingRole()` aseguran que todo se haga bien con esa estrucura.
En cambio, `attach` es un método que sireve para relaciones polimórficas normales como ya se mencionó.

**Diferencias** con GPT
|                                           | `assignRole()` (✅ Recomendado)  | `attach()` (❌ No recomendado)                         |
| ----------------------------------------- | ------------------------------- | ----------------------------------------------------- |
| 🔗 Usa `model_has_roles` (tabla especial) | ✅ Sí                            | ⚠️ No directamente, se salta la lógica del package    |
| 🧠 Valida si el rol existe                | ✅ Sí (lanza error si no existe) | ❌ No (puede insertar datos incorrectos)               |
| 🔐 Verifica el `guard` (`web`, etc.)      | ✅ Sí                            | ❌ No                                                  |
| 🔁 Evita duplicados                       | ✅ Sí                            | ❌ No (puede agregar el mismo rol varias veces)        |
| 🧩 Respeta la lógica polimórfica          | ✅ Sí (usa `model_type`, etc.)   | ❌ No (no es compatible con polimorfismo directamente) |
| 📦 Compatible con los métodos de Spatie   | ✅ Totalmente                    | ❌ No, puede romper `hasRole()` y otros                |
## C35: Edición de usuario (syncRoles)
El formulario de edición será similar al de creación, con algunas adiciones:
### **Contraseña**:
Primero, la contraseña no será un input `required`, por lo que dentro del método `update` del controller deberá estar lo siguiente:
```php
if($request->password){
            $user->password = bcrypt($request->password);
            $user->save();
        }
``` 
Con esto decimos: "Si dentro del `$request` recibido hay un "password" quiero que se **obtenga la contraseña previamente registrada y la cambies por la nueva contraseña recibida** en el `$request`.
### **Datos unicos repetidos**:
Tanto el dato email como DNI están establecidos en la tabla de User como datos únicos, se deberá manejar esto para que no de error:
```php
$data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'dni' => 'required|string|max:20|unique:users,dni,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role_name' => 'required|exists:roles,name',
        ]);
```
Si en la validación del campo `email` usas simplemente:
```php
'email' => 'required|string|email|max:255|unique:users,email'
```
entonces, al intentar actualizar un usuario que ya tiene ese correo registrado, Laravel lanzará un error de validación indicando que el correo ya existe.
Esto ocurre porque la regla `unique` verifica que ningún otro registro en la tabla `users` tenga ese mismo correo, incluyendo el del propio usuario que estás actualizando. Para evitar ese falso positivo, se debe excluir al usuario actual de la validación agregando su ID como tercer argumento de la regla `unique`, así:
```php
'email' => 'required|string|email|max:255|unique:users,email,' . $user->id
```
Esto le indica a Laravel que ignore el registro con ese ID al comprobar la unicidad del correo, permitiendo que el usuario mantenga su propio correo sin causar errores de validación.
### syncRoles
Normalmente para relacionar el rol al usuario se podría hacer algo como esto:
```php
$user->roles()->sync([$request->role_name]);
```
Y por ejemplo `role_name` contiene algo como `'Doctor'`, (el nombre del rol), pero `roles()->sync()` espera los **IDs** de los roles, no sus nombres, en este caso si estubiera esa línea lanzaría un error como: **"Incorrect integer value: 'Doctor' for column 'role_id'"**
Como se está trabajando con **Laravel Permission** y ya se está usando el nombre del rol(`role_name`), **se debrá usar el método** `syncRoles()` que es el equivalente correcto y seguro en este package:
```php
$user->syncRoles([$request->role_name]);
```
Entonces, por qué usar `syncRoles` y no `roles()->sync`:
- `roles()->sync()` es una relación Eloquent directa → espera IDs.
- `syncRoles()` es un método del trait `HasRoles` → acepta nombres, IDs o modelos.
- `syncRoles()` limpia los roles anteriores del usuario y asigna solo los nuevos de forma segura.
Con este cambio no habrá errores y se **estará usando correctamente la lógica de Spatie**.
##
##
##
##
##
##
##
##
##
##
