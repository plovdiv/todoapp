## Development environment setup

**1. General information**

The application uses Laravel framework, Bootstrap and is dependent on external libraries and tools. To set-up the a development environment please follow the steps below, but also search online for solutions to specific problems related to the setup. 


**2. Requirements**

	a. PHP version 7.0 and above with the following modules
		i. php7.0-xml
		ii. php-sqlite3
		
	b. MYSQL version 5.6 and above
	
	c. Apache version 2.4 and above
	
 	d. Composer version 1.4 and above installed globally (get from https://getcomposer.org/)
	
	e. Nodejs version 6.11 and above (get from https://nodejs.org/en/ or your OS repository)
	
	f. Npm version 4.2 and above (get from https://www.npmjs.com/ or your OS repository)
	
	g. Yarn version 0.24.5 and above (get fromhttps://yarnpkg.com/ )
	
	h. SQLite3 with php module php-sqlite3 used for in-memory database testing
	
**3. Clone the repository from https://github.com/plovdiv/todoapp.git**
```
$ git clone https://github.com/plovdiv/todoapp.git todoapp
```

**4. Through the other part of this guide it is assumed that the code is in /var/www/todoapp folder and it is the
current directory to execute the command**
```
$ cd /var/www/todoapp
```

**5. Change all files and folder group ownership to the apache user www-data (may differ based on the setup)**
```
$ sudo chown -R :www-data .
```

**6. Make these application folders writable by the apache user**
```
$ chmod g+w bootstrap/cache storage
```

**7. Fetch project dependencies with composer**
```
$ composer install
```

**8. Fetch JavaScript dependencies**
```
$ yarn install
```

**9. Create local environment file .env from the provided .env.example**
```
$ cp .env.example .env
```

**10. Generate application key**
```
$ php artisan key:generate
```

**11. Create the application database using your preffered tool**
```
$ mysqladmin -u root -p create todo
```

12. Migrate and seed the database
```
$ php artisan migrate --seed
```

**13. At this point the application is ready for development. You should be able to run**
```
$ php artisan serve
```
**and the application should be accessible via http://127.0.0.1:8000 . If there are errors fix them and proceed with the
next steps**

**14. Create virtual host todoapp.local on your local machine. Here is an example virtual host file**
```
<VirtualHost *:80>
    ServerName todoapp.local
    DocumentRoot /var/www/todoapp/public/
    <Directory /var/www/todoapp/public/>
        AllowOverride All
    </Directory>
    ErrorLog ${APACHE_LOG_DIR}/todoapp-error.log
    CustomLog ${APACHE_LOG_DIR}/todoapp-access.log combined
</VirtualHost>
```

**15. Add the host in /etc/hosts, restart apache service and the application should be available at http://todoapp.local/**

**16. Build js/css for development**
```
$ npm run watch
```
**to monitor file changes and live reload with the help of browsersync ( https://www.browsersync.io/ )**

**17. Useful information**

*Run test
```
$ php vendor/bin/phpunit
```

*build js/css for development
```
$ npm run dev
```

*build js/css for production
```
$ npm run prod
```

*start file watcher for development
```
$ npm run watch
```

*update Module auto-completion. More info https://github.com/barryvdh/laravel-ide-helper
```
$ php artisan ide-helper:models -RW
```
    