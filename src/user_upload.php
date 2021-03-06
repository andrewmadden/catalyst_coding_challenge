<?php
declare(strict_types=1);

/* 
There is a bug in PHP7 that prevents a shebang and strict types declaration from being used
together. It will trigger a compiler error. See https://bugs.php.net/bug.php?id=77561&edit=3.
*/

namespace amadden;

use Exception;

require_once 'csv_utility.php';
require_once 'user.php';
require_once 'database_connection.php';

// valid options
// included an option for the database name in case it does not match the user name
$shortopts = "u:p:h:d:";
$longopts = [
    "file:",
    "create_table",
    "dry_run",
    "help",
];

$helpMessage = "Usage: user_upload.php [options] [-u] <username> [-p] <password> [-h] <host> [--file] <filename>
    user_upload.php [options] [-u] <username> [-p] <password> [-h] <host> [-d] <dbname> [--file] <filename>
    user_upload.php [--create_table] [-u] <username> [-p] <password> [-h] <host> [-d] <dbname>
    
    -h <host>           PostgreSQL host
    -u <username>       PostgreSQL username
    -p <password>       PostgreSQL password
    -d <dbname>         PostgreSQL database name
    --file <filename>   The location of a CSV file with header row
    --dry_run           The script will execute without inserting any data in database
    --create_table      A PostgreSQL table 'users' will be created if it does not exist\n"; 

$errorMessage = "Error: Type --help for more information\n";

$fileNotFoundMessage = "Error: File not found. Type --help for more information\n";

$dryRunSuccessMessage = "Success: Dry run successful. File data extracted and connected to database.\n";

$createTableSuccessMessage = "Success: A table 'user' was created successfully.\n";

$usersInsertedSuccessMessage = "Success: New users inserted into database from file.\n";

$options = getopt($shortopts, $longopts);

// If help option is used, show help menu and abort script
if (array_key_exists("help",$options)) {
    echo $helpMessage;
    exit;
}

// If create_table option is used, attempt to connect to database and create user table then abort script
$requiredKeys = array_flip(["create_table","u","p","h"]);
// Checks whether all required options are present in the $options array
if (count(array_intersect_key($requiredKeys,$options)) == count($requiredKeys)) {
    if (array_key_exists("d",$options)) {
        $conn = new database_connection($options["u"], $options["p"], $options["h"], $options["d"]);        
    } else {
        $conn = new database_connection($options["u"], $options["p"], $options["h"]);
    }
    $conn->createUserTable();
    // success message
    echo $createTableSuccessMessage;
    exit;
}

// If valid options are not included for file and database, show error message and abort script
$requiredKeys = array_flip(["file","u","p","h"]);
// Checks whether all required options are present in the $options array
if (count(array_intersect_key($requiredKeys,$options)) != count($requiredKeys)) {
    echo $errorMessage;
    exit;
}

// Open CSV file and retrieve data
$fileName = $options["file"];
$fileOutput = file($fileName,1);

// If file not found, print error message and abort script
if ($fileOutput === false) {
    echo $fileNotFoundMessage;
    exit;
}

// Convert CSV data into associative arrays
$headers = csv_utility::transformCSVHeaderIntoArray($fileOutput[0]);
$userArray = [];
try {
    for ($i=1; $i<count($fileOutput); $i++) {
        $userArray[] = csv_utility::transformCSVRowIntoAssocArray($headers,$fileOutput[$i]);
    }
} catch (Exception $e) {
    echo "Caught exception: " . $e->getMessage() . "\n";
}

// Convert arrays into formatted user objects
$users = [];
foreach ($userArray as $userData) {
    $users[] = new user($userData["name"],$userData["surname"],$userData["email"]);
}

// Open connection to database
if (array_key_exists("d",$options)) {
    $conn = new database_connection($options["u"], $options["p"], $options["h"], $options["d"]);        
} else {
    $conn = new database_connection($options["u"], $options["p"], $options["h"]);
}
// In case the table 'user' does not yet exist
$conn->createUserTable();

// Get email of users already in database to ensure no duplicates are entered.
$existingEmails = $conn->getUserEmails();

// If the dry_run option is included, abort script with a success message
if (array_key_exists("dry_run",$options)) {
    echo $dryRunSuccessMessage;
    exit;
}

// Insert each user with a legal email into the database
foreach ($users as $user) {
    try {
        if ( $user->hasValidEmail() && (in_array($user->email, $existingEmails) == false) ) {
            $conn->insertUser($user);
            // Add email to list of current user emails
            $existingEmails[] = $user->email;
        } else {
            echo $user->email . " is not a legal email or already exists in database.\n";
        }
    } catch (Exception $e) {
        echo "Caught exception: " . $e->getMessage() . "\n";
    }
}

echo $usersInsertedSuccessMessage;