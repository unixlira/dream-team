CREATE DATABASE IF NOT EXISTS `dream_team`;
CREATE USER 'unixlira'@'%' IDENTIFIED BY 'secret';
GRANT ALL ON `dream_team`.* TO 'unixlira'@'%' IDENTIFIED BY 'secret';
FLUSH PRIVILEGES;
