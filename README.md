# Glaber
sudo su
apt update
apt upgrade

# Настройка времени
timedatectl set-timezone Europe/Kyiv
nano /etc/systemd/timesyncd.conf
NTP=0.ua.pool.ntp.org

service systemd-timesyncd restart
timedatectl timesync-status
date

# Установка
wget https://repo.zabbix.com/zabbix/5.4/ubuntu/pool/main/z/zabbix-release/zabbix-release_5.4-1+ubuntu20.04_all.deb
dpkg -i zabbix-release_5.4-1+ubuntu20.04_all.deb

apt-get update && apt-get install wget gnupg2 lsb-release apt-transport-https -y 
wget --quiet -O - https://glaber.io/repo/key/repo.gpg | apt-key add -

echo "deb [arch=amd64] https://glaber.io/repo/ubuntu $(lsb_release -sc) main" > /etc/apt/sources.list.d/glaber.list
apt-get update

apt install glaber-server-pgsql glaber-nginx-conf glaber-frontend-php php7.4-pgsql zabbix-sql-scripts zabbix-agent postgresql

cd /
sudo -u postgres createuser --pwprompt zabbix
Enter password for new role: <password>
Enter it again: <password>

sudo -u postgres createdb -O zabbix zabbix

zcat /usr/share/doc/zabbix-server-pgsql/create.sql.gz | sudo -u zabbix psql zabbix

# Конфигурим настройки сервера
nano /etc/zabbix/nginx.conf
server {
        listen          80;
        server_name     <server IP-address>;

unlink /etc/nginx/sites-enabled/default

# Clickhouse
apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 8919F6BD2B48D754

echo "deb https://packages.clickhouse.com/deb stable main" | sudo tee \
    /etc/apt/sources.list.d/clickhouse.list

apt update
apt install clickhouse-server clickhouse-client
Enter password for default user:<password>

# Тюнинг Clickhouse
mkdir /etc/clickhouse-server/config.d/
cd /etc/clickhouse-server/config.d/
wget https://github.com/s3wayProject/Glaber/raw/main/etc/clickhouse-server/conf.d/disable_empty_password.xml
wget https://github.com/s3wayProject/Glaber/raw/main/etc/clickhouse-server/conf.d/disable_metric_logs.xml
wget https://github.com/s3wayProject/Glaber/raw/main/etc/clickhouse-server/conf.d/disable_query_thread_log.xml
wget https://github.com/s3wayProject/Glaber/raw/main/etc/clickhouse-server/conf.d/metrika.xml
wget https://github.com/s3wayProject/Glaber/raw/main/etc/clickhouse-server/conf.d/part_log.xml
wget https://github.com/s3wayProject/Glaber/raw/main/etc/clickhouse-server/conf.d/query_log.xml
wget https://github.com/s3wayProject/Glaber/raw/main/etc/clickhouse-server/conf.d/enable_on_disk_operations.xml


# Настройка БД Clickhouse для Glaber
cd /home/user/ 
wget https://github.com/s3wayProject/Glaber/raw/main/home/user/history.sql
clickhouse-client --password --multiquery < history.sql

# Настройка Glaber (загружаем файл и корректируем при необходимости)
cd /etc/zabbix/
wget https://gitlab.com/

# Дополнительные права на запуск
chmod +s /usr/sbin/glbmap
mkdir /tmp/vcdump/
chmod 777 /tmp/vcdump/

# Перезапускаем сервисы и добавляем их в автозагрузку
service clickhouse-server restart
service postgresql restart
service nginx restart
service php7.4-fpm restart
service zabbix-server restart
service zabbix-agent restart

# Добавляем все сервисы в автозапуск
systemctl enable clickhouse-server postgresql nginx php7.4-fpm zabbix-server zabbix-agent

# Заходим на веб-морду и следуем иснтрукциям
http://127.0.0.1:43048/setup.php

# После чего донастраиваем
# Настройка фронтена Glaber (загружаем файл и корректируем при необходимости)
cd etc/zabbix/web/
wget https://github.com/s3wayProject/Glaber/raw/main/etc/zabbix/web/zabbix.conf.php

# Добавим файл
cd /etc/php/7.4/fpm/conf.d/
wget https://github.com/s3wayProject/Glaber/raw/main/etc/php/7.4/fpm/conf.d/99-zabbix.ini
