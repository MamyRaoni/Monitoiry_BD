<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AuditCompteRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class AdminController extends AbstractController
{
    #[Route('/admin/register', name: 'app_user_create', methods:['POST'])]

    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        if (!$data) {
            return $this->json([
                'status' => 'error',
                'message' => 'Invalid JSON data'
            ], status: JsonResponse::HTTP_PRECONDITION_REQUIRED);
        }

        try {
            $user = new User();
            $user->setEmail($data['email']);
            $user->setUsername($data['username']);
            $hashedPassword=$passwordHasher->hashPassword($user,$data['password']);
            $user->setPassword($hashedPassword);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->json([
                'status' => 'success',
                'message' => 'User registered successfully'
            ], status: JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
            return $this->json([
                'status' => 'error',
                'message' => 'Registration failed'
            ], JsonResponse::HTTP_NOT_FOUND);
        }
    }
    #[route('/admin/getAll', name:'app_compte_get',methods:['GET'])]
    public function getAll(AuditCompteRepository $auditCompteRepository, SerializerInterface $serializer,UserRepository $userRepository){
        $Auditcopmtes=$auditCompteRepository->findAll();
        // foreach($Auditcopmtes as $Auditcopmte){
        //     $user=$userRepository->find($Auditcopmte->getUtilisateur());
        //     //dump($user);
        //     $Auditcopmte->setUtilisateur($user->getUsername());
            
        // }
        return $this->json($Auditcopmtes);
    }
}
