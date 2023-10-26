FROM postgres:9.2.23
# @see https://hub.docker.com/_/postgres?tab=tags&page=1&name=9.2 Tags disponíveis
# @see https://hub.docker.com/_/postgres Documentação

# Na DINFO: 9.2.24
LABEL maintainer="alexandre.trindade@uerj.br"

RUN localedef -i pt_BR -c -f UTF-8 -A /usr/share/locale/locale.alias pt_BR.UTF-8
ENV LANG pt_BR.utf8

# Database Configuration
COPY postgres/postgres.conf /etc/postgresql

# ----------------------------------------------------------------
# Configuração dos objetos e usuários
# ----------------------------------------------------------------
COPY postgres/*.sql /docker-entrypoint-initdb.d/


#RUN mkdir /docker-tmp
#COPY postgres/* /docker-tmp

# Scripts executados automaticamente na criação do container:
#export CAMINHO=/docker-tmp
#/usr/lib/postgresql/9.2/bin/psql --username $POSTGRES_USER --dbname $POSTGRES_DB < $CAMINHO/01-postgres_usuarios_e_roles.sql
#/usr/lib/postgresql/9.2/bin/psql --username $POSTGRES_USER --dbname $POSTGRES_DB < $CAMINHO/02-db_sgpg_2021-07-12.sql

# ----------------------------------------------------------------
# Informações adicionais
# ----------------------------------------------------------------
# Credenciais do banco
#
# Postgres (super usuário)
# USER	postgres
# SYBASE_PASSWORD	postgres
