<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;


class Comment extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'comment';
    }

    public function rules()
    {
        return [
            [['name', 'email', 'comment'], 'required'],
            [['name', 'comment'], 'string'],
            ['email', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'comment' => 'Comment',
            'email' => 'Email',
        ];
    }

}
