<div class="overlay">
    <?php if (isset($this->context->taskResponseForm)) : ?>
        <?= $this->render('/layouts/components/forms/taskResponseForm'); ?>
    <?php endif; ?>

    <?php if (isset($this->context->taskCompleteForm)) : ?>
        <?= $this->render('/layouts/components/forms/taskCompleteForm'); ?>
    <?php endif; ?>

    <?php if (isset($this->context->taskId)) : ?>
        <?= $this->render('/layouts/components/forms/taskRefuseForm'); ?>
    <?php endif; ?>

    <?php if (isset($this->context->taskId)) : ?>
        <?= $this->render('/layouts/components/forms/taskCancelForm'); ?>
    <?php endif; ?>

</div>