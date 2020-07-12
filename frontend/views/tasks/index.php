<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm; ?>

<section class="new-task">
    <div class="new-task__wrapper">
        <h1>Новые задания</h1>
        <?php foreach ($data as $task) : ?>
            <div class="new-task__card">
                <div class="new-task__title">
                    <a href="<?= Url::to(['/tasks/show', 'id' => $task['id']]); ?>" class="link-regular">
                        <h2><?php echo $task["title"] ?></h2></a>
                    <a class="new-task__type link-regular" href="#"><p><?php echo $task["category"] ?></p></a>
                </div>
                <div class="new-task__icon new-task__icon--<?php echo $task["image"] ?>"></div>
                <p class="new-task_description">
                    <?php echo $task["description"] ?>
                </p>
                <b class="new-task__price new-task__price--translation"><?php echo $task["budget"] ?><b>₽</b></b>
                <p class="new-task__place"><?php echo $task["city"] ?></p>
                <span class="new-task__time"><?php echo $task["created_at"] ?></span>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="new-task__pagination">
        <ul class="new-task__pagination-list">
            <li class="pagination__item"><a href="#"></a></li>
            <li class="pagination__item pagination__item--current">
                <a>1</a></li>
            <li class="pagination__item"><a href="#">2</a></li>
            <li class="pagination__item"><a href="#">3</a></li>
            <li class="pagination__item"><a href="#"></a></li>
        </ul>
    </div>
</section>
<section class="search-task">
    <div class="search-task__wrapper">

        <?php $form = ActiveForm::begin([
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

        <label class="search-task__name" for="period">Период</label>

        <?= $form->field($model, 'period', ['template' => "{label}\n{input}"])
            ->dropDownList(
                ['all' => 'За все время', 'day' => 'За день', 'week' => 'За неделю', 'month' => 'За месяц'],
                [
                    'class' => 'multiple-select input',
                    'id' => 'period',
                    'size' => '1'
                ]
            )->label(false); ?>

        <label class="search-task__name" for="search"><?= $model->searchField(); ?></label>
        <?php $options = [
            'class' => 'input-middle input',
            'id' => 'search',
            'tag' => false
        ]; ?>
        <?= $form->field($model, 'search', ['template' => "{label}\n{input}"])->input('text',
            $options)->label(false); ?>

        <?= Html::submitButton('Искать', ['class' => 'button']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</section>