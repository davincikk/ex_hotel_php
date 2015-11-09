
mysql -u root  < dropdatabase.txt
mysql -u root  < dump.sql

phpunit --include-path /var/www/kannan/php/hotel_ex1/ex_hotel_php/lib --coverage-html /var/www/kannan/php/hotel_ex1/ex_hotel_php/tests/reports/ --test-suffix Test.php /var/www/kannan/php/hotel_ex1/ex_hotel_php/tests/

