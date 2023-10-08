CREATE USER 'unixlira'@'%' IDENTIFIED BY 'secret';
GRANT ALL PRIVILEGES ON dream_team.* TO 'unixlira'@'%';
FLUSH PRIVILEGES;
