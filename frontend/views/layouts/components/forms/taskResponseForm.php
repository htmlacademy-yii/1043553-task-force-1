<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<section class="modal response-form form-modal" id="response-form">


    <h2>Отклик на задание</h2>

    <?php $form = ActiveForm::begin([
        'action' => Url::to(["/task-action/respond?taskId=" . $this->context->taskId]),
        'options' => [
            'name' => $this->context->taskResponseForm->formName(),
            'id' => 'taskResponseForm',
            'enableAjaxValidation' => true,
            'validationUrl' => "/task-action/respond?taskId=" . $this->context->taskId,
            'action' => 'index',
            'method' => 'POST'
        ],
        'fieldConfig' => [
            'options' => [
                'tag' => 'p'
            ]
        ]
    ]); ?>

    <?php $inputOptions = [
        'class' => 'response-form-payment input input-middle input-money',
        'id' => 'response-payment'
    ];
    $labelOptions = [
        'class' => 'form-modal-description',
        'for' => 'response-payment'
    ]; ?>
    <?= $form->field($this->context->taskResponseForm, 'price', ['template' => "{label}\n{input}"])->input('text',
        $inputOptions)->label(null, $labelOptions); ?>

    <p id='errorMessagePrice' style=" width: max-content; color: red; display: none "></p>

    <?php $inputOptions = [
        'class' => 'input textarea',
        'id' => 'response-comment',
        'rows' => '4'
    ];
    $labelOptions = [
        'class' => 'form-modal-description',
        'for' => 'response-comment'
    ]; ?>
    <?= $form->field($this->context->taskResponseForm, 'comment',
        ['template' => "{label}\n{input}"])->textarea($inputOptions)->label(null, $labelOptions); ?>

    <p id='errorMessageComment' style="width: max-content; color: red; display: none "></p>
    <a class="button modal-button" id="taskResponseFormSubmit">Отправить</a>

    <?php ActiveForm::end(); ?>

    <button class="form-modal-close" type="button">Закрыть</button>



</section>