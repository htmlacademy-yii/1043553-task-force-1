<div class="main-container page-container">
    <?= $this->render('/tasks-history/components/menu');?>
    <?= $this->render('/tasks-history/components/tasks', ['tasks' => $tasks]);?>
</div>