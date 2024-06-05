<img src="./minouland_logo.png"> 

# Minouland - E_Commerce Project

## API - LARAVEL

Create a database locally named nomdeladb utf8_general_ci

Download composer 

Pull the Laravel project from our github.

Rename .env.example file to .envinside your project root and fill the database information.

Open the console and cd your project root directory

Run composer install or php composer.phar install

Run php artisan key:generate

Run php artisan migrate

Run php artisan db:seed to run seeders, if any.

Run php artisan serve

## DEPLOYMENT - ANSIBLE

The deployment part will allow you to automatically configure the API by installing all dependencies, packages, the database and also a version higher than 8.0 of PHP thanks to ANSIBLE

#### Requirement

To deploy the project you need 2 (virtual) machines with a Debian 11 (Bullseye) version otherwise, the ansible script will return a version error.

On the machine that will receive the deployment, it is necessary that:

    1° : sudo need to be installed
            apt install sudo

    2° : Your user needs all access 
            sudo visudo

         and add this line : 
            <YourUser>  ALL=(ALL:ALL) ALL

On the machine that will launch the ansible script :

    1° : Copy the ansible folder at the root of your machine (~)
    2° : Change the hosts.example to hosts and change the variables on it

#### Launch the deployment

If all requirement are OK you can run this command:

``` bash
playbook-ansible playbook.yml -i hosts
```
