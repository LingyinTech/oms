<?php


namespace lingyin\admin\models\vo;

use lingyin\admin\models\Node;
use yii\base\Model;

class NodeForm extends Model
{

    public $id;
    public $pid;
    public $label;
    public $url;
    public $icon;
    public $remark;
    public $sort;
    public $status;

    public function rules()
    {
        return [
            ['id', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],
            ['pid', 'default', 'value' => 0],
            ['sort','default','value' => 99],
            [['label','icon','remark'], 'filter', 'filter' => 'trim'],
            [['label', 'url'], 'required'],
            ['status', 'default', 'value' => Node::STATUS_INACTIVE],
            ['status', 'in', 'range' => [Node::STATUS_INACTIVE, Node::STATUS_ACTION, Node::STATUS_MENU]],
        ];
    }

    public function saveNode()
    {
        if ($this->validate()) {
            $model = new Node();
            $data = [];
            foreach ($model->filterInputAttributes() as $attribute) {
                if (isset($this->{$attribute})) {
                    $data[$attribute] = $this->{$attribute};
                }
            }
            return (new Node())->saveData($data);
        }

        return false;
    }

    public function initData($id)
    {
        if ($model = Node::findOne($id)) {
            $this->attributes = $model->attributes;
        }
    }
}