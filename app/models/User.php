<?php

class User {
    private int $id;
    private string $name;
    private string $email;
    private int $password;
    private string $role;

    public function __construct($id , $name , $email , $password , $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email =$email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId($id){
        return $this->id;
    }
    public function getName($name){
        return $this->name;
    }
    public function getEmail($email){
        return $this->email;
    }
    public function getPassword($password){
        return $this->password;
    }
    public function getRole($role){
        return $this->role;
    }
    public function setId($id){
        return $this->id;
    }
    public function setName($name){
        return $this->name;
    }
    public function setEmail($email){
        return $this->email;
    }
    public function setPassword($password){
        return $this->password;
    }
    public function setRole($role){
        return $this->role;
    }
}