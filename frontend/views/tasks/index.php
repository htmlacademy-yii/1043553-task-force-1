<section class="new-task">
    <div class="new-task__wrapper">
        <h1>Новые задания</h1>
        <?= $this->render('/tasks/components/tasks', ['data' => $data]);?>
    </div>
    <?= $this->render('/tasks/components/pagination');?>
</section>
<section class="search-task">
    <?= $this->render('/tasks/components/tasksFilterForm', ['model' => $model]);?>
</section>