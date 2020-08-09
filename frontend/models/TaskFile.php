<?php

namespace frontend\models;

/**
 * This is the model class for table "tasks_files".
 *
 * @property int $id
 * @property int $task_id
 * @property string $file
 *
 * @property Tasks $task
 */
class TaskFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
         return 'tasks_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
         return [
            [['task_id', 'file'], 'required'],
            [['task_id'], 'integer'],
            [['file'], 'string', 'max' => 255],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
         return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'file' => 'File',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
         return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }
}
