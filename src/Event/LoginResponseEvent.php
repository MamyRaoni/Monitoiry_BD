<?php

use App\Entity\User;

class LoginResponseEvent{

    public function __construct(public User $user){
    
    }
    public function getUserMail(){
        return $this->user->getEmail();
    }
}