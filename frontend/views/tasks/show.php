<?php

use yii\helpers\Url;

?>
<section class="content-view">
    <div class="content-view__card">
        <div class="content-view__card-wrapper">
            <div class="content-view__header">
                <div class="content-view__headline">
                    <h1><?php echo $task['title']; ?></h1>
                    <span>Размещено в категории
                                    <a href="#" class="link-regular"><?php echo $task['category']['name']; ?></a>
                                    <?php echo $task['created_at']; ?></span>
                </div>
                <b class="new-task__price new-task__price--clean content-view-price"><?php echo $task['budget']; ?><b>
                        ₽</b></b>
                <div class="new-task__icon new-task__icon--clean content-view-icon"></div>
            </div>
            <div class="content-view__description">
                <h3 class="content-view__h3">Общее описание</h3>
                <p>
                    <?php echo $task['description']; ?>
                </p>
            </div>
            <div class="content-view__attach">
                <?php
                if ($task['tasksFiles']) : ?>
                    <h3 class="content-view__h3">Вложения</h3>
                    <?php foreach ($task['tasksFiles'] as $file) : ?>
                        <a href="#"><?php echo $file ?></a>
                    <?php endforeach;
                else : ?>
                    <h3 class="content-view__h3">Вложений нет</h3>
                <?php endif; ?>

            </div>
            <div class="content-view__location">
                <h3 class="content-view__h3">Расположение</h3>
                <div class="content-view__location-wrapper">
                    <div class="content-view__map">
                        <a href="#"><img src="./img/map.jpg" width="361" height="292"
                                         alt="Москва, Новый арбат, 23 к. 1"></a>
                    </div>
                    <div class="content-view__address">
                        <span class="address__town">Москва</span><br>
                        <span>Новый арбат, 23 к. 1</span>
                        <p>Вход под арку, код домофона 1122</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-view__action-buttons">
            <button class=" button button__big-color response-button open-modal"
                    type="button" data-for="response-form">Откликнуться
            </button>
            <button class="button button__big-color refusal-button open-modal"
                    type="button" data-for="refuse-form">Отказаться
            </button>
            <button class="button button__big-color request-button open-modal"
                    type="button" data-for="complete-form">Завершить
            </button>
        </div>
    </div>
    <div class="content-view__feedback">
        <?php if ($responses) : ?>
            <h2>Отклики <span><?php echo count($responses) ?></span></h2>
            <div class="content-view__feedback-wrapper">
                <?php foreach ($responses as $response) : ?>
                    <div class="content-view__feedback-card">
                        <div class="feedback-card__top">
                            <a href="#"><img src="../img/<?php echo $response['user_employee']['photo'] ?>"
                                             width="55" height="55">
                            </a>
                            <div class="feedback-card__top--name">
                                <p>
                                    <a href="<?= Url::to(['users/show', 'id' => $response['user_employee_id']]); ?>"
                                       class="link-regular"><?php echo $response['user_employee']['name'] ?></a>
                                </p>

                                <?=
                                $this->render('../components/stars',
                                    ['vote' => $response['user_employee']['vote']]);
                                ?>

                            </div>
                            <span class="new-task__time"><?php echo $response['created_at'] ?></span>
                        </div>
                        <div class="feedback-card__content">
                            <p>
                                <?php echo $response['comment'] ?>
                            </p>
                            <span><?php echo $response['your_price'] ?></span>
                        </div>
                        <div class="feedback-card__actions">
                            <a class="button__small-color request-button button"
                               type="button">Подтвердить</a>
                            <a class="button__small-color refusal-button button"
                               type="button">Отказать</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <h2>Откликов пока нет</h2>
        <?php endif; ?>
    </div>
</section>
<section class="connect-desk">
    <div class="connect-desk__profile-mini">
        <div class="profile-mini__wrapper">
            <h3>Заказчик</h3>
            <div class="profile-mini__top">
                <img src="../img/<?php echo $customer['photo'] ?>" width="62" height="62"
                     alt="Аватар заказчика">
                <div class="profile-mini__name five-stars__rate">
                    <p><?php echo $customer['name'] ?></p>
                </div>
            </div>
            <p class="info-customer"><span><?php echo count($customer['tasks']) ?> заданий</span>
                <span class="last-"> Зарегистрирован на сайте <?php echo $customer['created_at'] ?></span>
            </p>
            <a href="#" class="link-regular">Смотреть профиль</a>
        </div>
    </div>
    <div class="connect-desk__chat">
        <h3>Переписка</h3>
        <div class="chat__overflow">
            <div class="chat__message chat__message--out">
                <p class="chat__message-time">10.05.2019, 14:56</p>
                <p class="chat__message-text">Привет. Во сколько сможешь
                    приступить к работе?</p>
            </div>
            <div class="chat__message chat__message--in">
                <p class="chat__message-time">10.05.2019, 14:57</p>
                <p class="chat__message-text">На задание
                    выделены всего сутки, так что через час</p>
            </div>
            <div class="chat__message chat__message--out">
                <p class="chat__message-time">10.05.2019, 14:57</p>
                <p class="chat__message-text">Хорошо. Думаю, мы справимся</p>
            </div>
        </div>
        <p class="chat__your-message">Ваше сообщение</p>
        <form class="chat__form">
            <textarea class="input textarea textarea-chat" rows="2" name="message-text"
                      placeholder="Текст сообщения"></textarea>
            <button class="button chat__button" type="submit">Отправить</button>
        </form>
    </div>
</section>