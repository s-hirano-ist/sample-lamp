FROM php:8.2-apache
# enable MySQL PDO Extension
    # https://qiita.com/shuta_takeuchi/items/fb4c632d016555c4e2bc
RUN apt-get update && apt-get -y upgrade \
	&& docker-php-ext-install pdo_mysql

# add server name to apache2 settings
    # https://qiita.com/sachiko-kame/items/a6deebbad207d627b598
RUN echo "ServerName localhost" | tee /etc/apache2/conf-available/fqdn.conf
RUN a2enconf fqdn
