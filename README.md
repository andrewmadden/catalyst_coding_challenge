The following script is supported on php 7+ and postgresql 9.5+.

After copying this script to the desired location, you will need to make the script executable. 
Navigate to the same directory the script is in. 
Use `chmod -x ./user_upload.php` to change the permissions of the script to make it executable.

## Data File

The input CSV file is assumed to have a *header row* that contains the field name of each column. 

## Error cases

Do we need to check for an internet connection?
How do we handle a timeout error for the database insertion?
How to check if table exists?

## All possible valid options for the command

* php --help user_upload.php
* php --file filename --dry_run user_upload.php
* php --create_table -u user -p password -h host user_upload.php
* php --file filename -u user -p password -h host user_upload.php
* any other entry, just show help message

