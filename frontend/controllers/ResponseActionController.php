<?php

namespace frontend\controllers;

use frontend\controllers\parentControllers\SecuredController;

class TaskActionController extends SecuredController
{
    public function actionCancel($id)
    {
        return redirect('/tasks');
    }

    public function actionApprove($id)
    {
        var_dump($id);
        die;
    }
}
