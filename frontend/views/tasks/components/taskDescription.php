<div class="content-view__card-wrapper">
    <div class="content-view__header">
        <div class="content-view__headline">
            <h1><?= $task['title']; ?></h1>
            <span>Размещено в категории
                                    <a href="#" class="link-regular"><?= $task['category']; ?></a>
                                    <?= $task['created_at']; ?></span>
        </div>
        <b class="new-task__price new-task__price--<?= $task['image']; ?> content-view-price"><?= $task['budget']; ?>
            ₽</b>
        <div class="new-task__icon new-task__icon--<?= $task['image']; ?> content-view-icon"></div>
    </div>
    <div class="content-view__description">
        <h3 class="content-view__h3">Общее описание</h3>
        <p>
            <?= $task['description']; ?>
        </p>
    </div>
    <div class="content-view__attach">
        <?php
        if ($task['tasksFiles']) : ?>
            <h3 class="content-view__h3">Вложения</h3>
            <?php foreach ($task['tasksFiles'] as $file) : ?>
                <a href="#"><?php var_dump($file) ?></a>
            <?php endforeach;
        else : ?>
            <h3 class="content-view__h3">Вложений нет</h3>
        <?php endif; ?>
    </div>
    <?php if ($task['address']) : ?>
        <div class="content-view__location">
            <h3 class="content-view__h3">Расположение</h3>
            <div class="content-view__location-wrapper">
                <div class="content-view__map" id="map" style="width: 600px; height: 400px"></div>
                <div class="content-view__address">
                    <span><?= $task['address'] ?></span>
                </div>
            </div>
        </div>
    <?php else : ?>
        <h3 class="content-view__h3">Расположение не указано</h3>
    <?php endif; ?>
</div>