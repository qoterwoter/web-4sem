<?php

declare(strict_types=1);

namespace App\Api\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Api\Utils\AuthService;
/**
 * @Route("/irat")  
 */

class IratController
{
    /**
     * @Route(path="/", methods={"GET"})
     */
    public function index(Request $request, AuthService $authService) 
    {
        $authMetaData =$request->headers->get('Authorization','');
        $context = [
            'authMetaData' => $authMetaData,
        ];
        if($authMetaData !== ''){
            [$type,$credentials] = explode(' ',$authMetaData);
            $decodedCreds = base64_decode($credentials);
            [$login,$pw] = explode(':',$decodedCreds);
            $context += [
                'authMetaData' => $authMetaData,
                'type' => $type,
                'credentials' => $credentials,
                'login' => $login,
                'pw' => $pw,
                'decodedCreds' => $decodedCreds,
            ];
            if($authService->checkCredentials($login,$pw)) {
                return new Response(
                    json_encode(
                        [
                            'message' => 'Hello, world',
                        ]+$context, JSON_THROW_ON_ERROR
                    ),
                    Response::HTTP_OK,
                    [
                        'Сontent-type' => 'application/json'
                    ]
                );
            }

        } 
        $realm = 'Access to the staging site'; 
        return new Response(
            json_encode(
                [
                    'message' => 'Not Authorized',
                ]+$context, JSON_THROW_ON_ERROR
            ),
            Response::HTTP_UNAUTHORIZED,
            [
                'WWW-Authenticate' => 'Basic realm="Access to the staging site", charset="UTF-8"', $realm,
                'Content-type'=>'application/json'
            ]
            
        );
    }
    /**
     * @Route(path="/about", methods={"GET"})
     */ 
    public function about(Request $request) {
        return new Response(
            json_encode(
                [
                    [
                        'name'    => 'Irat',
                        'surname'   => 'Ashiroff',
                        'age'   => 16,
                        'studying' => True,
                        'isGhoul' => False,
                    ],[
                        'name'    => 'Ivan',
                        'surname'   => 'Vedenov',
                        'age'   => 16,
                        'studying' => True,
                        'isGhoul' => False,
                    ]
                ]
            ),
            Response::HTTP_OK,
            [
                'Content-type'=>'application/json'
            ]
            );
    }
}