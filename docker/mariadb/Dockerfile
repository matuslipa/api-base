ARG MARIADB_VERSION
FROM mariadb:${MARIADB_VERSION}

COPY default.cnf /etc/mysql/conf.d/default.cnf

RUN mkdir /var/log/mariadb

CMD ["mysqld"]

EXPOSE 3306
