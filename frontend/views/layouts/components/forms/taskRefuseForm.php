<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<section class="modal form-modal refusal-form" id="refuse-form">
    <h2>Отказ от задания</h2>
    <p>Вы собираетесь отказаться от выполнения задания. Это действие приведёт к снижению вашего рейтинга. Вы
        уверены?</p>
    <button class="button__form-modal button" id="close-modal-refuse" type="button">Закрыть</button>

    <?php ActiveForm::begin(['action' => Url::to(["/task-action/refuse?taskId=" . $this->context->taskId])]); ?>
    <button class="button__form-modal refusal-button button" type="submit">Отказаться</button>
    <?php ActiveForm::end(); ?>

    <button class="form-modal-close" type="button">Закрыть</button>
</section>