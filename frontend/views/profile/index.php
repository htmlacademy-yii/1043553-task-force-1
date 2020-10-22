<?php

use frontend\widgets\DropzoneWidget;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$fieldConfig = [
    'template' => '{label}{input}{error}',
    'options' => ['tag' => false],
]; ?>

<div class="main-container page-container">
    <section class="account__redaction-wrapper">
        <h1>Редактирование настроек профиля</h1>
        <?php $form = ActiveForm::begin([
            'enableClientValidation' => false,
            'options' => ['enctype' => 'multipart/form-data', 'id' => 'profileForm'],
            'action' => 'profile/update'
        ]); ?>
        <div class="account__redaction-section">
            <h3 class="div-line">Настройки аккаунта</h3>
            <div class="account__redaction-section-wrapper">
                <div class="account__redaction-avatar">
                    <img src="/avatars/<?= $user->avatar ?? \frontend\models\User::DEFAULT_USER_PHOTO ?>" width="156"
                         height="156">
                    <?= $form->field($model, 'avatar', [
                        'template' => '{input}{label}{error}',
                        'options' => ['tag' => false],
                    ])
                        ->fileInput([
                            'id' => 'upload-avatar',
                            'class' => ($model->hasErrors('avatar') ? 'field-danger'
                                : ''),
                        ])
                        ->label(null, ['class' => 'link-regular'])
                        ->error(['class' => 'text-danger']); ?>
                    <p id="avatarErrorMessage" style="color: red; display: none;"></p>
                </div>
                <div class="account__redaction">
                    <div class="account__input account__input--name">
                        <?= $form->field($model, 'name', $fieldConfig)
                            ->textInput([
                                'class' => 'input textarea '
                                    . ($model->hasErrors('name') ? 'field-danger'
                                        : ''),
                                'value' => Html::encode($user['name']),
                            ])->error(['class' => 'text-danger']); ?>
                        <p id="nameErrorMessage" style="color: red; display: none;"></p>
                    </div>
                    <div class="account__input account__input--email">
                        <?= $form->field($model, 'email', $fieldConfig)
                            ->textInput([
                                'class' => 'input textarea '
                                    . ($model->hasErrors('email') ? 'field-danger'
                                        : ''),
                                'value' => Html::encode($user['email']),
                            ])->error(['class' => 'text-danger']); ?>
                        <p id="emailErrorMessage" style="color: red; display: none;"></p>
                    </div>
                    <div class="account__input account__input--name">
                        <?= $form->field($model, 'cityId', $fieldConfig)
                            ->dropDownList($cities, [
                                'class' => 'multiple-select input multiple-select-big '
                                    . ($model->hasErrors('cityId') ? 'field-danger'
                                        : ''),
                                'size' => 1,
                                'options' => [
                                    $user['city_id'] ?? 1 => ['selected' => true],
                                ],
                            ])->error(['class' => 'text-danger']); ?>
                    </div>
                    <div class="account__input account__input--date">
                        <?= $form->field($model, 'birthday', $fieldConfig)
                            ->input('date',
                                [
                                    'class' => 'input-middle input input-date '
                                        . ($model->hasErrors('birthday')
                                            ? 'field-danger' : ''),
                                    'value' => Html::encode($user['birthday']
                                        ?? ''),
                                ])->error(['class' => 'text-danger']); ?>
                        <p id="birthdayErrorMessage" style="color: red; display: none;"></p>
                    </div>
                    <div class="account__input account__input--info">
                        <?= $form->field($model, 'description', $fieldConfig)
                            ->textarea([
                                'class' => 'input textarea '
                                    . ($model->hasErrors('description')
                                        ? 'field-danger' : ''),
                                'rows' => 7,
                                'value' => Html::encode($user['description']
                                    ?? ''),
                            ])->error(['class' => 'text-danger']); ?>
                    </div>
                </div>
            </div>
            <h3 class="div-line">Выберите свои специализации</h3>
            <div class="account__redaction-section-wrapper">
                <?= $form->field($model, 'categories')
                    ->checkboxList($categories, [
                        'item' => function (
                            $_index,
                            $label,
                            $name,
                            $checked,
                            $id
                        ) use ($user) {
                            $checked = in_array($id, $user->selectedCategories)
                                ? 'checked' : '';

                            return "<input
                                class='visually-hidden checkbox__input'
                                type='checkbox'
                                name='$name'
                                id='category-$id'
                                value='$id'
                                $checked>
                                <label for='category-$id'>$label</label>";
                        },
                        'tag' => 'div',
                        'class' => 'search-task__categories account_checkbox--bottom',
                    ])->label(false)->error(['class' => 'text-danger']); ?>
            </div>
            <h3 class="div-line">Безопасность</h3>
            <div class="account__redaction-section-wrapper account__redaction">
                <div class="account__input">
                    <?= $form->field($model, 'password', $fieldConfig)
                        ->input('password', [
                            'class' => 'input textarea '
                                . ($model->hasErrors('password') ? 'field-danger'
                                    : ''),
                        ])
                        ->error(['class' => 'text-danger']); ?>
                    <p id="passwordErrorMessage" style="color: red; display: none;"></p>
                </div>
                <div class="account__input">
                    <?= $form->field($model, 'confirmedPassword', $fieldConfig)
                        ->input('password', [
                            'class' => 'input textarea '
                                . ($model->hasErrors('confirmedPassword') ? 'field-danger'
                                    : ''),
                        ])
                        ->error(['class' => 'text-danger']); ?>
                </div>
            </div>

            <h3 class="div-line">Фото работ</h3>
            <?php foreach (Yii::$app->user->identity->portfolio as $photo): ?>
                <a href="#"><img src="../../portfolios/<?=$photo->photo ?>" width="85" height="86" alt="Фото работы"></a>
            <?php endforeach; ?>
            <div class="account__redaction-section-wrapper account__redaction">
                <span class="dropzone">Выбрать фотографии</span>
            </div>

            <?php if (isset($user->photos)): ?>
                <div id="photo-block">
                    <?php foreach ($user->photos as $item): ?>
                        <img src="<?= $item->photo; ?>"
                             style="width: 120px; height: 120px;">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <h3 class="div-line">Контакты</h3>
            <div class="account__redaction-section-wrapper account__redaction">
                <div class="account__input">
                    <?= $form->field($model, 'phone', $fieldConfig)
                        ->input('tel', [
                            'class' => 'input textarea ' . ($model->hasErrors('phone')
                                    ? 'field-danger' : ''),
                            'value' => Html::encode($user['phone']),
                        ])->error(['class' => 'text-danger']); ?>
                    <p id="phoneErrorMessage" style="color: red; display: none;"></p>
                </div>
                <div class="account__input">
                    <?= $form->field($model, 'skype', $fieldConfig)
                        ->textInput([
                            'class' => 'input textarea ' . ($model->hasErrors('skype')
                                    ? 'field-danger' : ''),
                            'value' => Html::encode($user['skype']),
                        ])->error(['class' => 'text-danger']); ?>
                    <p id="skypeErrorMessage" style="color: red; display: none;"></p>
                </div>
                <div class="account__input">
                    <?= $form->field($model, 'other_app', $fieldConfig)
                        ->textInput([
                            'class' => 'input textarea '
                                . ($model->hasErrors('otherMessenger')
                                    ? 'field-danger' : ''),
                            'value' => Html::encode($user['other_app']),
                        ])->error(['class' => 'text-danger']); ?>
                    <p id="otherAppErrorMessage" style="color: red; display: none;"></p>
                </div>
            </div>
            <h3 class="div-line">Настройки сайта</h3>
            <h4>Уведомления</h4>
            <div class="account__redaction-section-wrapper account_section--bottom">
                <div class="search-task__categories account_checkbox--bottom">
                    <?php $checkboxConfig = [
                        'template' => '{input}{label}',
                        'options' => ['tag' => false],
                    ]; ?>
                    <?= $form->field($model, 'notifications[new-message]',
                        $checkboxConfig)
                        ->checkbox([
                            'class' => 'visually-hidden checkbox__input',
                            'value' => true,
                            'id' => 'notifications-1',
                            'checked' => (bool)$user->msg_notification,
                        ], false)
                        ->label('Новое сообщение', ['for' => 'notifications-1']); ?>
                    <?= $form->field($model, 'notifications[task-actions]',
                        $checkboxConfig)
                        ->checkbox([
                            'class' => 'visually-hidden checkbox__input',
                            'value' => true,
                            'id' => 'notifications-2',
                            'checked' => (bool)$user->task_action_notification,
                        ], false)
                        ->label('Действия по заданию',
                            ['for' => 'notifications-2']); ?>
                    <?= $form->field($model, 'notifications[new-review]',
                        $checkboxConfig)
                        ->checkbox([
                            'class' => 'visually-hidden checkbox__input',
                            'value' => true,
                            'id' => 'notifications-3',
                            'checked' => (bool)$user->review_notification,
                        ], false)
                        ->label('Новый отзыв', ['for' => 'notifications-3']); ?>
                </div>

                <div
                        class="search-task__categories account_checkbox account_checkbox--secrecy">
                    <?= $form->field($model, 'settings[show-only-client]',
                        $checkboxConfig)
                        ->checkbox([
                            'class' => 'visually-hidden checkbox__input',
                            'value' => true,
                            'id' => 'settings-1',
                            'checked' => (bool)$user->hide_contacts,
                        ], false)
                        ->label('Показывать мои контакты только заказчику',
                            ['for' => 'settings-1']); ?>
                    <?= $form->field($model, 'settings[hidden-profile]',
                        $checkboxConfig)
                        ->checkbox([
                            'class' => 'visually-hidden checkbox__input',
                            'value' => true,
                            'id' => 'settings-2',
                            'checked' => (bool)$user->hide_profile,
                        ], false)
                        ->label('Не показывать мой профиль',
                            ['for' => 'settings-2']); ?>
                </div>
            </div>
        </div>
        <a id="formSubmit" class="button">Сохранить изменения</a>
        <?php ActiveForm::end(); ?>
    </section>
</div>