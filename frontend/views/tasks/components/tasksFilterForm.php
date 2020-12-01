<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="search-task__wrapper">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'search-task__form',
            'name' => $model->formName(),
            'id' => 'filterForm'
        ]
    ]); ?>
    <fieldset class="search-task__categories">
        <legend>Категории</legend>
        <?= $form->field($model, 'categories')->checkboxList(
            $model->categoriesFields(),
            [
                'tag' => false,
                'itemOptions' => [

                ]
            ]
        )->label(false); ?>
    </fieldset>

    <fieldset class="search-task__categories">
        <legend>Дополнительно</legend>
        <?= $form->field($model, 'additional')->checkboxList(
            $model->additionalFields(),
            [
                'tag' => false,
                'itemOptions' => [

                ]
            ]
        )->label(false); ?>
    </fieldset>

    <label class="search-task__name" for="period">Период</label>

    <?= $form->field($model, 'period', ['template' => "{label}\n{input}"])
        ->dropDownList(
            ['all' => 'За все время', 'day' => 'За день', 'week' => 'За неделю', 'month' => 'За месяц'],
            [
                'class' => 'multiple-select input',
                'id' => 'period',
                'size' => '1'
            ]
        )->label(false); ?>

    <label class="search-task__name" for="search"><?= $model->searchField(); ?></label>
    <?php $options = [
        'class' => 'input-middle input',
        'id' => 'search',
        'tag' => false
    ]; ?>
    <?= $form->field($model, 'search', ['template' => "{label}\n{input}"])->input('text',
        $options)->label(false); ?>

    <?= Html::submitButton('Искать', ['class' => 'button']) ?>
    <?php ActiveForm::end(); ?>
</div>