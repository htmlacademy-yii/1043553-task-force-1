<section class="content-view main-container">
    <?= $this->render('../components/userProfile', ['user' => $user]);?>
    <div class="content-view__feedback">
        <?= $this->render('../components/reviews', ['user' => $user]);?>
    </div>
</section>
<section class="connect-desk">
    <div class="connect-desk__chat">

    </div>
</section>