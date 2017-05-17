<?php

namespace AppBundle\Model;

/**
 * Class References
 * @package FeedBundle\Model
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
final class Products
{
    public static function getData()
    {
        return [
            'Apple iPhone 4'           => '1584679512348',
            'Apple iPhone 6'           => '8413765946812',
            'Apple iPhone 7'           => '8043715098064',
            'Apple iPad Air 2'         => '3027196845023',
            'Apple iPad Mini'          => '7940385061824',
            'Apple iPad Pro'           => '7051026984675',
            'Samsung Galaxy S4 Mini'   => '4560089635474',
            'Samsung Galaxy S5 Mini'   => '4506505467898',
            'Samsung Galaxy S6 Edge +' => '7895245668012',
            'Samsung Galaxy Tab 3'     => '9875412354120',
            'Samsung Galaxy Tab A'     => '1846798542318',
            'Samsung Galaxy Tab S2'    => '4569812646780',
        ];
    }
}
