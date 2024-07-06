# Brainery - Website for online courses

This is an innovative e-learning platform meticulously designed to revolutionize the way knowledge is shared and acquired. We provide a seamless, user-friendly experience for both educators and students.

## System requirements
- PHP 8.2
- [Composer](https://getcomposer.org)
- [Docker & Docker compose](https://www.docker.com)

## How to install

Clone repository

```sh
git clone git@github.com:ivan-stoianov/brainery.git
cd brainery
```

Install project packages

```sh
composer install
```

Start docker containers with [laravel sail package](https://laravel.com/docs/11.x/sail).

```sh
./vendor/bin/sail up
```

Compile assets

```sh
./vendor/bin/sail npm run install
```

```sh
./vendor/bin/sail npm run dev
```