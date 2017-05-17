<?php

namespace AppBundle\Model;

/**
 * Class Merchants
 * @package AppBundle\Model
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
final class Merchants
{
    static public function getData()
    {
        return [
            'Fnac'            => '753159',
            'Rue du commerce' => '456789',
            'Darty'           => '321987',
            'CDiscount'       => '423951',
        ];
    }
}
