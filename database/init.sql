CREATE DATABASE elfsight;
CREATE DATABASE test;
CREATE USER 'symfony'@'%' IDENTIFIED BY 'symfonypass';
GRANT ALL PRIVILEGES ON elfsight.* TO 'symfony'@'%';
GRANT ALL PRIVILEGES ON test.* TO 'symfony'@'%';

USE elfsight;
