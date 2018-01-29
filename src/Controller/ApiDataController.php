<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Offer;
use League\ISO3166\Exception\DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use League\ISO3166\ISO3166;

class ApiDataController extends Controller
{
    /**
     * @Route("/api/offer")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function offer(ValidatorInterface $validator)
    {
        $em = $this->getDoctrine()->getManager();

        $offer = new Offer();
        $offer->setCountries('["RUS", "JPN", "UA"]');
        $offer->setName('123');
        $offer->setPlatform('Android');
        $offer->setApplicationId('123');

        $em->persist($offer);

        $errors = $validator->validate($offer);

        if (count($errors) > 0) {
            $response = (string) $errors . 'Failure! Can not create an Offer!';
        }
        else {
            $countries = json_decode($offer->getCountries());

            foreach ($countries as &$country) {
                $data = '';

                try {
                    $data = (new ISO3166)->alpha3($country);
                } catch (\Exception $e) {
                }

                if ($data) {
                    $country = $data['alpha2'];
                }
            }

            $offer->setCountries(json_encode($countries));

            $em->flush();
            $response = $offer->getId() .
                ' 1- created offer Id' .
                PHP_EOL .
                'Success! An offer created!' .
                PHP_EOL;
        }

        return new Response(
            $response
        );
    }
}