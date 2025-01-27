<?php

class User {
    private $user_id;
    private $role_id;
    private $email;
    private $location;
    private $leaderboard;
    

    public function __construct($user_id, $role_id, $email, $location, $leaderboard) {
        $this->user_id = $user_id;
        $this->role_id = $role_id;
        $this->email = $email;
        $this->location = $location;
        $this->leaderboard = $leaderboard;
    }

    public function getRoleId(): int {
        return $this->role_id;
    }

    public function getUserId(): int {
        return $this->user_id;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function isLocationOpt(): bool {
        if ($this->location == 1){
            return true;
        }

        return false;
    }

    public function isLeaderboardOpt(): bool {
        if ($this->leaderboard == 1){
            return true;
        }

        return false;
    }
}

?>
