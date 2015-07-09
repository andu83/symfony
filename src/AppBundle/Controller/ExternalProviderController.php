<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExternalProviderController extends Controller
{
    public function indexAction()
    {
        sleep(rand(0, 5));

        return new JsonResponse(rand(1, 3));
    }
}
