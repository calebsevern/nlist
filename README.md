# nlist - experimental economics recruiting

###Dependencies

MySQL Native Driver

PHP's PEAR::Mail

PHP's PEAR::Net_SMTP

###Setup

Unzip and upload the project and navigate to the project's root directory in a browser. 

An admin account is created during installation - changing the default password value during user creation in setup.php is recommended.

nlist will serve an install page, unless you've copied over a conf.php file from a previous install. Regardless, ensure that your web user can write to conf.php.

Enter your database and SMTP information. The table you use does not need to exist - nlist will create one.

You will be redirected to a sign-in page if all went well.

###Scheduling reminder emails
We'd rather not ask for access under the webroot, so you will need to manually add php/send_reminders.php as an hourly cron task to enable automatic reminder emails. e.g., with crontab:

    25 0	* * *	user	php /var/www/html/projects/send_reminders.php
