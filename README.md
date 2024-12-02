# TLT CMS
CMS helpers for Laravel Orchid

## Installation

First install and set up Laravel framework and Orchid platform as described in documentation, next add to composer.json

```
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:taiwanleaftea/tltcms.git"
    }
]
```

Run the following commands from your terminal:

```bash
composer require taiwanleaftea/tltcms
```

```bash
php artisan vendor:publish --tag=tltcms --ansi --force
```

config/tltcms.php and migrations will be published, next run

```bash
php artisan migrate
```

add to app/Orchid/PlatformProvider.php 

```
public function menu(): array
{
    return [
        ...
        Menu::make(__('Settings'))
            ->icon('gear')
            ->route('admin.settings'),
        ...
    ];
}
```

If you want edit views, you can publish them using command

```bash
php artisan vendor:publish --tag=tltcms-views --ansi --force
```

## Usage

The project includes Breadcrumbs, MainMenu modules, Image optimizing module, Slug module, and some useful helpers.