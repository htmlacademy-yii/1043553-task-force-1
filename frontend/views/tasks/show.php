<section class="content-view">
    <div class="content-view__card">
        <?= $this->render('/tasks/components/taskDescription', ['task' => $task]); ?>
        <?= $this->render('/tasks/components/actionButtons', ['actionButton' => $actionButton]); ?>
    </div>
    <?= var_dump($showResponses) ?>
    <?php if ($showResponses) : ?>
        <?= $this->render('/tasks/components/responses',
            ['responses' => $responses, 'userRole' => $userRole]); ?>
    <?php endif; ?>
</section>
<section class="connect-desk">
    <?= $this->render('/tasks/components/customer', ['customer' => $customer]); ?>
    <?= $this->render('/tasks/components/chat'); ?>
</section>