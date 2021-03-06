<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class BlogPostRepository
 *
 * @package App\Repositories
 * @method Model startConditions()
 */

class BlogPostRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Получить список статей для вывода в админке
     *
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginate(): LengthAwarePaginator
    {
        $columns = [
            'id',
            'title',
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'category_id',
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->orderby('id', 'DESC')
            ->with(['user:id,name', 'category:id,title'])
            ->paginate(25);

        return $result;
    }

    /**
     * Получить модель статьи для редактировная в админке
     *
     * @param int $id
     *
     * @return Model
     */

    public function getEdit(int $id): Model
    {
        return $this->startConditions()->find($id);
    }
}

