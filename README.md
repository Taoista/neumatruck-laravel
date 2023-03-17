<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://www.neumatruck.cl/img/logo.png" width="400" alt="Laravel Logo"></a></p>

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://laravelnews.s3.amazonaws.com/images/laravel-livewire.png" width="400" alt="Laravel Logo"></a></p>

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://d1.awsstatic.com/acs/characters/Logos/Docker-Logo_Horizontel_279x131.b8a5c41e56b77706656d61080f6a0217a3ba356d.png" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

##  Laravel 8 - VITE -LIVEWIRE
## Instalacion

Clona el repo

```bash
git clone git@github.com:Taoista/docker-laravel9.git
```
Entra al proyecto
```bash
cd docker-laravel9
```

## Uso
Despues descargar, ejecutar

```docker
docker-compose up -d
```
verifica el nombre del contenedor (lo puedes cambiar, deberias)

```bash
CONTAINER ID   IMAGE                 COMMAND                  CREATED          STATUS          PORTS
              NAMES
fde6aee803b5   neumatruck-backend    "docker-php-entrypoi…"   15 minutes ago   Up 15 minutes   9000/tcp
              neumatruck-backend
88d80af514c2   nginx:1.21.6-alpine   "/docker-entrypoint.…"   15 minutes ago   Up 15 minutes   0.0.0.0:8002->80/tcp   webserver-neumatruck
```
en este caso el container es 'backend', entra en la consola

```bash
docker-compose exec backend sh
```
ejecuta

```bash
composer install
```
```bash
npm install
```
```bash
cp .env.example .env
```
```bash
php artisan key:generate
```
si estas trabajando con xampp y/o largon, crea un usuario con los privilegios completos y en la configuracion de mysql agrega
```bash
bind-address=0.0.0.0
```

