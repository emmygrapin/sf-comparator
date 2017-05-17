<?php

namespace AppBundle\Controller;

use AppBundle\Model\Products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FeedController
 * @package AppBundle\Controller
 */
class FeedController extends Controller
{
    /**
     * Feed fake action.
     *
     * @param string $merchantCode
     * @param string $format
     *
     * @return Response
     */
    public function fakeAction($merchantCode, $format)
    {
        $this->findMerchantByCode($merchantCode);

        $data = [];

        $eanCodes = array_values(Products::getData());

        shuffle($eanCodes);

        foreach ($eanCodes as $eanCode) {
            if (rand(0, 10) > 6) {
                continue;
            }

            $data[] = [
                'ean_code' => $eanCode,
                'price'    => rand(20000,40000) / 100,
            ];
        }

        if ($format === 'csv') {
            return $this->fakeCsvFeed($data);
        } elseif ($format === 'xml') {
            return $this->fakeXmlFeed($data);
        }

        return $this->fakeJsonFeed($data);
    }

    /**
     * Fakes the csv feed.
     *
     * @param array $data
     *
     * @return Response
     */
    private function fakeCsvFeed($data)
    {
        $content = '';

        foreach ($data as $d) {
            $content .= implode(';', array_values($d)) . PHP_EOL;
        }

        return new Response($content, 200, ['Content-Type' => 'text/plain']);
    }

    /**
     * Fakes the xml feed.
     *
     * @param array $data
     *
     * @return Response
     */
    private function fakeXmlFeed($data)
    {
        $dom = new \DOMDocument('1.0', 'utf-8');

        $offers = $dom->createElement('offers');

        foreach ($data as $d) {
            $offer = $dom->createElement('offer');
            $offer->setAttribute('ean_code', $d['ean_code']);
            $offer->setAttribute('price', $d['price']);

            $offers->appendChild($offer);
        }

        $dom->appendChild($offers);

        return new Response($dom->saveXML(), 200, ['Content-Type' => 'application/xml']);
    }

    /**
     * Fakes the json feed.
     *
     * @param array $data
     *
     * @return JsonResponse
     */
    private function fakeJsonFeed($data)
    {
        return new JsonResponse($data);
    }

    /**
     * Finds the merchant by his name.
     *
     * @param string $code
     *
     * @return \AppBundle\Entity\Merchant
     */
    private function findMerchantByCode($code)
    {
        $merchant = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Merchant')
            ->findOneBy(['code' => $code]);

        if (!$merchant) {
            throw $this->createNotFoundException('Merchant not found');
        }

        return $merchant;
    }
}
