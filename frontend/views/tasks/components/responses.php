<?php

use yii\helpers\Url;

?>

<div class="content-view__feedback">
    <?php if ($responses) : ?>
        <h2>Отклики <span><?= count($responses) ?></span></h2>
        <div class="content-view__feedback-wrapper">
            <?php foreach ($responses as $response) : ?>
                <div class="content-view__feedback-card">
                    <div class="feedback-card__top">
                        <a href="#"><img src="../../img/<?= $response['userEmployee']['photo'] ?>"
                                         width="55" height="55">
                        </a>
                        <div class="feedback-card__top--name">
                            <p>
                                <a href="<?= Url::to(['users/show', 'id' => $response['user_employee_id']]); ?>"
                                   class="link-regular"><?= $response['userEmployee']['name'] ?></a>
                            </p>

                            <?=
                            $this->render(
                                '../../components/stars',
                                ['vote' => $response['userEmployee']['vote']]
                            );
                            ?>

                        </div>
                        <span class="new-task__time"><?= $response['created_at'] ?></span>
                    </div>
                    <div class="feedback-card__content">
                        <p>
                            <?= $response['comment'] ?>
                        </p>
                        <span><?= $response['your_price'] ?></span>
                    </div>
                    <?php if ($response['actionButtonsAreVisible']) : ?>
                        <div class="feedback-card__actions">
                            <a class="button__small-color request-button button"
                               type="button" href="<?= Url::to([
                                'response-action/approve',
                                'id' => $response['id']
                            ]); ?>">Подтвердить</a>
                            <a class="button__small-color refusal-button button"
                               type="button" href="<?= Url::to([
                                'response-action/deny',
                                'id' => $response['id']
                            ]); ?>">Отказать</a>
                        </div>
                    <?php else : ?>
                        <div style="display: flex; align-items: center">
                            <p>
                                <?= $response['status'] ?>
                            </p>
                            <?php if (\frontend\models\Response::authorisedUserIsResponseCreator($response)): ?>
                                <a href="<?= Url::to([
                                    'response-action/delete',
                                    'id' => $response['id']
                                ]); ?>" style="color:red;">Удалить</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <h2>Откликов пока нет</h2>
    <?php endif; ?>
</div>