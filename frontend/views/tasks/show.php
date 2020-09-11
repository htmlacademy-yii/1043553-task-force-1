<section class="content-view">
    <div class="content-view__card">
        <?= $this->render('/tasks/components/taskDescription', ['task' => $task]); ?>
        <?php if ($actionButtonIsVisible) : ?>
            <?= $this->render('/tasks/components/actionButtons', ['actionButton' => $actionButton]); ?>
        <?php endif; ?>
    </div>
    <b><?= 'Статус заказа : '. \frontend\components\task\TaskStatusComponent::detectTaskStatus($task) ?></b>
    <?php if ($showResponses) : ?>
        <?= $this->render('/tasks/components/responses',
            ['responses' => $responses]); ?>
    <?php endif; ?>
</section>
<section class="connect-desk">
    <?= $this->render('/tasks/components/customer', ['customer' => $customer]); ?>
    <?= $this->render('/tasks/components/chat'); ?>
</section>