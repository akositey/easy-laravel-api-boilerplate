# Easy Laravel API Boilerplate
Easy RESTful API server using Laravel 7

## Built with
[Laravel 7](https://github.com/laravel/laravel) && [JWT-Auth](https://github.com/tymondesigns/jwt-auth)

### Setting Up
after installing composer packages and .env file, generate a JWT_SECRET using `php artisan jwt:secret`

### Adding an API 
1. Generate model, controller, migration and factory: ```php artisan make:model Api/[YourModel] -ar --api``` 
     - edit migration file
     - edit model: set `$table` and `$fillable` properties
2. Create validation rules in `app/Http/Requests/Api/ValidationRules/[YourModelRules].php`
3. Inject created Model and Validation Rules in `construct` method of the Controller.
4. Add an `apiResource` route in `routes/api.php`
   - If you use SoftDeletes, also add a route for `restore` method
5. Check `php artisan route:list` for api endpoints
   
### Production
make sure routes in `routes/api.php` have `auth:api` middleware 
  
## To Do
- user roles & permissions? / authorization
- ideas?

## License
[MIT license](https://opensource.org/licenses/MIT)
