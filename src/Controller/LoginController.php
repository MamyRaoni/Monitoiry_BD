<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\JwtTokenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class LoginController extends AbstractController
{
    #[Route('/login', name: 'api_login', methods: ['POST'])]
    public function login(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, JwtTokenService  $jwtTokenService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        if (!$data) {
            return $this->json([
                'status' => 'error',
                'message' => 'Invalid JSON data'
            ], JsonResponse::HTTP_PRECONDITION_REQUIRED);
        }

        try {
            $user=$userRepository->findOneBy(['email' => $data['email']]);
            if (!$user || !$passwordHasher->isPasswordValid($user,  $data['password'])) {
                return new JsonResponse(['message' => 'Identifiants invalides.'], JsonResponse::HTTP_UNAUTHORIZED);
            }else{
                $token = $jwtTokenService->generateToken($user);
                $Users=$jwtTokenService->decodeToken($token);
                return $this->json([
                    'status' => 'success',
                    'message' => 'User logged in successfully',
                    'token' => $token,
                    'EmailUsers'=>$Users->getEmail(),
                ], status: JsonResponse::HTTP_OK);
            }

        } catch (\Exception $e) {
            return $this->json([
                'status' => 'error',
                'message' => 'Login failed'
            ], status: JsonResponse::HTTP_NOT_FOUND);
        }
    }
}
