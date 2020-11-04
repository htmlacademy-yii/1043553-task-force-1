<?php

use yii\widgets\LinkPager;

?>
<div class="new-task__pagination">
    <ul class="new-task__pagination-list">
        <li class="pagination__item"><a href="#"></a></li>
        <li class="pagination__item pagination__item--current">
            <a>1</a></li>
        <li class="pagination__item"><a href="#">2</a></li>
        <li class="pagination__item"><a href="#">3</a></li>
        <li class="pagination__item"><a href="#"></a></li>
    </ul>

    <?php
    var_dump($pages);

    echo LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>