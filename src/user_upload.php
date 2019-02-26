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

$shortopts = "u:p:h:";
$longopts = [
    "file:",
    "create_table",
    "dry_run",
    "help",
];

$errorMessage = "error: type --help for more information\n";

$fileNotFoundMessage = "error: file not found. type --help for more information\n";

$helpMessage = "help text\n";

$options = getopt($shortopts, $longopts);

// if help option is used, show help menu and abort script
if (array_key_exists("help",$options)) {
    echo $helpMessage;
    exit;
}

// if valid options are not included, show error message and abort script
// it is assumed that even if the create_table flag is included, an accurate filename is still included.
$requiredKeys = array_flip(["file","u","p","h"]);
// This checks whether all required options are present in the $options array
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

print_r($users);