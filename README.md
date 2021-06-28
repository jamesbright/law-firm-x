#### Clients profile app built with [Laravel](https://laravel.com) [Vue](https://vuejs.org) and [Tailwind CSS](https://vuejs.org) 

## Setup

1. open command line and run `git clone https://github.com/jamesbright/law-firm-x` to clone this repository into your machine

2. after successful cloning, `cd law-firm-x`

3. run `cp .env.example .env` to create an environment config file from the example file

4. open .env file in code editor and set the mysql database credentials: you can leave it as default if the username and password matches that on your machine.

5. set the mailtrap credentails: login to [Mailtrap](https://mailtrap.io) and set `MAIL_USERNAME` and `MAIL_PASSWORD` to your credentials.

6. if you used the default mysql credentials then create a mysql database with name `law-firm-x` using phpmyadmin or cli.
```php
 mysql -u root -p
  create database law-firm-x;
  exit
 ```
 7. i assume you have [composer](https://getcomposer.org) 
 installed, ensure you are in the project root directory and run `composer install`

![composer](https://getcomposer.org/img/logo-composer-transparent5.png)

8. migrate database files with `php artisan migrate`
9. run `npm install && npm run dev`  to install and compile frontend dependencies
10. `php artisan storage:link` to link storage
11. `php artisan key:generate` to generate fresh app key
12. finally `php artisan serve`, open app in browser url `localhost:8000`

### Addition
To remind clients to add their profile picture every 3 days `('0 0 */3 * *')`  a cron job was used. You need a Linux Operating System to run Cron Jobs. 
to setup the Cron Jobs to run automatically without initiating manually by running the command,we need to  start the Laravel Scheduler itself, we only need to add one Cron job which executes every minute. Go to your terminal,cd into your project and run this command `crontab -e` This will open the server Crontab file, paste the code below into the file, save and then exit. you can find more info here [Laravel task scheduling](https://laravel.com/docs/8.x/scheduling)
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```
`path-to-your-project` here should be `law-firm-x`

## previews

![](https://github.com/jamesbright/law-firm-x/blob/master/preview/Capture3.JPG) ![](https://github.com/jamesbright/law-firm-x/blob/master/preview/Capture4.JPG)

![](https://github.com/jamesbright/law-firm-x/blob/master/preview/Capture.JPG)

![](https://github.com/jamesbright/law-firm-x/blob/master/preview/Capture2.JPG)



