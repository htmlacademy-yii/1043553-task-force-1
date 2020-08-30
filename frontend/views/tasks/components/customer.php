<?php

use yii\helpers\Url;

?>
<div class="connect-desk__profile-mini">
    <div class="profile-mini__wrapper">
        <h3>Заказчик</h3>
        <div class="profile-mini__top">
            <img src="../img/<?= $customer['photo'] ?>" width="62" height="62"
                 alt="Аватар заказчика">
            <div class="profile-mini__name five-stars__rate">
                <a class="link-regular" href="<?= Url::to(['/users/show', 'id' => $customer['id']]); ?>"><p><?= $customer['name'] ?></p></a>
            </div>
        </div>
        <p class="info-customer"><span><?= count($customer['tasks']) ?> заданий</span>
            <span class="last-"> Зарегистрирован на сайте <?= $customer['created_at'] ?></span>
        </p>
        <a href="#" class="link-regular">Смотреть профиль</a>
    </div>
</div>