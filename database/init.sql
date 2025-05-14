CREATE DATABASE elfsight;
CREATE DATABASE elfsight_test;
CREATE USER 'symfony'@'%' IDENTIFIED BY 'symfonypass';
GRANT ALL PRIVILEGES ON elfsight.* TO 'symfony'@'%';
GRANT ALL PRIVILEGES ON elfsight_test.* TO 'symfony'@'%';

USE elfsight;
