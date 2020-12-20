<?php

namespace app\models;

trait UserIdentity
{
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === sha1($authKey);
    }

    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function getUsername()
    {
        return $this->name;
    }
}
