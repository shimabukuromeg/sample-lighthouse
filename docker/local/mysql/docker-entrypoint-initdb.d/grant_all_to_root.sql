--  デフォルトだとアクセス元に制限がかかっているため、制限を解除する
GRANT ALL ON *.* TO 'root'@'%';
FLUSH PRIVILEGES ;
