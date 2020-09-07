<?php

namespace frontend\components\task;

use frontend\models\Category;
use frontend\models\forms\TaskCreateForm;
use Yii;
use yii\base\Component;

class TaskCreateComponent extends Component
{
    public function getDataForTaskCreatePage(TaskCreateForm $model): array
    {
        return [
            'model' => $model,
            'categoriesList' => Category::getCategoriesListArray(),
            'errors' => $model->getErrors() ?? []
        ];
    }

    public function createTask(TaskCreateForm $model): bool
    {
        $formData = Yii::$app->request->post() ?? [];

        if ($model->load($formData) && $model->validate()) {
            return $model->save();
        }

        return false;
    }
}
