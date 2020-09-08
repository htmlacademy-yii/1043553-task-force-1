<?php

use frontend\components\task\actions\ActionRespond;
use frontend\components\task\actions\ActionCancel;
use frontend\components\task\actions\ActionRefuse;
use frontend\components\task\actions\ActionAccomplish;

?>

<div class="content-view__action-buttons">
    <?php if ($actionButton === ActionRespond::ACTION_CODE) : ?>
        <button class="button button__big-color response-button open-modal" type="button" data-for="response-form">
            Откликнуться
        </button>
    <?php endif; ?>
    <?php if ($actionButton === ActionRefuse::ACTION_CODE) : ?>
        <button class="button button__big-color refusal-button open-modal" type="button" data-for="refuse-form">
            Отказаться
        </button>
    <?php endif; ?>
    <?php if ($actionButton === ActionCancel::ACTION_CODE) : ?>
        <button class="button button__big-color refusal-button open-modal" type="button" data-for="cancel-form">
            Отменить
        </button>
    <?php endif; ?>
    <?php if ($actionButton === ActionAccomplish::ACTION_CODE) : ?>
        <button class="button button__big-color request-button open-modal" type="button" data-for="complete-form">
            Завершить
        </button>
    <?php endif; ?>
</div>