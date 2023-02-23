<?php

class User
{
    private $id, $first_name, $last_name, $patronymic_name;
    private $role_id, $email, $password, $phone, $birthday;

    public function __construct($userInfo)
    {
        $this->id = $userInfo['user_id'];
        $this->first_name = $userInfo['first_name'];
        $this->last_name = $userInfo['last_name'] ?? "";
        $this->patronymic_name = $userInfo['patronymic_name'] ?? "";
        $this->role_id = $userInfo['role_id'];
        $this->email = $userInfo['email'];
        $this->password = $userInfo['password'];
        $this->phone = $userInfo['phone'] ?? "";
        $this->birthday = $userInfo['birthday'] ?? "";
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

    public function getRoleName() {
        switch ($this->role_id) {
            case 1:
                return 'Владелец';
            case 2:
                return 'Студент';
            case 3:
                return 'Продавец';
            case 4:
                return 'Гость';
            case 5:
                return 'Продавец+';
        }
    }

    public function getFullName() {
        $full_name = $this->first_name;

        if (!empty($this->last_name))
            $full_name .= ' '.$this->last_name;
        if (!empty($this->patronymic_name))
            $full_name .= ' '.$this->patronymic_name;

        return $full_name;
    }
}