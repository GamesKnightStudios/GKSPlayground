### Contents
* [Overview](Setting-Up-The-Development-Environment#overview)
* [Linux Instructions](Setting-Up-The-Development-Environment#linux-instructions)
* [Windows Instructions](Setting-Up-The-Development-Environment#windows-instructions)
* [Mac Instructions](Setting-Up-The-Development-Environment#mac-instructions)

***
### Overview
***
GKS Playground is a web app that uses on [PHP5](http://php.net/). In order to develop you'll need to setup a server configuration that to support this.

***
### Linux Instructions
***
Setup was done on ubuntu but should be similar for other Debian based systems

Install PHP5:
`sudo apt-get install php5`

check out project from git:

`git clone https://github.com/GamesKnightStudios/GKSPlayground.git`

To run the php built in server on port 8080 (you can use whatever port you please): `/usr/bin/php -S 0.0.0.0:8080 -t GKSPlayground`

***
### Windows Instructions
***
The instructions assume you are using Windows 10 x64, some modification might be needed if you are using a different OS or 32-bit. 

Create a folder to store your local server (Recommend to use 'C:\localserver')

### Setup Apache
Download Apache from [here](https://www.apachelounge.com/download/)

Extract Apache to your server folder.

Set SVRROOT in 'C:\localserver\Apache24\conf\httpd.conf' file (line 37):
```
Define SRVROOT "C:/localserver/Apache24"
```

Setup the Apache Windows service by running the following command:
```
cd C:\localserver\Apache24\bin
httpd -k install
```

After installing the service, you need to start the service. You can manage it from the windows service program. You need to open the “RUN” box using “Windows + R” key where you can type “services.msc” command to open the Service” program. Open the program and search Apache. Right-click and select 'Start' to start the service.

In your web browser type 'locahost' and hit enter. If working this should bring up a webpage that says 'It works!'.

### Setup PHP
Down PHP 5 from [here](https://windows.php.net/downloads/releases/archives/). Recommend using v5.6.9.

Extract PHP to your server folder. 

Rename php-ini-development.ini to php.ini.

Add PHP in system environment variable using “setx path” command at command prompt.
```
setx path "%PATH%, C:\localserver\php-5.6.9" /M
```

Append to the end of 'C:\localserver\Apache24\conf\httpd.conf' the following snippet:
```
PHPIniDir "C:\localserver\php-5.6.9"
AddHandler application/x-httpd-php .php
LoadModule php5_module "C:\localserver\php-5.6.9/php5apache2_4.dll"
```

Create a PHP file name 'phpinfo.php' in C:\Apache24\htdocs with the following contents:
``` php
<?php

// Show all information, defaults to INFO_ALL
phpinfo();

?>
```

In the PHP folder copy the 'php.ini-development' file and rename it to 'pho.ini'.

Set the extension_dir in this file to the absolute path to php ext folder (line 736):
```
extension_dir = "C:/Code/GameKnightsStudio/Googulator/localserver/php-5.6.9/ext/"
```
Un-comment extension modules for curl, MySQL and openSSL (line 893):
```
extension=php_openssl.dll
```

Copy libeay32.dll, libssh2.dll, and ssleay32.dll files from PHP folder to the Apache/bin folder.

Restart the “Apache2.4” service.

In your web browser type 'locahost/phpinfo.php' and hit enter. If working this should bring up a webpage with PHP information.

Check extension modules are loaded correctly by looking for 'OpenSSL support' to be enabled. 

***
### Mac Instructions
***
_Coming Soon_
***