#!/bin/bash
webhook_ip=$(ip -4 addr show eth0 | grep -oP "(?<=inet ).*(?=/)")

nginx_server=$(cat .env.nginx-server.example)
printf "$nginx_server\nLXC_CONTAINER_IP=$webhook_ip" > .env.nginx-server

####### generate ./nginx/default.conf
nginx_server=$(cat .env.nginx-server)
nginx_conf=$(cat ./nginx/unmap_configs/unmap-default.conf)
while IFS= read -ra line || [ -n "$line" ]; do
    key=$(echo "$line" | cut -d "=" -f 1)
    value=$(echo "$line" | cut -d "=" -f 2)
    nginx_conf=$(echo "$nginx_conf" | sed -e "s/\${$key}/$value/g");
done < .env.nginx-server
printf "$nginx_conf" > ./nginx/default.conf

cp .env.example .env && \
cp wp-config-example.php ../wp-config.php && \
cp wp-config-db-example.php ../wp-config-db.php && \
cd ../wp-content && \
mkdir uploads || true