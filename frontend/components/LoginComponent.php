<?php

namespace frontend\components;

use frontend\models\forms\UserLoginForm;
use frontend\components\traits\QueriesTrait;
use frontend\models\User;
use Yii;
use yii\base\Component;
use yii\widgets\ActiveForm;

class LoginComponent extends Component
{
    use QueriesTrait;

    public function login(UserLoginForm $userLoginForm): array
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $request = \Yii::$app->request;
        $userLoginForm->load($request->post());
        $user = $userLoginForm->getUser();

        return $this->processLogin($request, $userLoginForm, $user);
    }

    private function processLogin(Yii\Web\Request $request, UserLoginForm $userLoginForm, ?User $user): array
    {
        if ($request->isAjax && ActiveForm::validate($userLoginForm) === []) {
            return [
                'loginResult' => Yii::$app->user->login($user),
                'error' => $userLoginForm->getErrorMessage()
            ];
        }
        return ['loginResult' => false, 'error' => $userLoginForm->getErrorMessage()];
    }

    public function loginVkUser($vkUser): bool
    {
        if (User::userWithEmailOrVkIdExists($vkUser['id'], $vkUser['email'])) {
            return Yii::$app->user->login(User::findOne(['email' => $vkUser['email']]));
        }

        $register = RegisterComponent::registerVkUser($vkUser);
        if ($register['registerResult']) {
            return Yii::$app->user->login($register['user']);
        }
        return false;
    }
}
