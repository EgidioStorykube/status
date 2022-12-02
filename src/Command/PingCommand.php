<?php

namespace App\Command;

use DateTime;
use App\Entity\IpStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:ping',
    description: 'Ping command',
)]
class PingCommand extends Command
{
    private $entityManager;
    private $client;

    protected function configure(): void
    {
        $this
            ->setName('app:ping')
            ->setDescription('Ping command');
        ;
    }

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $client){
        $this->entityManager=$entityManager;
        $this->client = $client;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $hosts=$this->entityManager->getRepository(IpStatus::class)->findAll();

        foreach($hosts as $host){
            $hostname=$host->getIp();

            $response = $this->client->request(
                'GET',
                $hostname
            );

            $host->setHttpResponse($response->getStatusCode());

            if ($response->getStatusCode()==200){
                $host->setStatus(true);
                $host->setLastPing(new DateTime());
                $output->writeln($hostname . ' Successful responses');
            }
            else{
                $host->setStatus(false);
                $host->setLastPing(new DateTime());
                $output->writeln($hostname . ' Bad responses whit code:' . $response);
            }
            $this->entityManager->persist($host);

            $this->entityManager->flush();
        }
                
        return Command::SUCCESS;
    }
}