# FROM php:7.4.6-apache
FROM php:8.1.2-apache

LABEL maintainer="alexandre.trindade@uerj.br,fernando.ribeiro@uerj.br"

# Ajuste de timezone para Sao_Paulo
RUN rm /etc/localtime                                                       && \
    ln -s /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime              && \
    apt-get update --fix-missing && apt-get upgrade -y                      && \
# Permissões para as extensões
    chmod -R +rw /usr/local/lib/php/extensions/                             && \
# Instalação de drivers necessários
    docker-php-ext-install pdo                                              && \
    apt-get install -y zlib1g-dev libicu-dev g++                            && \
    docker-php-ext-install intl                                             && \
# Para conversão string para outros tipos de encoding
    apt-get install -y libonig-dev                                          && \
    docker-php-ext-install mbstring                                         && \
# Conexao com o Postgres (PGSQL)
    apt-get install -y libpq-dev                                            && \
    docker-php-ext-install pgsql pdo_pgsql                                  && \
# Conexao com o Sybase
    apt-get install -y unixodbc unixodbc-dev freetds-dev \
        freetds-bin tdsodbc                                                 && \
    docker-php-ext-configure pdo_dblib --with-libdir=/lib/x86_64-linux-gnu  && \
    docker-php-ext-install pdo_dblib                                        && \
    docker-php-ext-configure pdo_odbc --with-pdo-odbc=unixODBC,/usr         && \
    docker-php-ext-install pdo_odbc                                         && \
# Geração e uso de QR Code
    apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev      && \
    docker-php-ext-configure gd --enable-gd --with-jpeg --with-freetype     && \
    docker-php-ext-install gd                                               && \
# Reduz restrição de TLS devido ao erro 'dh key too small' ao conectar no banco antigo PostgreSQL
    sed -i 's/MinProtocol = TLSv1.2/MinProtocol = TLSv1.1/g' /etc/ssl/openssl.cnf && \
    sed -i 's/CipherString = DEFAULT@SECLEVEL=2/CipherString = DEFAULT@SECLEVEL=1/g' /etc/ssl/openssl.cnf && \
# configuração do mod_rewrite
    a2enmod rewrite                                                         && \
# Habilitando ssl
    a2enmod ssl && a2enmod socache_shmcb


# Configuração das variáveis de ambiente do APACHE
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV HTDOCS /var/www/html

# Limpeza da pasta
RUN rm -R $HTDOCS

# Cópia inicial para o HTDOCS
WORKDIR $HTDOCS

COPY webserver/odbcinst.ini /etc/odbcinst.ini

# Configuracao do Apache e PHP
COPY webserver/apache-config.conf /etc/apache2/sites-enabled/000-default.conf
# COPY webserver/apache-ssl-config.conf /etc/apache2/sites-enabled/default-ssl.conf
COPY webserver/apache2.conf /etc/apache2/apache2.conf

# Atenção: será usado o arquivo ".user.ini" para override do php.ini no ambiente da DGTI. Recomendável customizar lá
#COPY webserver/php.ini /usr/local/etc/php/php.ini

# Composer
RUN apt install git -y
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Allow
VOLUME $HTDOCS
RUN chgrp -R $APACHE_RUN_GROUP $HTDOCS && chmod -R g+rw $HTDOCS

# Expose apache.
EXPOSE 80
EXPOSE 443

# By default start up apache in the foreground, override with /bin/bash for interative.
CMD /usr/sbin/apache2ctl -D FOREGROUND
