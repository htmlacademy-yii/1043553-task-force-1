<?php

use yii\widgets\LinkPager;

?>
<div class="new-task__pagination">
    <?=
    LinkPager::widget([
        'pagination' => $pages,
        'options' => ['class' => 'new-task__pagination-list'],
        'pageCssClass' => 'pagination__item',
        'prevPageCssClass' => 'pagination__item',
        'prevPageLabel' => '&nbsp',
        'nextPageCssClass' => 'pagination__item',
        'nextPageLabel' => '&nbsp',
        'activePageCssClass' => 'pagination__item--current',
        'linkOptions' => ['class' => 'pagination__item--link']

    ]); ?>
</div>