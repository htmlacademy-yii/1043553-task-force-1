<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<section class="registration__user">
    <h1>Регистрация аккаунта</h1>
    <?php

    var_dump($_POST);

    $form = ActiveForm::begin([
        'id' => 'user-signup-form',
        'options' => [
            'class' => 'registration__user-form form-create',
            'name' => $model->formName()
        ],
        'fieldConfig' => [
            'options' => [
                'tag' => false
            ]
        ]
    ]); ?>

    <label for="email"><?= $model->attributeLabels()['email']; ?></label>
    <?php $options = [
        'class' => 'input textarea',
        'rows' => '1',
        'id' => 'email',
        'tag' => false
    ]; ?>
    <?= $form->field($model, 'email', ['template' => "{label}\n{input}"])->input('textarea', $options)->label(false); ?>
    <span>Введите валидный адрес электронной почты</span>

    <label for="name"><?= $model->attributeLabels()['name']; ?></label>
    <?php $options = [
        'class' => 'input textarea',
        'rows' => '1',
        'id' => 'name',
        'tag' => false
    ]; ?>
    <?= $form->field($model, 'name', ['template' => "{label}\n{input}"])->input('textarea',
        $options)->label(false); ?>
    <span>Введите ваше имя и фамилию</span>

    <label for="city"><?= $model->attributeLabels()['city']; ?></label>
    <?php $options = [
        'class' => 'multiple-select input town-select registration-town',
        'size' => '1',
        'id' => 'city',
        'tag' => false
    ]; ?>
    <?= $form->field($model, 'city', ['template' => "{label}\n{input}"])->dropDownList($items,
        $options)->label(false); ?>
    <span>Укажите город, чтобы находить подходящие задачи</span>

    <label for="password"><?= $model->attributeLabels()['password']; ?></label> <!--class="input-danger"-->
    <?php $options = [
        'class' => 'input textarea',
        'rows' => '1',
        'id' => 'password',
        'tag' => false
    ]; ?>
    <?= $form->field($model, 'password', ['template' => "{label}\n{input}"])->input('password',
        $options)->label(false); ?>
    <span>Длина пароля от 8 символов</span>
    <span><?= Html::error($model, 'email'); ?></span>
    <!--
        <button class="button button__registration" type="submit">Cоздать аккаунт</button>-->
    <?= Html::submitButton('Cоздать аккаунт', ['class' => 'button button__registration']) ?>

    <?= var_dump($form->errorCssClass); ?>

    <?php ActiveForm::end(); ?>
</section>
<!--<div class="registration-wrapper">
    <form class="registration__user-form form-create">
        <label for="16">Электронная почта</label>
        <textarea class="input textarea" rows="1" id="16" name="" placeholder="kumarm@mail.ru"></textarea>
        <span>Введите валидный адрес электронной почты</span>
        <label for="17">Ваше имя</label>
        <textarea class="input textarea" rows="1" id="17" name="" placeholder="Мамедов Кумар"></textarea>
        <span>Введите ваше имя и фамилию</span>
        <label for="18">Город проживания</label>
        <select id="18" class="multiple-select input town-select registration-town" size="1" name="town[]">
            <option value="Moscow">Москва</option>
            <option selected value="SPB">Санкт-Петербург</option>
            <option value="Krasnodar">Краснодар</option>
            <option value="Irkutsk">Иркутск</option>
            <option value="Bladivostok">Владивосток</option>
        </select>
        <span>Укажите город, чтобы находить подходящие задачи</span>
        <label class="input-danger" for="19">Пароль</label>
        <input class="input textarea " type="password" id="19" name="">
        <span>Длина пароля от 8 символов</span>
        <button class="button button__registration" type="submit">Cоздать аккаунт</button>
    </form>
</div>-->
