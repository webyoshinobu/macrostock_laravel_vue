# FROM nginx:1.18-alpine
FROM 923613491438.dkr.ecr.ap-northeast-1.amazonaws.com/macrostock_nginx:v_0.1

ENV TZ=UTC

# nginx config file
COPY ./docker/nginx/*.conf /etc/nginx/conf.d/

WORKDIR /var/www/html