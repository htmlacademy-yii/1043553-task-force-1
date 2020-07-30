<section class="new-task">
    <div class="new-task__wrapper">
        <h1>Новые задания</h1>
        <?= $this->render('../components/tasks', ['data' => $data]);?>
    </div>
    <?= $this->render('../components/pagination');?>
</section>
<section class="search-task">
    <?= $this->render('../components/tasksFilterForm', ['model' => $model]);?>
</section>