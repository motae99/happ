<?php

namespace app\models;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $type;
    public $reference;
    public $accessToken;

    private static $users = [
        // '100' => [
        //     'id' => '100',
        //     'username' => 'clinic',
        //     'password' => 'clinic',
        //     'authKey' => 'test100key',
        //     'type' => 'clinic',
        //     'reference' => '6',
        // ],
        // '101' => [
        //     'id' => '101',
        //     'username' => 'pharmacy',
        //     'password' => 'pharmacy',
        //     'authKey' => 'test101key',
        //     'accessToken' => '101-token',
        //     'type' => 'pharmacy',
        //     'reference' => '1',
        // ],
        '103' => [
            'id' => '103',
            'username' => 'admin',
            'password' => 'admin_123',
            'authKey' => 'test103key',
            'accessToken' => '103-token',
            'type' => 'admin',
            'reference' => '',
        ],
        '104' => [
            'id' => '104',
            'username' => 'yahia',
            'password' => '0123314131',
            'authKey' => 'test102key',
            'accessToken' => '104-token',
            'type' => 'admin',
            'reference' => '',
        ],
        '105' => [
            'id' => '105',
            'username' => 'omer',
            'password' => '0121647675',
            'authKey' => 'test105key',
            'accessToken' => '105-token',
            'type' => 'admin',
            'reference' => '',
        ],
    ];


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
