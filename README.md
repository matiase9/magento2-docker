# PRONOVIAS #

##Installation

* Clone repository
```
git clone git@github.com:matiase9/magento2-docker.git
```
* initialize project
```
docker-compose up -d
```
* Open PHP container
```
docker exec -it pronovias_php_1 /bin/bash
```
* Install composer dependencies:  
```
composer install 
```
* Set proper permissions for Magento console app:
```
chmod ug+x bin/magento
```
* Add rule /etc/hosts file: 
```
127.0.0.1	local.pronovias.com
```
* Install Magento
```
bin/magento setup:install --base-url=http://local.pronovias.com --db-host=mysql --db-name=test_db --db-user=root --db-password=root --backend-frontname=admin --admin-firstname=admin --admin-lastname=admin --admin-email=admin@admin.com --admin-user=admin --admin-password=admin123 --language=en_US --currency=USD --timezone=America/Chicago --use-rewrites=1 --cleanup-database
```

*_____________________*

##Conditions

Conventional DB values:
* Name: external_db
* User: root
* Password: root
* Table: employees



*_____________________*
* Set developer mode (If you are a developer)
```
bin/magento deploy:mode:set developer
```
* Run Upgrades apps/schemas/data 
```
bin/magento setup:upgrade
```