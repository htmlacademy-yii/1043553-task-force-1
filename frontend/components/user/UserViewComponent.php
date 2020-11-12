<?php

namespace frontend\components\user;

use frontend\components\traits\QueriesTrait;
use frontend\models\forms\UsersFilterForm;
use yii\base\Component;
use yii\data\Pagination;

class UserViewComponent extends Component
{
    use QueriesTrait;

    //private array $listOfUsers;
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

        $query = UserFilterComponent::applyFilters($model, $query);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => 5]);
        $usersList = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $usersList = $this->selectedUserComponent->addRelatedDataForEachUser($usersList);

        return ['usersList' => $usersList, 'pages' => $pages ];
    }

    public function __construct($config = [])
    {
        $this->selectedUserComponent = new SelectedUserComponent();
        parent::__construct($config);
    }
}
