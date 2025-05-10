<?php

class LoginContr extends Login {
    private $uid;
    private $pwd;

    public function __construct($uid, $pwd) {
        $this->uid = $uid;
        $this->pwd = $pwd;
    }

    public function loginUser() {
        if ($this->emptyInput() == true) {
            header("location: ../index.php?error=emptyinput");
            exit();
        }

        $this->getUser($this->uid, $this->pwd);
    }

    private function emptyInput() {
        $result = false;
        if (empty($this->uid) || empty($this->pwd)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}