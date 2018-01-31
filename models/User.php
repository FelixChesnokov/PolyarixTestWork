<?php

namespace app\models;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;


class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public function rules()
	{
	    return [
            [['username', 'password', 'is_admin'], 'required'],
	    ];
    }

    public function getTransaction() 
	{
		return $this->hasMany(Transaction::className(), ['user_id' => 'id']);
	}

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
//            isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
//        foreach (self::$users as $user) {
//            if ($user['accessToken'] === $token) {
//                return new static($user);
//            }
//        }
//
//        return null;
        
        return static::findOne(['access_token'=> $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username'=> $username]);
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
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password ===$password;
    }

}