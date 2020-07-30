<section class="content-view">
    <div class="content-view__card">
        <?= $this->render('../components/taskDescription', ['task' => $task]);?>
        <?= $this->render('../components/actionButtons'); ?>
    </div>
    <?= $this->render('../components/responses', ['responses' => $responses]); ?>
</section>
<section class="connect-desk">
    <?= $this->render('../components/customer', ['customer' => $customer]); ?>
    <?= $this->render('../components/chat'); ?>
</section>