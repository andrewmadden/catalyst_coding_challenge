# User Upload CLI Script

This project is a PHP script to be run in the terminal that will upload a list of 'users' from a CSV file to a PostgreSQL database. It was developed as a coding challenge for CatalystIT.

The following script is supported on php 7+ and postgresql 9.5+.

## How to use

The executable script is called `user_upload.php`. It is located in the src folder in the project. Once the files are copied onto your server/OS, navigate to the project root directory. You may need to set the script to be executable, first.
```
sudo chmod -x ./src/user_upload.php
```
To run the script, use the following command. You should first read the prerequisites to ensure your server/OS is set up correctly. 
```
php ./src/user_upload.php --help
```

## Prerequisites

### PHP

To run this script, you will need to have PHP version 7+ installed on your server/OS. 

To install PHP7.0 on Ubuntu 16.04, use the following commands:
```
sudo apt-get install python-software-properties
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install -y php7.0
```

### PHP PostgreSQL files

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

## Dependencies

* PHPUnit

The above dependencies are *not required* for the execution of user_upload.php. In order to run the existing unit tests or add your own, please follow the below instructions.

To add the dependencies to the project first navigate to the project root folder. 
If you do not have composer installed globally, you can install it globally or locally. 
Note: PHP must be installed in order to be able to install *composer*.

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

### Downloading the dependencies

To download the dependencies type:
```
composer update
```
This will download all dependencies included in the composer.json file. 

You may also have to update the autoload files.

Local install:
```
php composer.phar du
```
Global install:
```
composer du
```

## Running the Tests

Once you've installed the PHPUnit dependency, you can run the unit tests by typing the following command into the console.
```
php vendor/bin/phpunit
```
The test files are in the test/ directory. Look up https://phpunit.readthedocs.io/en/7.0/ for more information about configuring the project.