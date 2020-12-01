
<section class="user__search">
    <div class="user__search-link">
        <p>Сортировать по:</p>
        <?= $this->render('/users/components/usersSorting');?>
    </div>
    <?= $this->render('/users/components/users', ['data' => $data['usersList']]);?>
    <?= $this->render('/components/pagination', ['pages' => $data['pages']]); ?>
</section>
<section class="search-task">
    <?= $this->render('/users/components/usersFilterForm', ['model' => $model]);?>
</section>

