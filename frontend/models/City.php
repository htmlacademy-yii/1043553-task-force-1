<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property int $id
 * @property string $name
 * @property string|null $lat
 * @property string|null $lon
 *
 * @property Tasks[] $tasks
 * @property User[] $users
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @return array
     *
     * Возращаем массив городов в формате ['city id' => 'city name']
     */
    public static function getCities(): array
    {
        $citiesList = City::find()->orderBy(['name' => SORT_ASC])->all();

        $cities = [];
        foreach ($citiesList as $city) {
            $cities[$city->id] = $city->name;
        }

         return $cities;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
         return 'cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
         return [
            [['name'], 'required'],
            [['name', 'lat', 'lon'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
         return [
            'id' => 'ID',
            'name' => 'Name',
            'lat' => 'Lat',
            'lon' => 'Lon',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
         return $this->hasMany(Tasks::className(), ['city_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
         return $this->hasMany(User::className(), ['city_id' => 'id']);
    }
}
