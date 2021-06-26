-- テスト用のDBを作って権限を付与する
CREATE DATABASE IF NOT EXISTS `testdb`;
GRANT ALL ON `testdb`.* TO 'root'@'%';
FLUSH PRIVILEGES ;
