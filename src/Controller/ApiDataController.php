<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Offer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
        $offer->setCountries('123');
        $offer->setName('');
        $offer->setPlatform('Adnroid');
        $offer->setApplicationId('123');

        $em->persist($offer);

        $errors = $validator->validate($offer);
print_r($errors); die();


        $em->flush();

        //$response = json_decode(file_get_contents(__DIR__ . '/apiResource/data.json'));

        return new Response(
            $offer->getId()
        );
    }
}