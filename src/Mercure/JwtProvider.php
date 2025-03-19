<?php 
// namespace App\Mercure;

// use Lcobucci\JWT\Signer\Ecdsa\Sha256;
// use Lcobucci\JWT\Token\Builder;

// class JwtProvider{
//     private $secret;
//     public function __construct(string $secret){
//         $this->secret=$secret;
//     }

//     public function __invoke(){
//         return(new Builder())
//             ->set('mercure', ['publish'=>['*']])
//             ->sign(new Sha256(), $this->secret)
//             ->getToken();
//     }

// }