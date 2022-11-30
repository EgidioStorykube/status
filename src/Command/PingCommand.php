<?php

namespace App\Command;

use mysqli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:test',
    description: 'Test command',
)]
class PingCommand extends Command
{
    protected static $defaultName = 'app:test';
    protected function configure(): void
    {
        $this
            ->setName('app:test')
            ->setDescription('Test command');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $host="www.google.com";

        exec("ping -c 1 " . $host, $result, $status);//Status 0:Succesfull - 1: Unsuccesfull
        
        if ($status==0)
            $output->writeln($host. " is Online");
        else
            $output->writeln($host. " is Offline");
        
        return Command::SUCCESS;
    }
}
// $servername = "127.0.0.1:8080";
//         $username = "root";
//         $password = "root";
//         $dbname = "ip_status";

//         // Create connection
//         $conn = new mysqli($servername, $username, $password, $dbname);
//         // Check connection
//         if ($conn->connect_error) {
//             die("Connection failed: " . $conn->connect_error);
//         }

//         $sql = "SELECT ip FROM ip_status";
//         $result = $conn->query($sql);

//         foreach ($result as $ip){
            
//             exec("ping -3 1 $ip", $output, $status);

//             $ping_result=false;
            
//             if ($status ==0){
//                 $ping_result=true;
//             }
//             else {$ping_result=false;}

//             $sqlupdate = "UPDATE ip_status SET status='$ping_result' WHERE ip=$ip";
//             $update = $conn->query($sqlupdate);
//         }

//         $conn->close();