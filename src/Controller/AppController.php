<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

use App\Repository\Contact;
use App\Message\AlertSms;

class AppController extends AbstractController
{
    private $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
        
    }

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

            foreach($contact_list as $contact) {
                $this->bus->dispatch(new AlertSms($contact['telephone']));
            }
           
            $http_response->headers->set('Content-Type', 'application/json');
            $http_response->setContent(json_encode([
                'code' => 'ok',
                'message' => "Envoi de sms d'alerte à ".(count($contact_list))." contacts",
            ]));
            //$http_response->setContent(json_encode($contact_list));
           
        } catch (\Exception $exception) {
            $http_response->setContent(json_encode([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]));
        }
        
        return $http_response;
    }
}