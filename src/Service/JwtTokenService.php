<?php
namespace App\Service;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class JwtTokenService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }
    public function generateToken(User $user): string
    {
        
        $id=$user->getId();
        $email=$user->getEmail();
        $varencode="id: ".$id." "."email: ".$email;
        base64_encode($varencode);

        return base64_encode($varencode);
    }

    public function decodeToken(string $token): User
    {

        $varencode=base64_decode($token);
        $idEmail=str_replace(['email: ','id: '],'', $varencode);
        $vide="";
        $id=str_pad($vide,2,$idEmail);
        $idFinal=trim($id);
        $repository = $this->entityManager->getRepository(User::class);
        $user=$repository->find($idFinal);
        return $user;
    }
    public function getID(string $token): string{
        $varencode=base64_decode($token);
        $idEmail=str_replace(['email: ','id: '],'', $varencode);
        $vide="";
        $id=str_pad($vide,2,$idEmail);
        $idFinal=trim($id);
        return $idFinal;
    }
}
