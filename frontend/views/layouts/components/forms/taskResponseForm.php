<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<section class="modal response-form form-modal" id="response-form">
    <h2>Отклик на задание</h2>

    <?php $form = ActiveForm::begin([
        'action' => Url::to(["/task/" . $this->context->taskId . "/reply"]),
        'options' => [
            'name' => $this->context->taskResponseForm->formName()
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

    <button class="button modal-button" type="submit">Отправить</button>

    <?php ActiveForm::end(); ?>

    <button class="form-modal-close" type="button">Закрыть</button>
</section>