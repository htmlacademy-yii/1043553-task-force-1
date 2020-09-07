<?php

namespace frontend\models;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property string $image
 *
 * @property Tasks[] $tasks
 * @property UsersCategories[] $usersCategories
 * @property User[] $users
 */
class Category extends \yii\db\ActiveRecord
{
    public static function getCategoriesListArray()
    {
        $categories = Category::find()->all();
        $data = [];

        foreach ($categories as $category) {
            $data[$category['id']] = $category['name'];
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'image'], 'required'],
            [['name', 'image'], 'string', 'max' => 50],
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
            'image' => 'Image',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['category_id' => 'id']);
    }

    /**
     * Gets query for [[UsersCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersCategories()
    {
        return $this->hasMany(UsersCategories::className(), ['category_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(
            User::className(), ['id' => 'user_id'])->viaTable('users_categories', ['category_id' => 'id']);
    }
}
