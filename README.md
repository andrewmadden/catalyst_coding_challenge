The following script is supported on php 7+ and postgresql 9.5+.

After copying this script to the desired location, you will need to make the script executable. 
Navigate to the same directory the script is in. 
Use `chmod -x ./user_upload.php` to change the permissions of the script to make it executable.

## Including dependencies with composer

Note: PHP must be installed in order to be able to install *composer*.

To add the dependencies to the project first navigate to the project root folder. 

If you do not have composer installed globally, you can install it globally or locally. 

### Global install

For Ubuntu 16.04:
```
sudo apt install composer
```

### Local install

For Ubuntu 16.04:

Use the following commands to install composer.
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

See https://getcomposer.org/download/ for more details.

### Installing the dependencies

To download the dependencies type:
```
composer update
```
This will download all dependencies included in the composer.json file. 

You may also have to update the autoload files. 
If locally installed use the command:
```
php composer.phar du
```
If globally installed use the command:
```
composer du
```

## Accessing a PostgreSQL database

In order for the script to access a postgresql database, please ensure that your php includes the required functions. Use the terminal command: 
```
sudo apt install php7.0-pgsql
```
Note that if you use a different version of php, you may need to reflect that in the command.

## Data File

The input CSV file is assumed to have a *header row* that contains the field name of each column. For example:
```
name, surname, email
andrew, john, andrewj@test.com
sarah, jane, sj@test.com
```

## Error cases

Do we need to check for an internet connection?
How do we handle a timeout error for the database insertion?
How to check if table exists?

## All possible valid options for the command

* php user_upload.php --help
* php user_upload.php -u user -p password -h host --create_table 
* php user_upload.php --file filename -u user -p password -h host --dry_run 
* php user_upload.php --file filename -u user -p password -h host 
* any other entry, just show help message

