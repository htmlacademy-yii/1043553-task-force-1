<div class="search-task__wrapper">

    <?php $form = yii\widgets\ActiveForm::begin([
        'options' => [
            'class' => 'search-task__form',
            'name' => $model->formName(),
            'id' => 'filterForm'
        ]
    ]); ?>
    <fieldset class="search-task__categories">
        <legend>Категории</legend>
        <?php

        echo $form->field($model, 'categories')->checkboxList(
            $model->categoriesFields(),
            [
                'tag' => false,
                'itemOptions' => [

                ]
            ]
        )->label(false);

        ?>
    </fieldset>

    <fieldset class="search-task__categories">
        <legend>Дополнительно</legend>
        <?php

        echo $form->field($model, 'additional')->checkboxList(
            $model->additionalFields(),
            [
                'tag' => false,
                'value' => Yii::$app->request->post()["UsersFilterForm"]['additional'] ?? [],
                'itemOptions' => [

                ]
            ]
        )->label(false); ?>
    </fieldset>


    <label class="search-task__name" for="search"><?= $model->searchField(); ?></label>
    <?php $options = [
        'class' => 'input-middle input',
        'id' => 'search',
        'tag' => false
    ]; ?>
    <?= $form->field($model, 'search', ['template' => "{label}\n{input}"])->input('text',
        $options)->label(false); ?>

    <?= yii\helpers\Html::submitButton('Искать', ['class' => 'button', 'id' =>'submitButton' ]) ?>
    <?php yii\widgets\ActiveForm::end(); ?>

</div>