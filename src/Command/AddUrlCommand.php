<?php

namespace App\Command;

use DateTime;
use App\Entity\IpStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:addurl',
    description: 'Save a new url in database and send a request to url',
)]
class AddUrlCommand extends Command
{
    protected static $defaultName = 'app:addurl';
    private $entityManager;
    private $client;

    protected function configure(): void
    {
        $this
            ->addArgument('url', InputArgument::OPTIONAL, 'Write your url')
        ;
    }

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $client){
        $this->entityManager=$entityManager;
        $this->client = $client;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $url = $input->getArgument('url');

        if ($url) {
            $io->note(sprintf('Adding the url: %s', $url));
        }

        $response = $this->client->request(
            'GET',
            $url
        );

        $addUrl = new IpStatus;

        if ($response->getStatusCode()==200){
            $addUrl->setStatus(true);
            $addUrl->setLastPing(new DateTime());
            $output->writeln($url . ' Successful responses');
        }
        else{
            $addUrl->setStatus(false);
            $addUrl->setLastPing(new DateTime());
            $output->writeln($url . ' Bad responses whit code:' . $response);
        }

        $addUrl->setIp($url);
        $addUrl->setCreatedAt(new DateTime());
        $this->entityManager->persist($addUrl);

        $this->entityManager->flush();



        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
