RpiHeat
=======

Raspberry Pi Heating Remote Control and Monitoring

1. you have to setup a cron to run on reboot (@reboot) for /cron/refresh.sh
2. you may have to compile the C scripts from src folder with gcc -o output source.c -lwiringPi
3. modify etc/sudoers 
  www-data ALL = NOPASSWD: /var/www/hello
	www-data ALL = NOPASSWD: /var/www/test
	www-data ALL = NOPASSWD: /var/www/temperature
	www-data ALL = NOPASSWD: /var/www/temperature_body
