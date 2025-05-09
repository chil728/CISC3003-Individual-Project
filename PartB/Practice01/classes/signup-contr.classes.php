<?php

class SignupContr extends Signup {
    private $uid;
    private $pwd;
    private $pwdrepeat;
    private $email;

    public function __construct($uid, $pwd, $pwdrepeat, $email) {
        $this->uid = $uid;
        $this->pwd = $pwd;
        $this->pwdrepeat = $pwdrepeat;
        $this->email = $email;
    }

    public function signupUser() {
        if ($this->emptyInput() == true) {
            header("location: ../index.php?error=emptyinput");
            exit();
        }

        if ($this->invalidUid() == true) {
            header("location: ../index.php?error=username");
            exit();
        }

        if ($this->invalidEmail() == true) {
            header("location: ../index.php?error=email");
            exit();
        }

        if ($this->pwdMatch() == true) {
            header("location: ../index.php?error=passwordmatch");
            exit();
        }

        if ($this->uidTakenCheck() == false) {
            header("location: ../index.php?error=useroremailtaken");
            exit();
        }

        $this->setUser($this->uid, $this->pwd, $this->email);
    }

    private function emptyInput() {
        $result = false;
        if (empty($this->uid) || empty($this->pwd) || empty($this->pwdrepeat) || empty($this->email)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function invalidUid() {
        $result = false;
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->uid)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function invalidEmail() {
        $result = false;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function pwdMatch() {
        $result = false;
        if ($this->pwd !== $this->pwdrepeat) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function uidTakenCheck() {
        $result = false;
        if (!$this->checkUser($this->uid, $this->email)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
}