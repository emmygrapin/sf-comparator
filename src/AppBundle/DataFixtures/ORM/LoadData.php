<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Merchant;
use AppBundle\Entity\Product;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Model\Merchants;
use AppBundle\Model\Products;

/**
 * Class LoadData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadData implements FixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach (Products::getData() as $designation => $eanCode) {
            $product = new Product();
            $product
                ->setDesignation($designation)
                ->setEanCode($eanCode);

            $manager->persist($product);
        }

        $url = 'http://127.0.0.1:8000/_feed/fake/%s_%s.json';

        foreach (Merchants::getData() as $name => $code) {
            $merchant = new Merchant();
            $merchant
                ->setName($name)
                ->setCode($code)
                ->setFeedUrl(sprintf($url, urlencode($name), $code));

            $manager->persist($merchant);
        }

        $manager->flush();
    }
}
