<section class="my-list">
    <div class="my-list__wrapper">
        <h1>Мои задания</h1>
        <?php use yii\helpers\Url;
        if($tasks): ?>
            <?php foreach ($tasks as $task): ?>
                <div class="new-task__card">
                    <div class="new-task__title">
                        <a href="<?= Url::to(['/tasks/show', 'id' => $task['id']]); ?>" class="link-regular">
                            <h2><?= $task['title'] ?></h2></a>
                        <a class="new-task__type link-regular" href="#"><p><?= $task['category'] ?></p></a>
                    </div>
                    <div class="task-status done-status"><?= $task['current_status'] ?></div>
                    <p class="new-task_description"><?= $task['description'] ?></p>
                    <?php if ($task['partner']) : ?>
                        <div class="feedback-card__top ">
                            <a href="#"><img src="../img/<?= $task['partner']['avatar'] ?>" width="36" height="36"></a>
                            <div class="feedback-card__top--name my-list__bottom">
                                <p class="link-name"><a
                                            href="<?= Url::to(['/users/show', 'id' => $task['partner']['id']]); ?>"
                                            class="link-regular"><?= $task['partner']['name'] ?></a>
                                </p>
                                <a href="#" class="my-list__bottom-chat  my-list__bottom-chat--new"><b>><?= $task['newMessages']?></b></a>
                                <?= $this->render('../../components/stars', ['vote' => $task['partner']['vote']]); ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <p>у задания пока нет исполнителя</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Пока нет заданий в этом статусе</p>
        <?php endif; ?>
    </div>
</section>