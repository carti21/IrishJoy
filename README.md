# IrishJoy

<blockquote>
<p>Learn the Basics of PHP in a Real-World Project</p>
</blockquote>

![IrishJoy](https://raw.githubusercontent.com/ArditMustafaraj/IrishJoy/master/images/wiki_irishjoy.png)

Requirements

PHP >= 5.3 , MySql, HTML, CSS ( Javascript, Jquery )
IrishJoy is a PHP Projects for everyone who wants to put the hands in a real Projects. 
	- easy to understand ( good documentation )
	- Procedural Programming ( Not Object Oriented ) - you can understand the interacting way in PHP
	
Entities
* Images ( referred as post )
* Users
* Statistics
* Categories

All the configurations details are located in <code>/config.php</code>, such as paths, db credentials and cookies lifetime.

### How do you install it?

* Download the Project [( zip file )](https://github.com/ArditMustafaraj/pro/archive/master.zip)
* Import the ```/_mysql/irishjoy.sql``` Database in your PhpMyadmin 
* Change the config credentials: database name, user and password
* Open project: http://localhost/irishjoy

* Explore admin area by logging in at: localhost/irishjoy/login
		user: admin
		pass: admin

### What will you learn:

PHP and MySql communication
Create Insert Update Delete actions with query
$_GET and $_POST HTTP Requests
Basic PHP functions
HTML and CSS 




Config.php
```php
	define('MAIN_URL', 'http://localhost/pro/');

	/*
	Database Configurations
	*/
	define('HOST', 'localhost'); // The host you want to connect to.
	define('USER', 'root');      // The database username.
	define('PASSWORD', '');   // The database password.
	define('DATABASE', 'irishjoy');   // The database name.
```

### Conclusion


Happy coding!

