<?php 

// Installation script for laravel docker image
echo "starting installation \n";

EchoCommandDescription("Starting composer install:");
ExecuteCommand("echo y | composer install");

// We need to make sure we have database up and running
// Just setting error to be true and then changing if everything went ok
$error = true;

while($error) {

    $exceptionFound = false;

    EchoCommandDescription("Starting Laravel database migration:");
    $output = ExecuteCommand("php artisan migrate", false);

    // checking each line for errors
    foreach($output as $line) {
        // If we have error when trying to execute this, we will wait for database to be ready
        if(strpos($line, "PDOException", 0) > 0 && !$exceptionFound) {
            $exceptionFound = true;
        }
    }

    // We we did not find exeption lets move on
    if(!$exceptionFound) {
        $error = false;
        OutputCommandResult($output);
    } else {
        echo "could not connect to database, retrying in 5 seconds";
        sleep(5);
    }
}

EchoCommandDescription("Starting Laravel key generate:");
ExecuteCommand("php artisan key:generate");

EchoCommandDescription("Starting Laravel key generate:");
ExecuteCommand("php artisan key:generate");

EchoCommandDescription("Starting Laravel optimization:");
ExecuteCommand("php artisan optimize");

EchoCommandDescription("Starting Laravel route clear:");
ExecuteCommand("php artisan route:clear");

function EchoCommandDescription($echo) {
    echo "\n";
    echo $echo;
}

function ExecuteCommand($cmd, $printResult = true) {
  
    echo "\n";

    // Storing output of exec
    $output = array();

    // Executing the command
    exec($cmd, $output);
    
    if($printResult) {
        // Outputting the result of the command
        OutputCommandResult($output);
    }
    
    return $output;
}

function OutputCommandResult($result) {

    // printing the output to terminal
    foreach($result as $line) {
        echo $line . "\n";
    }

}
