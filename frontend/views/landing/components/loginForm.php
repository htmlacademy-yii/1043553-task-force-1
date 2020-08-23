<?php
use yii\widgets\ActiveForm;
$form = ActiveForm::begin([
    'options' => [
        'id' => 'loginForm',
        'name' => $this->context->model->formName(),
        'enableAjaxValidation' => true,
        'validationUrl' => '/landing',
        'action' => 'index',
        'method' => 'POST'
    ],
    'fieldConfig' => [
        'options' => [
            'tag' => false
        ]
    ]
]); ?>

<p>
    <label class="form-modal-description"
           for="enter-email"><?= $this->context->model->attributeLabels()['email']; ?></label>
    <?php $options = [
        'class' => 'enter-form-email input input-middle',
        'id' => 'enter-email',
        'tag' => false
    ]; ?>
    <?= $form->field($this->context->model, 'email', ['template' => "{label}\n{input}"])->input('email',
        $options)->label(false); ?>
</p>
<p id='errorMessage' style="margin: -35px 0 0 90px; width: max-content; color: red; display: none "></p>
<p>
    <label class="form-modal-description"
           for="enter-password"><?= $this->context->model->attributeLabels()['password']; ?></label>
    <?php $options = [
        'class' => 'enter-form-email input input-middle',
        'id' => 'enter-password',
        'tag' => false
    ]; ?>
    <?= $form->field($this->context->model, 'password', ['template' => "{label}\n{input}"])->input('password',
        $options)->label(false); ?>
</p>

<a class="button" id="loginSubmit">Войти</a>

<?php ActiveForm::end(); ?>
<button class="form-modal-close" type="button">Закрыть</button>