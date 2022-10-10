CREATE DATABASE cafedb;

USE cafedb;

CREATE TABLE user (
                    user_id INT AUTO_INCREMENT PRIMARY KEY, 
                    user_name VARCHAR(100) UNIQUE NOT NULL, 
                    email VARCHAR(50) UNIQUE NOT NULL, 
                    user_password VARCHAR(200) NOT NULL, 
                    room VARCHAR(20) NOT NULL, 
                    ext INT NOT NULL, 
                    user_type VARCHAR(10) NOT NULL, 
                    profile_pic VARCHAR(200)
                );

CREATE TABLE category (
                        category_id INT AUTO_INCREMENT PRIMARY KEY, 
                        category_name VARCHAR(50) UNIQUE NOT NULL
                        );

CREATE TABLE product (
                        product_id INT AUTO_INCREMENT PRIMARY KEY, 
                        product_name VARCHAR(50) UNIQUE NOT NULL, 
                        product_img VARCHAR(200), 
                        price FLOAT NOT NULL, 
                        available VARCHAR(20) NOT NULL, 
                        category_id INT NOT NULL, 
                        FOREIGN KEY (category_id) 
                        REFERENCES category(category_id)
                    ) ON DELETE CASCADE;

INSERT INTO user (user_name, email, user_password, room, ext, user_type) 
VALUES ("Brindha Durasisamy", "dbrindh94@gmail.com", "br1234", "123", "4567", "admin");

INSERT INTO user (user_name, email, user_password, room, ext, user_type) 
VALUES ("Johnny Depp", "johnny@gmail.com", "br1234", "123", "4567", "admin");

INSERT INTO user (user_name, email, user_password, room, ext, user_type) 
VALUES ("Tom Holland", "tom@gmail.com", "br1234", "123", "4567", "admin");



INSERT INTO category (category_name) VALUES ("Hot Drinks");
INSERT INTO category (category_name) VALUES ("Cold Drinks");

INSERT INTO product (product_name, product_img, available, price, category_id) 
VALUES ( "Espresso", "../imag/Espresso.png", "available", 5.5, 1);

INSERT INTO product (product_name, product_img, available, price, category_id) 
VALUES ( "Double Espresso", "../imag/Double Espresso.png", "available", 5.5, 1);

INSERT INTO product (product_name, product_img, available, price, category_id) 
VALUES ( "Cappuccino", "../imag/Cappuccino.png", "unavailable", 5.5, 1);

INSERT INTO product (product_name, product_img, available, price, category_id) 
VALUES ( "Mocha", "../imag/Mocha.png", "available", 5.5, 1);
