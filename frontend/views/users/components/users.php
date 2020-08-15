<?php

use yii\helpers\Url;

foreach ($data as $user) :?>
    <div class="content-view__feedback-card user__search-wrapper">
        <div class="feedback-card__top">
            <div class="user__search-icon">
                <a href="#"><img src="./img/<?= $user['photo'] ?>" width="65" height="65"></a>
                <span><?= $user['tasksCount'] ?> заданий</span>
                <span><?= $user['reviewsCount'] ?> отзывов</span>
            </div>
            <div class="feedback-card__top--name user__search-card">
                <p class="link-name">
                    <a href="<?= Url::to(['users/show', 'id' => $user['id']]); ?>"
                       class="link-regular"><?php echo $user['name'] ?>
                    </a>
                </p>
                <?= $this->render('../../components/stars', ['vote' => $user['vote']]); ?>
                <p class="user__search-content">
                    <?= $user['description'] ?>
                </p>
            </div>
            <span class="new-task__time">Был на сайте <?php echo $user['last_active'] ?></span>
        </div>
        <div class="link-specialization user__search-link--bottom">
            <?php foreach ($user['categories'] as $category) : ?>
                <a href="#" class="link-regular"><?= $category['name']; ?></a>
            <?php endforeach; ?>
            <a href="#" class="link-regular">Ремонт</a>
            <a href="#" class="link-regular">Курьер</a>
            <a href="#" class="link-regular">Оператор ПК</a>
        </div>
    </div>
<?php endforeach; ?>