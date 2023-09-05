# Sample PHP Project

## 💻 Tech Stack

**Language** - [PHP 7.2](https://www.php.net/)  
**Web server** - [Apache httpd](https://httpd.apache.org/)  
**Database** - [MySQL 5.7](https://www.mysql.com/)  
**Formatter** - [intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client)  
**Dependency Manager** - [Composer](https://getcomposer.org/)

## 🧞 Initial Setups

1. Git clone

```bash
git clone https://github.com/s-hirano-ist/php_sample
```

2. Install composer

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

REF: https://getcomposer.org/download/

3. Install packages

```bash
composer install
```

4. Set .env files. Samples are shown on .env.sample files.

```bash
touch .env
touch html/.env
```

5. Docker compose up

```bash
docker compose up --build -d
```

## 👌 Command Log

```bash
touch .env # set envs
docker compose up --build -d
docker exec -it mysql bash
mysql -u root -p -P 3306

cd html
mkdir staff
mkdir product
cd product 
mkdir image
sudo chmod -R 777 image
```

```sql
use sample-db;
CREATE TABLE mst_staff (
code INT PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(15),
password VARCHAR(32)
);

INSERT INTO mst_staff (name,password) VALUES ("Taro Nippon", "sample-password");

CREATE TABLE mst_product (
code INT PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(30),
price INT,
image_path VARCHAR(30)
);

CREATE TABLE sales (
code INT PRIMARY KEY AUTO_INCREMENT,
date TIMESTAMP,
code_member INT,
name VARCHAR(15),
email VARCHAR(50),
zipcode VARCHAR(7),
address VARCHAR(50),
tel VARCHAR(13)
);

CREATE TABLE sales_detail (
code INT PRIMARY KEY AUTO_INCREMENT,
code_sales INT,
code_product INT,
price INT,
quantity INT
);

CREATE TABLE member (
code INT PRIMARY KEY AUTO_INCREMENT,
date TIMESTAMP,
password VARCHAR(32),
name VARCHAR(15),
email VARCHAR(50),
zipcode VARCHAR(7),
address VARCHAR(50),
tel VARCHAR(13),
sex INT,
birthyear INT
);
```
