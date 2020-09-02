<?php

namespace frontend\models\pivot;

class Favorite extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'favorites';
    }

    public function rules()
    {
        return [
            [['user_id', 'fav_user_id'], 'required'],
            [['user_id', 'fav_user_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'fav_user_id' => 'Favorite user ID',
        ];
    }
}
