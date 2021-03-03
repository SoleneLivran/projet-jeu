# GWITH - Game Where I'm The Hero

This repository is the back-end part of our end-of-cursus project with O'Clock School.<br>
The front-end repository can be found <a href="https://github.com/SoleneLivran/projet-game-front">here<a>.<br>
More info and YouTube presentation of the project can be found <a href="https://solenelivran.github.io/gwith.html">here<a> (french).

---

## Requirements

- PHP 7.2+
- MySQL/MariaDB/Postgres
- Composer

## Installation 

### Step 1 : Clone
Clone project

### Step 2 : Install dependencies

```sh
$ composer install
```

### Step 3 : Project configuration
```sh
$ cp .env .env.local
```
Then modify .env.local with your configuration
(DATABASE_URL etc...)

### Step 4 : Database

Create database if necessary :

```sh
$ bin/console doctrine:database:create
```

Then, load migrations :

```sh
$ bin/console doctrine:migrations:migrate
```

Finally, load fixtures :

```sh
$ bin/console hautelook:fixtures:load
```

### Step 5 : Run web server

```sh
$ symfony serve
```

**OR**

```sh
$ php -S localhost:8080 -t public
```

### Step 6 : Generate JWT key pair

```sh
$ php bin/console lexik:jwt:generate-keypair
```
and update .env.local JWT_PASSPHRASE with chosen password
