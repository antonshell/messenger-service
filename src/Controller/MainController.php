<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class MainController
 * @package App\Controller
 */
class MainController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction(): Response
    {
        return new JsonResponse([
            'status' => 'ok',
            'message' => 'message service'
        ]);
    }
}
