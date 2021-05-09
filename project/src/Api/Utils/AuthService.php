<?php

declare(strict_types=1);

namespace App\Api\Utils;

class AuthService {
    private array $users = [
        'admin' => 'admin'
    ];

    public function checkCredentials(string $login, string $pw):bool {
        $userPw = $this->users[$login] ?? false;
        if(!$userPw) {
            return false;
        }
        if($userPw===$pw) {
            return true;
        }
        return false;
    }
}