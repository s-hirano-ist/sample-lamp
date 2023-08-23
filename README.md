# sample PHP project

## 技術スタック

|           |              |
|-----------|--------------|
|Language   | PHP 7.2      |
|Web server | Apache 2     |
|Database   | mysql 5.7    |
|Formatter  | intelephense |

## 実行

```bash
touch .env # set envs
docker compose up --build -d
docker exec -it mysql bash
mysql -u root -p -P 3306

cd html
mkdir staff
mkdir product
cd product 
mkdir gazou
sudo chmod -R 777 gazou
```

```sql
use sample-db;
CREATE TABLE mst_staff (
code INT PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(15),
password VARCHAR(32)
);

INSERT INTO mst_staff (name,password) VALUES ("Taro Okamoto", "sample-password");

CREATE TABLE mst_product (
code INT PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(30),
price INT,
gazou VARCHAR(30)
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

## 便利集

配列の中身を画面に出力。

```php
var_dump($cart);
exit();
```
