docker exec dafoh /bin/sh -c "cd /var/www/html/dafoh/wp-content && chown -R www-data:www-data uploads" && \
docker exec dafoh-server /bin/sh -c "cd /var/www/html/dafoh/wp-content"