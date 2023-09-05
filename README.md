- Criar projeto Laravel
```sh
curl -s "https://laravel.build/2023-09-03-laravel-dropbox?with=pgsql,redis" | bash
```
- Entra na pasta do projeto
```sh
cd 2023-09-03-laravel-dropbox
```

- Inciar projeto github
```sh
git init
```

git add .
git commit -m 'start project'
sail up -d
sail composer require spatie/flysystem-dropbox
code .
sail artisan make:provider DropboxServiceProvider
- editar `app/Providers/DropboxServiceProvider.php`
```php
namespace App\Providers;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;

class DropboxServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Storage::extend('dropbox', function ($app, $config) {
            $adapter = new DropboxAdapter(new Client(
                $config['authorization_token']
            ));

            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });
    }
}
```
- Registar o provider em `config/app.php`
```php
//...
    'providers' => ServiceProvider::defaultProviders()->merge([ //...
        //... outras providers...
        App\Providers\DropboxServiceProvider::class,
    ])->toArray(),
//...
```
https://www.dropbox.com/developers
- Adicionar no `.env`
DROPBOX_ACCESS_TOKEN=<your-access-token>

- Adicionar ao config/filesytem.php
```php
    //...
    'disks' => [
        //...
        'dropbox' => [
            'driver' => 'dropbox',
            'authorization_token' => env('DROPBOX_ACCESS_TOKEN'),
        ],
    ]
    //...
```
