<?php use yii\helpers\Url;

if ($user['usersReviews']) : ?>
    <h2>Отзывы <span><?= count($user['usersReviews']) ?></span></h2>
    <?php foreach ($user['usersReviews'] as $review) : ?>
        <div class="content-view__feedback-wrapper reviews-wrapper">
            <div class="feedback-card__reviews">
                <p class="link-task link">Задание <a href="<?= Url::to(['/tasks/show', 'id' => $review['task_id']]); ?>"
                                                     class="link-regular">
                        <?= $review['taskTitle'] ?> </a>
                </p>
                <div class="card__review">
                    <a href="#"><img src="../img/<?= $review['customerPhoto'] ?>" width="55" height="54"></a>
                    <div class="feedback-card__reviews-content">
                        <p class="link-name link">
                            <a href="<?= Url::to(['users/show', 'id' => $review['user_customer_id']]); ?>"
                               class="link-regular"><?= $review['customerName'] ?></a>
                        </p>
                        <p class="review-text">
                            <?= $review['review'] ?>
                        </p>
                    </div>
                    <div class="card__review-rate">
                        <p class="five-rate big-rate"><?= $review['vote'] ?><span></span></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <h2>Отзывов нет</h2>
<?php endif; ?>