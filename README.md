# BlogNoFrameworkMVC
Create MVC blog without using any PHP Framework or CMS.

I created this project as a test task for Check24 in 2017.
This source code was accepted by Check24 and I received the job proposal.
Please use it for education only. I hope that the task would be unique for each developer. 
This project is interesting since it explains the architecture from scratch -- we use no Framework and no CMS.


### How to install:
* configure MySQL connection in config/application.config.php
* create a virtual host http://blognoframeworkmvc.test and set the default folder /public for it
* if links link /about cannot be found then ensure that /public/.htaccess or configure NGINX similar to /config/nginx.BlogNoFrameworkMVC.conf
* open the URL http://blognoframeworkmvc.test in your browser. If your MySQl is configured properly, then data/schema.mysql.sql should be executed automatically during the first run. 
 



### What can be improved in the future:
* use namespaces
* Add ORM since I use hardcoded mySQL commands
* Use translations
* Use database Migrations
* use PHP 7 -- this app was created using PHP5 acording to Check24 task requirement.
* What else?

Feel free to develop it and make pull requests on https://github.com/kaurov/BlogNoFrameworkMVC/
