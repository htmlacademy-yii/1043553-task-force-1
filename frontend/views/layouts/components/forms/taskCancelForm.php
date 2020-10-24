<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<section class="modal form-modal refusal-form" id="cancel-form">
    <h2>Отмена задания</h2>
    <p>Вы собираетесь отменить задание. Это действие приведёт к невозможности его исполнения. Вы уверены?</p>
    <button class="button__form-modal button" id="close-modal-cancel" type="button">Закрыть</button>

    <?php ActiveForm::begin(['action' => Url::to(["/task-action/cancel?taskId=" . \Yii::$app->request->get('id')])]); ?>
    <button class="button__form-modal refusal-button button" type="submit">Отменить</button>
    <?php ActiveForm::end(); ?>

    <button class="form-modal-close" type="button">Закрыть</button>
</section>