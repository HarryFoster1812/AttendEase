<?php

class User {
    private $user_id;
    private $role_id;
    private $email;
    private $location;
    private $leaderboard;
    private $name;
    private $username;
    private $pronouns;
    private $profile_path;
    private $academic;

    public function __construct($user_id, $username, $role_id, $email, $location, $leaderboard, $name, $academic, $pronouns = "Not Set", $pfp = "../images/Default_pfp.jpg") {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->role_id = $role_id;
        $this->email = $email;
        $this->location = $location;
        $this->leaderboard = $leaderboard;
        $this->name = $name;
        $this->pronouns = $pronouns;
        $this->profile_path = $pfp;
        $this->academic = $academic;
    }

    public function getRoleId(): int {
        return $this->role_id;
    }

    public function getPronouns(): string {
        return $this->pronouns;
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

    public function getUsername(): string{
        return $this->username;
    }

    public function isLeaderboardOpt(): bool {
        if ($this->leaderboard == 1){
            return true;
        }

        return false;
    }

    public function getPfpPath(): string{
        if(!isset($this->profile_path)){
            return "../images/Default_pfp.jpg";
        }
        return $this->profile_path;
    }

    public function getAcademic(): string{
        if(!isset($this->academic)){
            return "N/A";
        }
        return $this->academic;
    }

    public function getName(): string {
        // either can calculate the name based off the email
        // or create a new row?
        return $this->name;
    }

    public function setPfpPath($newPath): void{
        $this->profile_path = $newPath;
    }

    public function setPronouns($newPronouns): void{
        $this->pronouns = $newPronouns;
    }

    public function setLocationOpt($newOption): void{
        $this->location=$newOption;
    }

    public function setLeaderboardOpt($newOption): void{
        $this->leaderboard=$newOption;
    }
}

?>
