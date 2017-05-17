<?php

namespace AppBundle\Feed;

use AppBundle\AppBundle;
use AppBundle\Entity\Merchant;
use AppBundle\Entity\Offer;
use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Reader
 * @package AppBundle\Feed
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Reader
{
    /**
     * @var EntityManagerInterface
     */
    private $em;


    /**
     * Constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Reads the merchant's feed and creates or update the resulting offers.
     *
     * @param Merchant $merchant
     *
     * @return array
     */
    public function read(Merchant $merchant)
    {
        // $count = 0;

        // Lire le flux de données du marchand

        $content = file_get_contents($merchant->getfeedUrl());

        // Convertir les données JSON en tableau
        $array = json_decode($content, true);

        // Pour chaque couple de données "code ean / prix"
        foreach ($array as $data) {
            $eanCode = $data['ean_code'];
            $price= $data['price'];

            // Trouver le produit correspondant

            $product = $this->em
                ->getRepository('AppBundle:Product')
                ->findOneBy(['eanCode' => $eanCode]);

            //sinon passer à l'itération suivante
            if (!$product) {
                continue;
            }
        // Trouver l'offre correspondant à ce produit et ce marchand
            $offer = $this->em
                ->getRepository('AppBundle:Offer')
                ->findOneBy(['product' => $product, 'merchant' => $merchant]);

            if (!$offer) {
                // Sinon créer l'offre
                $offer = new Offer();

                $offer->setMerchant($merchant);
                $offer->setProduct($product);
                $offer->setPrice($price);
                $offer->setUpdatedAt(new \datetime);

            }
            // Mettre à jour le prix et la date de mise à jour de l'offre
            else {
                $offer->setPrice($price);
                $offer->setUpdatedAt(new \datetime);

            };

            $this->em->persist($offer);
            $this->em->flush();



            $output->writeln(count($offer));
        };








        // Enregistrer l'offre et incrémenter le compteur d'offres

        // Renvoyer le nombre d'offres

    }





}