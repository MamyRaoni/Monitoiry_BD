<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Repository\CompteRepository;
use App\Repository\UserRepository;
use App\Service\JwtTokenService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class UsersController extends AbstractController
{
    #[Route('/user/compte/create', name: 'app_compte_create', methods:['POST'])]
    public function create(Request $request,JwtTokenService $jwtTokenService, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return $this->json([
                'status' => 'error',
                'message' => 'Invalid JSON data'
            ], status: JsonResponse::HTTP_PRECONDITION_REQUIRED);
        }
        try {
            $compte=new Compte();
            $compte->setNomClient($data['nom_client']);
            $compte->setNumeroCompte($data['numero_compte']);
            $compte->setSolde($data['solde']);
            $token=str_replace('Bearer', '', $request->headers->get('Authorization'));
            $user=$jwtTokenService->decodeToken($token);
            $compte->setIdUser($user);
            $entityManager->persist($compte);
            $entityManager->flush();
            return $this->json([
                'status' => 'success',
                'message' => 'Compte registered successfully'
            ], status: JsonResponse::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->json([
                'status' => 'error',
                'message' => 'Registration failed: ',
                'Error'=>$th,
            ], JsonResponse::HTTP_NOT_FOUND);
        }
    }
    #[route('user/compte/edit/{id}', name: 'app_compte_edit', methods: ['PATCH'])]
    public function edit(int $id, Request $request, EntityManagerInterface $em , CompteRepository $compteRepository,UserRepository $userRepository):JsonResponse {
        $compte=$compteRepository->find($id);
        if (!$compte) {
            # code...
            throw $this->createNotFoundException("Il n'y a pas de compte avec l'id ".$id);
        }
        $data=json_decode($request->getContent(), true);

            if (isset($data['numero_compte'])) {
                $compte->setNumeroCompte($data['numero_compte']);
            }
            
            if (isset($data['solde'])) {
                $compte->setSolde($data['solde']);
            }
            if(isset($data["nom_client"])){
                $compte->setNomClient($data["nom_client"]);
            }
                       
            $em->flush();
            return $this->json(['message'=>'modification reussi'],JsonResponse::HTTP_OK);

    }
    #[route('user/compte/showAll', name:'app_compte_showAll', methods:['GET'])]
    public function showAll(CompteRepository $compteRepository, SerializerInterface $serializerInterface){
        $compte=$compteRepository->findAll();
        $json=$serializerInterface->serialize($compte,'json', ['groups' => 'user']);
        //return $this->json($json, 201, [], ['groups' => 'user']);
        return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
    }
    #[route('user/compte/show/{id}', name: 'app_compte_show', methods:['GET'])]
    public function show(CompteRepository $compteRepository, SerializerInterface $serializerInterface, int $id){
        $compte=$compteRepository->find($id);
        $json=$serializerInterface->serialize($compte,'json', ['groups' => 'user']);
        //return $this->json($json, 201, [], ['groups' => 'user']);
        return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
    }
    #[route('user/compte/remove/{id}', name: 'app_compte_show', methods:['DELETE'])]
    public function remove( EntityManagerInterface $entityManagerInterface, Compte $compte){
        $entityManagerInterface->remove($compte);
        $entityManagerInterface->flush();

        //return $this->json($json, 201, [], ['groups' => 'user']);
        return new JsonResponse((["message"=>"suppression reussi"]), JsonResponse::HTTP_NO_CONTENT, [], true);
    }


}
