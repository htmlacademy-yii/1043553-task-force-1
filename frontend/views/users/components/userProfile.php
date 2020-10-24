<div class="user__card-wrapper">
    <div class="user__card">
        <img src="../../avatars/<?= $user['photo'] ?>" width="120" height="120" alt="Аватар пользователя">
        <div class="content-view__headline">
            <h1><?= $user['name'] ?></h1>
            <p>Россия, Санкт-Петербург,
                <?= $user['age']; ?></p>
            <div class="profile-mini__name five-stars__rate">
                <?= $this->render('../../components/stars',
                    ['vote' => $user['vote']]); ?>
            </div>
            <b class="done-task">Выполнил <?= $user['tasksCount'] ?> заказов</b>
            <b class="done-review">Получил <?= count($user['usersReviews']) ?> отзывов</b>
        </div>
        <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
            <span>Был на сайте <?= $user['last_active'] ?></span>
            <a href="#"><b></b></a>
        </div>
    </div>
    <div class="content-view__description">
        <p><?= $user['description']; ?></p>
    </div>
    <div class="user__card-general-information">
        <div class="user__card-info">
            <h3 class="content-view__h3">Специализации</h3>
            <div class="link-specialization">
                <?php if ($user['selectedCategories']) : ?>
                    <?php foreach ($user['selectedCategories'] as $category) : ?>
                        <a href="#" class="link-regular"><?= $category['name'] ?></a>
                    <?php endforeach;
                else :
                    ?>
                    <p class="">специализаций нет</p>
                <?php endif; ?>
            </div>
            <h3 class="content-view__h3">Контакты</h3>
            <div class="user__card-link">
                <a class="user__card-link--tel link-regular" href="#"><?= $user['phone'] ?></a>
                <a class="user__card-link--email link-regular" href="#"><?= $user['email'] ?></a>
                <a class="user__card-link--skype link-regular" href="#"><?= $user['skype'] ?></a>
            </div>
        </div>
        <?php if ($user['userPhotos']) : ?>
            <div class="user__card-photo">
                <h3 class="content-view__h3">Фото работ</h3>
                <?php foreach ($user['userPhotos'] as $photo) : ?>
                    <a href="#"><img src="../../portfolios/<?=$photo->photo ?>" width="85" height="86" alt="Фото работы"></a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>