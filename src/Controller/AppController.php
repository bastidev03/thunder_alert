<?php
namespace App\Controller;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\Contact;

class AppController
{
    #[Route('/alerter')]
    public function sendAlert():Response
    {
        $http_request = Request::createFromGlobals();
        $http_response = new Response();

        $insee = $http_request->get('insee');
        $api_key = $http_request->get('api_key');
        
        //Secure Entry Point
        if(isset($_ENV['API_KEY']) && $api_key !== $_ENV['API_KEY']) {
            $http_response->setStatusCode(Response::HTTP_FORBIDDEN);
            return $http_response;
        }

        try {
            $contact_repository = new Contact();
            $contact_list = $contact_repository->getContactByInsee($insee);

            $http_response->headers->set('Content-Type', 'application/json');
            $http_response->setContent(json_encode([
                'message' => "Envoi de sms d'alerte à ".(count($contact_list))." contacts",
            ]));
            //$http_response->setContent(json_encode($contact_list));
           
        } catch (\Exception $exception) {
            $http_response->setContent(json_encode([
                'message' => $exception->getMessage()
            ]));
        }
        
        return $http_response;
    }
}