# Speednet Monitoring
## Dependencies 
* PHP
* Composer
* MySQL
* GIT
* 

### Installation
To set the project up, follow the instruction below.

1.Clone the respository in a directory of your desire
```
$ git clone https://github.com/Kurai1234/SmartCapacityReport/tree/development
```
2. Go into directory and checkout the development branch using GIT.
3. Install all the dependencies with composer
```
$ composer install
```
4. After installation, create a .env file using .env.example as a reference.
```
cp .env.example .env
```
5. Generate a key for the application
```
$ php artisan generate:key
```
6. Create a empty database in MySQL for this application
7. Configure the .env to connect to the database, an example using smart_monitoring as a database example.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smart_monitoring
DB_USERNAME=root
DB_PASSWORD=
```


