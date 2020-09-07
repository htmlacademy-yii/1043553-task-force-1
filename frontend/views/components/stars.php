<?php if ($vote) : ?>
    <?php for ($i = 1; $i <= floor($vote); $i++) : ?>
        <span></span>
    <?php endfor; ?>
    <?php for ($i = 1; $i <= (5 - floor($vote)); $i++) : ?>
        <span class="star-disabled"></span>
    <?php endfor; ?>
    <b><?= substr($vote, 0, 4); ?></b>
<?php else : ?>
    <p> пока нет отзывов</p>
<?php endif; ?>
