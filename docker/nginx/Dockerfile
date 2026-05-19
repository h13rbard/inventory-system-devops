FROM nginx:stable-alpine

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www

COPY . /var/www

EXPOSE 80
