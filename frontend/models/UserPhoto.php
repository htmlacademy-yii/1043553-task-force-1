<?php

namespace frontend\models;

use yii\web\UploadedFile;

/**
 * This is the model class for table "user_photos".
 *
 * @property int $id
 * @property int $user_id
 * @property string $photo
 *
 * @property Users $user
 */
class UserPhoto extends \yii\db\ActiveRecord
{
    public static function userCanUploadMorePhotos($files, int $useId)
    {
        $uploadedFilesCount = count($files);
        $savedFilesCount = self::find()->where(['user_id' => $useId])->count();
        $total = $uploadedFilesCount + $savedFilesCount;

        if ($savedFilesCount >= 6) {
            throw new  \Exception('вы уже загрузили максимально возможное количество фото');
        }

        if ($total > 6) {
            $canUpload = 6 - $savedFilesCount;
            throw new  \Exception('вы можете загрузить только' . $canUpload . 'фото');
        }

        return true;
    }

    public static function saveUserPhotos(array $files, int $useId): bool
    {
        if (self::userCanUploadMorePhotos($files, $useId)) {
            foreach ($files as $file) {
                $photo = uniqid() . ".{$file->extension}";
                $filePath = "portfolios/" . $photo;
                if (!$file->saveAs($filePath) or !UserPhoto::saveUserPhoto($photo, $useId)) {
                    throw new \Exception(' ошибка при сохранении файла');
                }
            }
        }
        return true;
    }

    public static function saveUserPhoto($photo, $userId)
    {
        $self = new self();
        $self->photo = $photo;
        $self->user_id = $userId;
        return $self->save(false);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_photos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'photo'], 'required'],
            [['user_id'], 'integer'],
            [['photo'], 'string', 'max' => 255],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Users::className(),
                'targetAttribute' => ['user_id' => 'id']
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
            'user_id' => 'User ID',
            'photo' => 'Photo',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
