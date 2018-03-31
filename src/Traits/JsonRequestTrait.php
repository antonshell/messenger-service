<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ParamsTrait
 * @package App\Traits
 */
trait JsonRequestTrait
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getRequestParams(Request $request){
        if($request->headers->get('Content-Type') !== 'application/json'){
            throw new HttpException(400, "Invalid content type header. Must be application/json");
        }

        $params = json_decode($request->getContent(), true);

        return $params;
    }
}