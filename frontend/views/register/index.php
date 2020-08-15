<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<section class="registration__user">
    <h1>Регистрация аккаунта</h1>

    <?php $form = ActiveForm::begin([
        'id' => 'user-signup-form',
        'options' => [
            'class' => 'registration__user-form form-create',
            'name' => $model->formName()
        ],
        'validateOnSubmit' => false,
        'fieldConfig' => [
            'options' => [
                'tag' => false
            ]
        ]
    ]); ?>

    <label for="email" class="<?php if (isset($errors['email'])) {
        echo 'input-danger';
    } ?>"><?= $model->attributeLabels()['email']; ?></label>
    <?php $options = [
        'class' => 'input textarea',
        'rows' => '1',
        'id' => 'email',
        'tag' => false,
        'value' => $values['email']
    ]; ?>
    <?= $form->field($model, 'email', ['template' => "{label}\n{input}"])->input('textarea', $options)->label(false); ?>
    <span><?= $fieldsDescriptions['email'] ?></span>

    <label for="name" class="<?php if (isset($errors['name'])) {
        echo 'input-danger';
    } ?>"><?= $model->attributeLabels()['name']; ?></label>
    <?php $options = [
        'class' => 'input textarea',
        'rows' => '1',
        'id' => 'name',
        'tag' => false,
        'value' => $values['name']
    ]; ?>
    <?= $form->field($model, 'name', ['template' => "{label}\n{input}"])->input('textarea',
        $options)->label(false); ?>
    <span><?= $fieldsDescriptions['name'] ?></span>

    <label for="city" class="<?php if (isset($errors['city'])) {
        echo 'input-danger';
    } ?>"><?= $model->attributeLabels()['city']; ?></label>
    <?php $options = [
        'class' => 'multiple-select input town-select registration-town',
        'size' => '1',
        'id' => 'city',
        'tag' => false,
        'selected ' => false,
        'value' => $values['city'],
    ]; ?>
    <?= $form->field($model, 'city', ['template' => "{label}\n{input}"])->dropDownList($cities,
        $options)->label(false); ?>
    <span><?= $fieldsDescriptions['city'] ?></span>

    <label for="password" class="<?php if (isset($errors['password'])) {
        echo 'input-danger';
    } ?>"><?= $model->attributeLabels()['password']; ?></label>
    <?php $options = [
        'class' => 'input textarea',
        'rows' => '1',
        'id' => 'password',
        'tag' => false,
        'value' => $values['password']
    ]; ?>
    <?= $form->field($model, 'password', ['template' => "{label}\n{input}"])->input('password',
        $options)->label(false); ?>
    <span><?= $fieldsDescriptions['password'] ?></span>


    <?= Html::submitButton('Cоздать аккаунт', ['class' => 'button button__registration']) ?>
    <?php ActiveForm::end(); ?>
</section>
