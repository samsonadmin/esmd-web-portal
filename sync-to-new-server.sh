#!/bin/bash
RSYNC_PASSWORD="Ca&%2364";

echo $RSYNC_PASSWORD

echo \n\n

echo aisafety.carryai.co

# rsync -avzr -e ssh /home/samsonli/yolo-web/public/server/php/files/2023 caiadmin@47.242.166.201:/var/www/html/yolo-web/public/server/php/files --exclude="lost+found" --progress


# rsync -zvra /home/samsonli/yolo-web/public/server/php/files/2023 caiadmin@47.242.166.201:/var/www/html/yolo-web/public/server/php/files --exclude="lost+found" --progress

# rsync -zvra /home/samsonli/yolo-web/public/server/php/files/2024 caiadmin@47.242.166.201:/var/www/html/yolo-web/public/server/php/files --exclude="lost+found" --progress

# rsync -zvra /home/samsonli/yolo-web/public caiadmin@47.242.166.201:/var/www/html/yolo-web --exclude="lost+found" --exclude="ting-kok-road-sps-test.zip" --exclude="Ting-Kok-Road-SPS-Test" --exclude="2022" --progress

## rsync -zvra /etc/nginx/sites-enabled/default caiadmin@47.242.166.201:/home/caiadmin --exclude="lost+found" --progress

## rsync -zvra /etc/nginx/nginx.conf caiadmin@47.242.166.201:/home/caiadmin --exclude="lost+found" --progress