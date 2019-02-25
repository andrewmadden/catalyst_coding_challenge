<?php 
declare(strict_types=1);

namespace amadden;

$shortopts = "u:p:h:";
$longopts = [
    "file:",
    "create_table",
    "dry_run",
    "help",
];

print_r(getopt($shortopts, $longopts));