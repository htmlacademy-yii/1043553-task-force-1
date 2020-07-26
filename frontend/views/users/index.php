<?php // var_dump($usersData)
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<section class="user__search">
    <div class="user__search-link">
        <p>Сортировать по:</p>
        <ul class="user__search-list">
            <li class="user__search-item user__search-item--current">
                <a href="#" class="link-regular">Рейтингу</a>
            </li>
            <li class="user__search-item">
                <a href="#" class="link-regular">Числу заказов</a>
            </li>
            <li class="user__search-item">
                <a href="#" class="link-regular">Популярности</a>
            </li>
        </ul>
    </div>
    <?php foreach ($data as $user) : ?>
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
                    <?= $this->render('../components/stars', ['vote' => $user['vote']]); ?>
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
</section>
<section class="search-task">
    <div class="search-task__wrapper">

        <?php $form = yii\widgets\ActiveForm::begin([
            'options' => [
                'class' => 'search-task__form',
                'name' => $model->formName()
            ]
        ]); ?>
        <fieldset class="search-task__categories">
            <legend>Категории</legend>
            <?php

            echo $form->field($model, 'categories')->checkboxList(
                $model->categoriesFields(),
                [
                    'tag' => false,
                    'itemOptions' => [

                    ]
                ]
            )->label(false);

            ?>
        </fieldset>

        <fieldset class="search-task__categories">
            <legend>Дополнительно</legend>
            <?php

            echo $form->field($model, 'additional')->checkboxList(
                $model->additionalFields(),
                [
                    'tag' => false,
                    'itemOptions' => [

                    ]
                ]
            )->label(false); ?>
        </fieldset>


        <label class="search-task__name" for="search"><?= $model->searchField(); ?></label>
        <?php $options = [
            'class' => 'input-middle input',
            'id' => 'search',
            'tag' => false
        ]; ?>
        <?= $form->field($model, 'search', ['template' => "{label}\n{input}"])->input('text',
            $options)->label(false); ?>

        <?= yii\helpers\Html::submitButton('Искать', ['class' => 'button']) ?>
        <?php yii\widgets\ActiveForm::end(); ?>

    </div>
</section>

