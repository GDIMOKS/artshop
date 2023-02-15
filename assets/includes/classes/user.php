<?php

class User
{
    private $id, $first_name, $last_name, $patronymic_name, $role_id, $email, $password, $phone, $birthday;

    public function __construct($userInfo)
    {
        $this->id = $userInfo['id'];
        $this->first_name = $userInfo['first_name'];
        $this->last_name = $userInfo['last_name'];
        $this->patronymic_name = $userInfo['patronymic_name'];
        $this->role_id = $userInfo['role_id'];
        $this->email = $userInfo['email'];
        $this->password = $userInfo['password'];
        $this->phone = $userInfo['phone'];
        $this->birthday = $userInfo['birthday'];
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}