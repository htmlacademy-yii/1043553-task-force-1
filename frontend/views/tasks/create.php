<?php

/* @var $this yii\web\View */

use yii\widgets\ActiveForm;

$this->title = 'Создать задание - TaskForce';

?>

<section class="create__task">

    <h1>Публикация нового задания</h1>

    <div class="create__task-main">

        <?php $form = ActiveForm::begin([
            'id' => 'task-form',

            'options' => [
                ['enctype' => 'multipart/form-data'],
                'class' => 'create__task-form form-create',
                //'enctype' => 'multipart/form-data',
                'name' => $model->formName()
            ],
            'fieldConfig' => [
                'options' => [
                    'tag' => false
                ]
            ]
        ]); ?>

        <?php $options = [
            'class' => 'input textarea',
            'rows' => '1',
            'id' => 'name',
            'tag' => false
        ]; ?>
        <?= $form->field($model, 'title', ['template' => "{label}\n{input}"])->input('textarea', $options)->label(null,
            ['for' => 'name']); ?>
        <span>Кратко опишите суть работы</span>

        <?php $options = [
            'class' => 'input textarea',
            'rows' => '7',
            'id' => 'description',
            'tag' => false
        ]; ?>
        <?= $form->field($model, 'description', ['template' => "{label}\n{input}"])->input('textarea',
            $options)->label(null, ['for' => 'description']); ?>
        <span>Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться</span>

        <?php $options = [
            'class' => 'multiple-select input multiple-select-big',
            'size' => '1',
            'id' => 'category',
            'tag' => false
        ]; ?>
        <?= $form->field($model, 'category', ['template' => "{label}\n{input}"])->dropDownList($categoriesList,
            $options)->label(null, ['for' => 'category']); ?>
        <span>Выберите категорию</span>

        <label>Файлы</label>
        <span>Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу</span>

        <div class="create__file">
           <!-- <span>Добавить новый файл</span>-->
            <?= $form->field($model, 'files[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>


        </div>

        <?php $options = [
            'class' => 'input-navigation input-middle input',
            'id' => 'address',
            'tag' => false
        ]; ?>
        <?= $form->field($model, 'address', ['template' => "{label}\n{input}"])->input('search', $options)->label(null,
            ['for' => 'address']); ?>
        <span>Укажите адрес исполнения, если задание требует присутствия</span>

        <div class="create__price-time">
            <div class="create__price-time--wrapper">
                <?php $options = [
                    'class' => 'input textarea input-money',
                    'rows' => '1',
                    'id' => 'budget',
                    'tag' => false
                ]; ?>
                <?= $form->field($model, 'budget', ['template' => "{label}\n{input}"])->input('textarea',
                    $options)->label(null, ['for' => 'expire']); ?>
                <span>Не заполняйте для оценки исполнителем</span>
            </div>
            <div class="create__price-time--wrapper">
                <?php $options = [
                    'class' => 'input-middle input input-date',
                    'id' => 'expire',
                    'value' =>  date("d.m.Y"),
                    'tag' => false
                ]; ?>
                <?= $form->field($model, 'deadline', ['template' => "{label}\n{input}"])->input('date',
                    $options)->label(null, ['for' => 'date']); ?>
                <span>Укажите крайний срок исполнения</span>
            </div>

            <div>
                <?= $form->field($model, 'lat', ['options' => ['id' => 'lat']])->hiddenInput()->label(false); ?>
                <?= $form->field($model, 'lon', ['options' => ['id' => 'lon']])->hiddenInput()->label(false); ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

        <div class="create__warnings">
            <div class="warning-item warning-item--advice">
                <h2>Правила хорошего описания</h2>
                <h3>Подробности</h3>
                <p>Друзья, не используйте случайный<br>контент – ни наш, ни чей-либо еще. Заполняйте свои макеты,
                    вайрфреймы, мокапы и прототипы реальным содержимым.</p>
                <h3>Файлы</h3>
                <p>Если загружаете фотографии объекта, то убедитесь, что всё в фокусе, а фото показывает объект со всех
                    ракурсов.</p>
            </div>
            <?php if ($errors) : ?>
                <div class="warning-item warning-item--error">
                    <h2>Ошибки заполнения формы</h2>
                    <?php foreach ($errors as $attribute => $messages) : ?>
                        <h3><?= $model->attributeLabels()[$attribute]; ?></h3>
                        <?php foreach ($messages as $message) : ?>
                            <p><?= $message ?></p>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <button class="button" onclick="document.getElementById('task-form').submit();">Опубликовать</button>

</section>
