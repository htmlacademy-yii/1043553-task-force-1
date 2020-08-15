<?php

namespace frontend\models;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property int $created_at
 * @property int|null $last_active
 * @property string $email
 * @property string $name
 * @property int $city_id
 * @property string|null $address
 * @property string|null $address_lat
 * @property string|null $address_lon
 * @property string|null $birthday
 * @property string|null $description
 * @property string $password_hash
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $other_app
 * @property int $msg_notification
 * @property int $action_notification
 * @property int $review_notification
 * @property int $show_contacts_all
 * @property int $hide_profile
 *
 * @property Correspondence[] $correspondences
 * @property Notification[] $notifications
 * @property Response[] $responses
 * @property Task[] $tasks
 * @property Task[] $tasks0
 * @property UserPhotos[] $userPhotos
 * @property City $city
 * @property UsersCategories[] $usersCategories
 * @property Category[] $categories
 * @property UserReview[] $usersReviews
 * @property UserReview[] $usersReviews0
 */
class User extends \yii\db\ActiveRecord
{
    public $vote;
    public $tasksCount;
    public $reviewsCount;
    public $categories;
    public $photo;
    //public $city;
    //public $name;
    // public $email;
    public $createdAt;
    public $usersReviews;
    public $userPhotos;
    public $passwordHash;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'email', 'name', 'city_id', 'password_hash'], 'required'],
            [
                [
                    'created_at',
                    'last_active',
                    'city_id',
                    'msg_notification',
                    'action_notification',
                    'review_notification',
                    'show_contacts_all',
                    'hide_profile'
                ],
                'integer'
            ],
            [['birthday'], 'safe'],
            [['email', 'name', 'address', 'address_lat', 'address_lon'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            [['password_hash'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 16],
            [['skype', 'other_app'], 'string', 'max' => 40],
            [['email'], 'unique'],
            [
                ['city_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => City::className(),
                'targetAttribute' => ['city_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'last_active' => 'Last Active',
            'email' => 'Email',
            'name' => 'Name',
            'city_id' => 'City ID',
            'address' => 'Address',
            'address_lat' => 'Address Lat',
            'address_lon' => 'Address Lon',
            'birthday' => 'Birthday',
            'description' => 'Description',
            'password_hash' => 'Password Hash',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'other_app' => 'Other App',
            'msg_notification' => 'Msg Notification',
            'action_notification' => 'Action Notification',
            'review_notification' => 'Review Notification',
            'show_contacts_all' => 'Show Contacts All',
            'hide_profile' => 'Hide Profile',
        ];
    }

    /**
     * Gets query for [[Correspondences]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCorrespondences()
    {
        return $this->hasMany(Correspondence::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notification::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::className(), ['user_employee_id' => 'id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Task::className(), ['user_customer_id' => 'id']);
    }

    /**
     * Gets query for [[Task0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['user_employee_id' => 'id']);
    }

    /**
     * Gets query for [[UserPhotos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserPhotos()
    {
        return $this->hasMany(UserPhoto::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[UsersCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersCategories()
    {
        return $this->hasMany(pivot\UsersCategories::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('users_categories',
            ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UsersReviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersReviews0()
    {
        return $this->hasMany(UsersReview::className(), ['user_customer_id' => 'id']);
    }

    /**
     * Gets query for [[UsersReviews0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersReviews()
    {
        return $this->hasMany(UserReview::className(), ['user_employee_id' => 'id']);
    }
}
