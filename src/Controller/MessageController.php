<?php

namespace App\Controller;

use App\Message\MessageService;
use App\Message\VerificationService;
use App\Service\Validation;
use App\Service\Verification;
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
     * @var MessageService
     */
    private $messageService;

    /**
     * @var Verification
     */
    private $verification;

    /**
     * @var Validation
     */
    private $validation;

    /**
     * MessageController constructor.
     * @param MessageService $messageService
     * @param Verification $verification
     * @param Validation $validation
     */
    public function __construct(
        MessageService $messageService,
        Verification $verification,
        Validation $validation
    )
    {
        $this->messageService = $messageService;
        $this->verification = $verification;
        $this->validation = $validation;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function sendAction(Request $request): Response
    {
        $params = $this->getRequestParams($request);

        if(!isset($params['token']) || !$this->verification->verifyToken($params['token'])){
            $code = Response::HTTP_FORBIDDEN;
            return new JsonResponse(['status' => $code, 'message' => 'Invalid token passed'],$code);
        }

        if(!$this->validation->validateParams($params)){
            $code = Response::HTTP_BAD_REQUEST;
            return new JsonResponse(['status' => $code, 'errors' => $this->validation->getErrors()],$code);
        }

        $this->messageService->queueMessage($params);

        $results = ['status' => Response::HTTP_OK, 'message' => 'Added to queue'];
        return new JsonResponse($results);
    }


}
