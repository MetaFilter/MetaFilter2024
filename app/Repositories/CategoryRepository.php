<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;

final class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
}
