<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<section class="modal completion-form form-modal" id="complete-form">
    <h2>Завершение задания</h2>
    <p class="form-modal-description">Задание выполнено?</p>

    <?php $form = ActiveForm::begin([
        'action' => Url::to(["/task/" . $this->context->taskId . "/complete"]),
        'options' => [
            'name' => $this->context->taskCompleteForm->formName()
        ],
        'fieldConfig' => [
            'options' => [
                'tag' => false
            ]
        ]
    ]);
    ?>

    <?php $options = [
        'class' => 'visually-hidden completion-input completion-input--yes',
        'id' => 'completion-radio--yes',
        'value' => \frontend\models\Task::STATUS_ACCOMPLISHED_CODE,
        'checked' => ''
    ]; ?>
    <?= $form->field($this->context->taskCompleteForm, 'status', ['template' => "{input}\n{label}"])->input('radio',
        $options)->label(false); ?>
    <label class="completion-label completion-label--yes" for="completion-radio--yes">Да</label>

    <?php $options = [
        'class' => 'visually-hidden completion-input completion-input--difficult',
        'id' => 'completion-radio--yet',
        'value' =>  \frontend\models\Task::STATUS_FAILED_CODE
    ]; ?>
    <?= $form->field($this->context->taskCompleteForm, 'status', ['template' => "{input}\n{label}"])->input('radio',
        $options)->label(false); ?>
    <label class="completion-label completion-label--difficult" for="completion-radio--yet">Возникли проблемы</label>

    <p>
        <?php $inputOptions = [
            'class' => 'input textarea',
            'id' => 'completion-comment',
            'rows' => '4'
        ];
        $labelOptions = [
            'class' => 'form-modal-description',
            'for' => 'completion-comment'
        ]; ?>
        <?= $form->field($this->context->taskCompleteForm, 'comment',
            ['template' => "{label}\n{input}"])->textarea($inputOptions)->label(null, $labelOptions); ?>
    </p>

    <p class="form-modal-description">
        Оценка
    <div class="feedback-card__top--name completion-form-star">
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
    </div>
    </p>
    <?= $form->field($this->context->taskCompleteForm, 'rating',
        ['template' => "{label}\n{input}"])->hiddenInput(['id' => 'rating'])->label(false); ?>

    <button class="button modal-button" type="submit">Отправить</button>

    <?php ActiveForm::end(); ?>

    <button class="form-modal-close" type="button">Закрыть</button>
</section>