<?php 

// Installation script for laravel docker image
echo "starting installation \n";

EchoCommandDescription("Starting composer install:");
ExecuteCommand("echo y | composer install");

EchoCommandDescription("Starting Laravel database migration:");
ExecuteCommand("php artisan migrate");

EchoCommandDescription("Starting Laravel optimization:");
ExecuteCommand("php artisan optimize");

function EchoCommandDescription($echo) {
    echo "\n";
    echo $echo;
}

function ExecuteCommand($cmd) {
  
    echo "\n";

    // Storing output of exec
    $output = array();

    // Executing the command
    exec($cmd, $output);
    
    // Outputting the result of the command
    OutputCommandResult($output);
}

function OutputCommandResult($result) {

    // printing the output to terminal
    foreach($result as $line) {
        echo $line . "\n";
    }

}
