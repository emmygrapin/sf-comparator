<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FeedCommand
 * @package AppBundle\Command
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class FeedCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:feed')
            ->addArgument('merchantCode', InputArgument::REQUIRED, 'The merchant code')
            ->setDescription('Reads the given merchant\'s data feed and create or updates offers.')
            ->setHelp(<<<EOT
La commande app:feed permet de récupérer les offres des sites marchands affiliés d'après leur flux de données :

    Ex: php app/console app:feed 123456 
EOT
);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Récupérer le service "Feed Reader"

        $reader =$this->getContainer()->get('app.feed.reader');

        // Récupérer le service "Doctrine Entity Manager"
        $merchantCode = $input->getArgument('merchantCode');

        //Trouver le marchand d'après le code passé en argument de la commande
        $merchant = $this->getContainer()
            ->get('doctrine')
            ->getRepository('AppBundle:Merchant')
            ->findOneBy(['code'=> $merchantCode]);

        $reader->read($merchant);

        // Utiliser le service "Feed Reader" pour récupérer les offres du flux du marchand

        // Afficher (dans le terminal) le nombre d'offres créées ou mises à jour.
    }
}
