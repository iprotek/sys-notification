<?php

namespace iProtek\SysNotification\Helpers; 
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GitHelper
{
    
    public static function runGitCommand(string $command): string {
        // Create a new Process instance with the given command

        $args = array_filter(explode(' ', $command));

        $process = new Process($args);
    
        // Run the process
        $process->run();
    
        // Check if the process was successful
        if (!$process->isSuccessful()) {
            // Throw an exception if the process failed
            throw new ProcessFailedException($process);
        }
    
        // Return the output of the command
        return $process->getOutput();
    }

}