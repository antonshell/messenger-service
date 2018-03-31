<?php

namespace App\Controller;

use App\Traits\JsonRequestTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class MessageController
 * @package App\Controller
 */
class MessageController extends Controller
{
    use JsonRequestTrait;

    /**
     * @param Request $request
     * @return Response
     */
    public function sendAction(Request $request): Response
    {
        $params = $this->getRequestParams($request);
        $results = ['status' => 'ok', 'message' => 'sendAction', 'params' => $params];
        return new JsonResponse($results);
    }
}
