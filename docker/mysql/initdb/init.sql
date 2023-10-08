CREATE DATABASE IF NOT EXISTS `dream_team`;
CREATE USER 'unixlira'@'%' IDENTIFIED BY 'secret';
GRANT ALL PRIVILEGES ON dream_team.* TO 'unixlira'@'%' WITH GRANT OPTION;
SET PASSWORD FOR 'unixlira'@'%' = PASSWORD('secret');
FLUSH PRIVILEGES;