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
8. Setup the Mail configuration with any technology you desire. An example of using MailTrap is below.
```
# MAIL_MAILER=smtp
# MAIL_HOST=smtp.mailtrap.io
# MAIL_PORT=2525
# MAIL_USERNAME=username from mailtrap
# MAIL_PASSWORD=password from mailtrap
# MAIL_ENCRYPTION=tls
# MAIL_FROM_ADDRESS=testing@gmail.com
# test
```
9. Configure the API KEYS, contact me for the API keys if none is available.
```
CLIENT_ID_FIRST= maestro .6
CLIENT_SECRET_FIRST= maestro .6
CLIENT_ID_SECOND= maestro .21
CLIENT_SECRET_SECOND= maestro .21
````

10. Fill the database, using the following commands.
```
$ php artisan db:seed --class=MaestroSeeder
$ php artisan network:populate
$ php artisan tower:populate
$ php artisan accesspoint:populate
```
11. Run the scheduler and the queue commands
```
$ php artisan queue:work
$ php artisan scheduler:work
```
12. Any information, contact me for more info.







```

