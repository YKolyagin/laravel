<?php

namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Class BlogCategoryRepository
 *
 * @package App\Repositories
 * @method Model startConditions()
 */

class   BlogCategoryRepository extends CoreRepository
{
    /**
     * return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * Получить модель для редактирования в админке
     *
     * @param int $id
     *
     * @return Model
     */
    public function getEdit(int $id): Model
    {
        return $this->startConditions()->find($id);
    }

    /**
     * Получить список категорий для вывода в выпадающем списке.
     *
     * @return Collection
     */
    public function getForComboBox(): Collection
    {
        $columns = implode(', ', [
            'id',
            'CONCAT (id , ". ", title) AS id_title',
        ]);

        $result = $this
            ->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();
        return $result;
    }

    /**
     * Получить категории для вывода пагинатором
     *
     * @param int|null $perPage
     *
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginate(int $perPage = null): LengthAwarePaginator
    {
        $columns = ['id', 'title', 'parent_id'];

        $result = $this
            ->startConditions()->with(['parentCategory:id,title'])
            ->paginate($perPage, $columns);

        return $result;
    }
}
