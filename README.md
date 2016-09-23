<<<<<<< HEAD
### Tuts+ Tutorial: [Building a Bootstrap Contact Form Using PHP and AJAX](https://webdesign.tutsplus.com/tutorials/building-a-bootstrap-contact-form-using-php-and-ajax--cms-23068)
#### Instructor: Aaron Vanston

In this tutorial I’ll go over the steps on creating a working contact form, utilising the ever popular front-end framework Bootstrap, in combination with AJAX and PHP.

**Available on Tuts+ August 2015**
=======
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
>>>>>>> 5c42938a3c4d4b05c2925c9fde9756dacea7fee3
