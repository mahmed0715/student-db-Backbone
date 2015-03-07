-Install xampp
--Directory can be: D:/xampp or C:/xampp
--Run as service: apache and mysql.

Copy paste the project folder to xampp/htdocs folder in hard disc where the xampp was installed.

Go to http://localhost

If error coming check to see if the apache and mysql running , check the xampp control panel.

On the first time we need to create database  named cellar from http://localhost/phpmyadmin (select databse cellar, then import the callar.sql file) 
Then import the cellar .sql from the project directory or from the backup directory

We are set to run the project.
There will be short cut runProject on desktop.
To get backup time to time: just double click on mysqlDbDump.bat located on project folder.
To see backup data go to D:/backupDataSql folder 
