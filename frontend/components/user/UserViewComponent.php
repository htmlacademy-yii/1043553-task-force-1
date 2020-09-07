<?php

namespace frontend\components\user;

use frontend\components\traits\QueriesTrait;
use frontend\models\forms\UsersFilterForm;
use yii\base\Component;

class UserViewComponent extends Component
{
    use QueriesTrait;

    private array $listOfUsers;
    private SelectedUserComponent $selectedUserComponent;
    public const DEFAULT_USER_PHOTO = 'default.jpg';
    public const NO_TASK_FOUND_MESSAGE = 'Отзыв добавлен без привязки к заданию';

    public function getDataForUserProfilePage(int $id): array
    {
        $user = $this->findUserWithPhotosAndCategories($id);
        $user = $this->selectedUserComponent->addDataRelatedToUser($user, $id);

        return ['user' => $user];
    }

    public function getDataForUsersPage(UsersFilterForm $model): array
    {
        $query = $this->findUsersQuery();
        $this->listOfUsers = UserFilterComponent::applyFilters($model, $query)->all();
        $this->listOfUsers = $this->selectedUserComponent->addRelatedDataForEachUser($this->listOfUsers);

        return $this->listOfUsers;
    }

    public function __construct($config = [])
    {
        $this->selectedUserComponent = new SelectedUserComponent();
        parent::__construct($config);
    }
}
