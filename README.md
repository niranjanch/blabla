# blabla

## Installation
Run the following command.
```composer require niranjanch/blabla```

Add the service provider to the ```config/app.php``` file under the ```providers``` key. Make sure to add it after the default laravel service providers.
```php
'providers' => [
    ...,
       	Niranjanch\Blabla\BlaServiceProvider::class,
]
```

Add the aliases to the ```config/app.php``` file under the ```aliases``` key. Make sure to add it after the default laravel service providers.
```php
'aliases' => [
    ...,
        'Bla' => Niranjanch\Blabla\Facade\Bla::class,
]
```

## Usage

//get Hello word string
Bla::saySomething();
