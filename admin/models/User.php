<?php

namespace lingyin\admin\models;

use lingyin\admin\base\ActiveRecord;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property int $id
 * @property string $email
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $username
 * @property string $auth_key
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $password write-only password
 * @property int $current_partner_id 合作伙伴ID
 *
 * @property UserInfo $profile
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_INACTIVE = 0;
    const STATUS_DELETE = 1;
    const STATUS_ACTIVE = 10;

    public static $shouldCheckPartner = false;

    protected $supperAdmin = false;

    protected $profile;
    protected $partner;

    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETE]],
            ['email', 'email', 'message' => '邮箱格式不合法'],
        ];
    }

    /**
     * @param int|string $id
     * @return User|IdentityInterface|null
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return null
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $email
     * @return User|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getUsername()
    {
        return $this->getProfile()->username;
    }

    public function getSupperAdmin()
    {
        return $this->supperAdmin;
    }

    /**
     * 设置超级管理员标识
     * @param bool $supperAdmin
     */
    public function setSupperAdmin($supperAdmin)
    {
        $this->supperAdmin = $supperAdmin;
    }

    /**
     * @return UserInfo|null
     */
    public function getProfile()
    {
        if (null == $this->profile) {
            $this->profile = UserInfo::findOne(
                [
                    'user_id' => $this->getId(),
                    'partner_id' => $this->current_partner_id,
                ]
            );
        }
        return $this->profile;
    }

    public function getPartner()
    {
        if (null == $this->partner) {
            $this->partner = Partner::findOne($this->current_partner_id);
        }
        return $this->partner;
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
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return app()->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = app()->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = app()->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = app()->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function filterInputAttributes()
    {
        return ['email', 'status'];
    }

}
