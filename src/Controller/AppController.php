<?php
namespace App\Controller;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\Contact;

class AppController
{
    #[Route('/alerter')]
    public function sendAlert(#[MapQueryParameter] string $insee):Response
    {
        $http_response = new Response();
        try {
            $contact_repository = new Contact();
            $contact_list = $contact_repository->getContactByInsee($insee);

            $http_response->setContent(json_encode([
                'message' => $insee,
            ]));
            //$http_response->setContent(json_encode($contact_list));
            $http_response->headers->set('Content-Type', 'application/json');
        } catch (\Exception $exception) {
            $http_response->setContent(json_encode([
                'message' => $exception->getMessage()
            ]));
        }
        
        return $http_response;
    }
}