mysqldump --complete-insert --no-create-info -u panadero --password=panadero --opt panaderos>$1
gzip $1
