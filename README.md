# HasOneSpecific
Add a Laravel relationship where you can specify a set ID, instead of a dynamic relationship

## Installation
```
composer install cmandersen/has-one-specific
```

## Usage
This package is basically just a trait that uses a relationship class, so it's just a case of using the trait where you need it.
```php
class User extends Model {
    use \CMAndersen\HasOneSpecific\HasOneSpecific;
    
    public function company(){
        return $this->hasOneSpecific(Company::class, 97);
    }
}
```