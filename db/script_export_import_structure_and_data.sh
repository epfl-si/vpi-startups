#!/bin/bash

# Script to export structure of database and add it in github
# Before execute this script, make sure if you are in the correct git branch and check if the tables or views don't have a difference between local and prod (Exemple : if startup local have for columns that startup prod, the import will fail)

# Backup of database without data and copy the file in local : https://gist.github.com/spalladino/6d981f7b33f6e0afe6bb
docker exec db /usr/bin/mysqldump --no-data -u root --password="my_secret_password" vpi_startup > vpi_startup_only_structure.sql

# Remove user in backup (root or testing), if you have another name for user, add another line with your name user
# For MAC : sed -i '' 's/DEFINER=`testing`@`%`//g' vpi_startup.sql
# For other users : sed -i -e 's/DEFINER=`testing`@`%`//g' vpi_startup.sql
# For more informations why go to : https://stackoverflow.com/questions/525592/find-and-replace-inside-a-text-file-from-a-bash-command
sed -i '' 's/DEFINER=`testing`@`%`//g' vpi_startup_only_structure.sql
sed -i '' 's/DEFINER=`root`@`%`//g' vpi_startup_only_structure.sql

# Add backup in Github (epfl-si/vpi-startups)
git add vpi_startup_only_structure.sql

# Commit added file
git commit -m "Update structure of database"

# Push commit
git push

#Enter in the server and make it to do the export
HOSTS="itsidevfsd0008.xaas.epfl.ch"
SCRIPT='git checkout main; git pull; cd db/; mysqldump --user="$USER_DB" --password="$SECRET" --databases vpi_startup -h mysql-scx.epfl.ch -P 33001 --no-create-info > vpi_startup_only_data.sql; mysql -u "$USER_DB" -h mysql-scx.epfl.ch -P 33001 --password="$SECRET" --database vpi_startup < vpi_startup_only_structure.sql; mysql -u "$USER_DB" -h mysql-scx.epfl.ch -P 33001 --password="$SECRET" --database vpi_startup < vpi_startup_only_data.sql;'
ssh -A ${HOSTS} "${SCRIPT}"
