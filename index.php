<?php
	echo "hello world";
?>

<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Punkty;
use App\Entity\WartoscPrzeliczona;

class PrzeliczPunktyCommand extends Command
{
    protected static $defaultName = 'app:przelicz-punkty';
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Przelicza punkty klientów i zapisuje do tabeli wartosc_przeliczona.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $punktyRepository = $this->entityManager->getRepository(Punkty::class);
        $wartoscPrzeliczonaRepository = $this->entityManager->getRepository(WartoscPrzeliczona::class);

        $punktyList = $punktyRepository->findAll();

        foreach ($punktyList as $punkty) {
            $clientId = $punkty->getClientId(); // Zakładając, że klient ma ID
            $points = $punkty->getPoints();
            $przeliczonaWartosc = $points * 2;

            // Dodaj przeliczoną wartość do tabeli 'wartosc_przeliczona'
            $wartoscPrzeliczona = new WartoscPrzeliczona();
            $wartoscPrzeliczona->setClientId($clientId);
            $wartoscPrzeliczona->setCash($przeliczonaWartosc);

            $this->entityManager->persist($wartoscPrzeliczona);
            
            // Zeruj punkty klienta
            $punkty->setPoints(0);
            $this->entityManager->persist($punkty);
        }

        $this->entityManager->flush();

        $output->writeln('Operacja przeliczenia punktów zakończona pomyślnie.');

        return Command::SUCCESS;
    }
}
