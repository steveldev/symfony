# Entity schema

## Usage

### New project 
```
composer create-project symfony/skeleton EntitySchemaRepo  
composer require doctrine/doctrine-bundle  
composer require doctrine/orm  
```

### Existing project : 
- Copy this repository in your Symfony project. (./src/)
- Run migration ```php bin/console d:m:m  ```

### Run server
```php -S 127.0.0.1:8000 -t public```

Call Api endpoint : ```http://localhost/api/book/schema```  
  
Return
```
  {
  "id": {
    "type": "integer",
    "nullable": false
  },
  "title": {
    "type": "string",
    "nullable": false
  },
  "author": {
    "type": "ManyToOne",
    "nullable": true,
    "entity": "Author"
  }
}``` 
