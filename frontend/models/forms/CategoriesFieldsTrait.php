<?php

namespace frontend\models\forms;

use frontend\models\Category;

trait CategoriesFieldsTrait
{
    public function categoriesFields()
    {
         return Category::getCategoriesListArray();
    }
}
