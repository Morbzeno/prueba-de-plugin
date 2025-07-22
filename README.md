# hk_estadias_01

***

Este es un proyecto con implementacion de filament para un panel de administracion que usa de disntintos plugis y funciones, ten en cuenta que esta documentacion tiene en mente que ya tengas tu proyecto de filament inicializado, así que no se abarcara dicho contenido, en caso de que inicies desde 0, aqui esta la documentacion oficial de filament para que inicies tu proyecto:
`https://filamentphp.com/docs/3.x/panels/installation`
Una vez termines, sigue estos pasos:


***

### 1-Asegúrate de tener habilitadas las siguientes extensiones en tu archivo `php.ini`:

- `curl`
- `fileinfo`
- `gd`
- `intl`
- `mbstring`
- `exif`
- `mysqli`
- `pdo_mysql`
- `pdo_sqlite`
- `zip`


### 2-Inica el composer
`composer install`
Esto instalara todas las dependencias necesarias para el proyecto

### 3-Instala el paquete de laravel/ui y liveware
`composer require laravel/ui`
`composer require livewire/livewire`                                        


### 4-Conecta con el paquete
`composer config repositories.prueba-de-plugin path (ubicacion del plugin en tu ordenador)`
`composer require morbzeno/prueba-de-plugin:dev-main`
Esto te permitira tener el paquete a la mano para publicar todo lo referente al plugin a tu proyecto

### 5-Paquete complementario
Para el tema de la seguridad se usa un paquete externo, aqui los comandos para implementarlo:

`php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider`
`composer require althinect/filament-spatie-roles-permissions`

### 6-publica los datos a tu proyecto 
`php artisan vendor:publish --provider="Morbzeno\PruebaDePlugin\PruebaDePluginServiceProvider"  --force`
`php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --force`


### 7-Traduce el proyecto
Para traducir el proyecdto debes dirigirte a la seccion de app.php en config y cambiar tu locate de "en" a "es"

### 8-configura tu .env para mandar correos.
Para la correcta implementacion de este proyecto, necesitas tener un simulador de correos electronicos y configurarlo a tu entorno, aqui te dejo unos links a tutoriales con alternativas para diferentes sistemas operativos

windows: mailhog https://www.bing.com/videos/riverview/relatedvideo?&q=mailpit+windows&&mid=B9AD2BF940CA74E3F7A8B9AD2BF940CA74E3F7A8&&FORM=VRDGAR

lynux y mac:https://mailtrap.io/blog/mailhog-explained/

### 9-Prepara el plugin
Para que este plugin funcione debes agregarlo en tu seccion de plugins, solo agrega el plugin de morbzeno, no el de spaie, así: ademas agrega en tu auth la clase para verificar que el mail esta autentificado

`use Morbzeno\PruebaDePlugin\PruebaDePluginPlugin;`

`class AdminPanelProvider extends PanelProvider`
`{`
    `public function panel(Panel $panel): Panel`
    `{`
        `return $panel`
            `->authMiddleware([`
                `Authenticate::class,`
                `\Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,`
            `->plugins([`
                `PruebaDePluginPlugin::make()`
            `]);`
    `}`
`}`

### 10-Configurar el modelo de usuario
En tu modelo de usuario deberas agregar algunas cosas para que se pueda acoplar de mejor manera al plugin:

use Althinect\FilamentSpatieRolesPermissions\Concerns\HasSuperAdmin;
use App\Mail\DeleteNoticeMail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use HasRoles;
    use HasSuperAdmin;
    use Notifiable;

        protected static function booted()
    {
        static::deleted(function ($user) {
            Mail::to($user->email)->send(new DeleteNoticeMail($user->name, $user->name));
        });
    }

      public function Blog ()
      {
            return $this->belongsOne(Blogs::class);
      }
            public static function newFactory()
      {
            return \Database\Factories\UserFactory::new();
      }
}



### 11-instala el storage para manejo de fotografias
`php artisan storage:link`

#### 12-para iniciar las pruebas corre:
`php artisan test`

Recuerda volver a correr los seeders despues de los testings, ya que refrescan la base de datos.

#### 13-Para iniciar los seeders corre:
`php artisan db:seed`

#### para entrar en el panel de administracion hay 6 usuarios, cada uno con su propio rol y permisos adjuntos, aqui los usuarios:
-superAdmin@gmail.com
-admin@gmail.com
-viewer@gmail.com
-suscriptor@gmail.com
-seguidor@gmail.com
-colaborador@gmail.com

Puedes modificar sus permisos individuales al modificar los permisos de cada rol en la seccion de roles en el panel de administracion de laravel.

todos comparten la misma contraseña, que es "Password123?", aunque puedes cambiarla en los seeders
