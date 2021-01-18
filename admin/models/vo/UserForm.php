<?php


namespace lingyin\admin\models\vo;

use lingyin\admin\logic\PartnerLogic;
use lingyin\admin\models\Partner;
use lingyin\admin\models\User;
use lingyin\admin\models\UserInfo;
use lingyin\admin\base\Model;
use yii\db\Exception;

class UserForm extends Model
{

    public $user_id;
    public $real_name;
    public $email;
    public $username;
    public $avatar;
    public $tel;
    public $phone;
    public $department_id;
    public $status;
    public $partner_id;

    public function rules()
    {
        return [
            [
                'user_id',
                'exist',
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id'],
                'message' => '用户不存在',
                'skipOnEmpty' => true
            ],
            [
                'partner_id',
                'exist',
                'targetClass' => Partner::class,
                'targetAttribute' => ['partner_id' => 'id'],
                'skipOnEmpty' => true
            ],
            [['email', 'username', 'real_name'], 'required'],
            [['avatar', 'tel', 'phone'], 'filter', 'filter' => 'trim'],
            ['status', 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_INACTIVE, User::STATUS_DELETE]],
        ];
    }

    public function saveUser()
    {
        if ($this->validate()) {
            $trans = User::getDb()->beginTransaction();
            try {
                // 添加用户
                if (!$this->user_id) {
                    $user = new User();
                    $user->setPassword('123456');
                    $user->current_partner_id = PartnerLogic::filterPartnerId($this->partner_id);
                } else {
                    $user = User::findOne($this->user_id);
                    if (!$user) {
                        $this->addError('msg', '用户不存在');
                        return false;
                    }
                    if (app()->user->getIdentity()->getSupperAdmin()) {
                        !empty($this->partner_id) && $user->current_partner_id = $this->partner_id;
                    }
                }

                $user->username = $this->username;
                $user->status = $this->status;
                if (!$user->save()) {
                    $trans->rollBack();
                    $this->addErrors($user->getErrors());
                    return false;
                }

                $this->user_id = $user->getId();
                $userInfo = new UserInfo();
                $data = ['user_id' => $this->user_id];
                foreach ($userInfo->filterInputAttributes() as $attribute) {
                    if (isset($this->{$attribute})) {
                        $data[$attribute] = $this->{$attribute};
                    }
                }

                if (!$userInfo->saveData($data)) {
                    $trans->rollBack();
                    $this->addErrors($userInfo->getErrors());
                    return false;
                }
                $trans->commit();
                return true;
            } catch (Exception $e) {
                $this->addError('username', $e->getMessage());
                $trans->rollBack();
            } catch (\Throwable $e) {
            }
        }
        return false;
    }

    public function initData($id)
    {
        $user = User::findOne($id);

        if (!$user) {
            return;
        }

        $userInfo = UserInfo::findOne(
            [
                'user_id' => $id,
                'partner_id' => $user->current_partner_id
            ]
        );

        if (PartnerLogic::checkPartnerId($user->current_partner_id)) {
            $this->attributes = array_merge($userInfo->attributes, $user->attributes);
        }
    }

    public function getList($condition = [])
    {
        $list = (new UserInfo())->getList($condition);
        if (empty($list['list'])) {
            return $list;
        }
        $userIdArr = array_column($list['list'], 'user_id');
        $userList = (new User())->getList(['in' => ['id' => $userIdArr], 'select' => ['id', 'username', 'status']]);
        $userList = array_column($userList['list'], null, 'id');
        foreach ($list['list'] as $key => &$item) {
            $item = array_merge($item, $userList[$item['user_id']]);
        }
        unset($item);

        return $list;
    }
}