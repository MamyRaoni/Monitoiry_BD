<?php

namespace App\Security;

use App\Service\JwtTokenService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class APIAuthenticator extends AbstractAuthenticator{
    private $jwtTokenService;

    public function __construct(JwtTokenService $JwtTokenService)
    {
        $this->jwtTokenService = $JwtTokenService;

    }

    public function supports(Request $request): bool|null{
        return $request->headers->has('Authorization')&& str_contains($request->headers->get('Authorization'),'Bearer');
    }
    public function authenticate(Request $request): Passport{
        $token=str_replace('Bearer', '', $request->headers->get('Authorization'));
        $User = $this->jwtTokenService->decodeToken($token);
        return new SelfValidatingPassport(
            new UserBadge($User->getEmail())
        );
    }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): Response|null{
        return null;
    }
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response|null{
        return new JsonResponse(
            ['message'=>$exception->getMessage()
        ], JsonResponse::HTTP_UNAUTHORIZED
        );
    }

}