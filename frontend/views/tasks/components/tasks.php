<?php

use yii\helpers\Url;

foreach ($data as $task) : ?>
    <div class="new-task__card">
        <div class="new-task__title">
            <a href="<?= Url::to(['/tasks/show', 'id' => $task['id']]); ?>" class="link-regular">
                <h2><?= $task["title"] ?></h2></a>
            <a class="new-task__type link-regular" href="#"><p><?= $task->category ?></p></a>
        </div>
        <div class="new-task__icon new-task__icon--<?= $task["image"] ?>"></div>
        <p class="new-task_description">
            <?= $task["description"] ?>
        </p>
        <b class="new-task__price new-task__price--translation"><?= $task["budget"] ?><b>₽</b></b>
        <p class="new-task__place"><?= $task->city ?></p>
        <span class="new-task__time"><?= $task["created_at"] ?></span>
    </div>
<?php endforeach; ?>