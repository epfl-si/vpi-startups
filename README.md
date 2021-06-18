# vpi-startups

## Introduction

This site allows accredited users to manage EPFL startups.  
  
To see the content of the site, you need an EPFL Tequila account and to belong to the EPFL startups_read or/and startups_write group.  

If you belong to the startups_write group, you have the right to write and modify startups data. If you belong only to the startups_read group, you only have the right to see the homepage and the pages containing the graphs.  
  
The rights management is done by PHP sessions ( $_SESSION ), the connection to Tequila will create a PHP session variable and it will look for your groups to create another PHP session variable with the name of your group.  
  
It allows you to :  
  
* Add and modify startups
* Add and modify people 
* View graphs of the evolution of startups
* Export startup data in CSV format
* Import a CSV file to insert the data from this file into the startup table  
* Allows to see the logs of each user action (Example: If the user has made an import)  

## Server Deployment

Requirements to deploy this application:

* Linux server with :
    * Apache 2.4 server
    * PHP 7.4
    * MySQL server
    * (Optional) PHPMyAdmin (database management via a web interface)
  
Make a git clone on a directory of your server to have all the files of the website. 
  
To get the website root right, edit the file ``` /etc/httpd/conf/httpd.conf ``` and put for example: ```DocumentRoot "/var/www/html/project_startups" ``` instead of the default DocumentRoot. This allows the root of the website to be in the right place (where the PHP files are).  
  
For the database, take the file ```vpi_startup.sql``` which is in ```db/``` and put it into your MySQL server. You can do this with the mysqldump command. This file is a dump of the database structure.

Make sure you are connected to the EPFL network (on site or via VPN) so that it can wait for the Tequila server to take your information to access the website.

In order to allow .htacces to work in your server, you may have to enable ```mod_rewrite``` (if is not done) and change in Apache configuration :    
``` 
<Directory "/var/www/html/root_of_projet_startups/">
    [...]
    AllowOverride All
    [...]
</Directory>
```  
  
## Local Deployment  
  
Requirements to deploy localy this application :
* Docker
    * 3 containers (docker-compose.yml) :
        * webserver (DockerFile image)
        * db
        * phpmyadmin
  
Create a directory where you will put the application.  
Go to docker folder and build the DockerFile (he will build the webserver image) with ``` docker build . ``` .  
After that, execute the docker-compose.yml (he will build the 3 containers for the application) with ``` docker-compose up -d ```.  
Go to localhost:8888 to access to website and localhost:8081 to access database through phpmyadmin. 

