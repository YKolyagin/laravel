<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $paginator = BlogCategory::paginate(15);

        return view('blog.admin.categories.index',compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $item = new BlogCategory();
        $categoryList = BlogCategory::all();

        return view('blog.admin.categories.edit', compact('item', 'categoryList') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogCategoryCreateRequest $request
     * @return RedirectResponse
     */
    public function store(BlogCategoryCreateRequest $request): RedirectResponse
    {
        $data = $request->input();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title'], '_');
        }

        //Создаст обьект и добавит в базу
        $item = (new BlogCategory())->create($data);

        if ($item) {
            return redirect()->route('blog.admin.categories.edit', [$item->id])
                ->with(['success' => 'Успешно сохранено']);
        }else{
            return back()->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function edit(int $id, BlogCategoryRepository $categoryRepository)
    {
        $item = $categoryRepository->getEdit($id);
        if (empty($item)) {
            abort(404);
        }
        $categoryList = $categoryRepository->getForComboBox();

        return view('blog.admin.categories.edit', compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogCategoryUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(BlogCategoryUpdateRequest $request, int $id): RedirectResponse
    {

        $item = BlogCategory::find($id);
        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id:[$id] не найдена"])
                ->withInput();
        }

        $data = $request->all();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title'], '_');
        }

        $result = $item->update($data);

        if ($result) {
            return redirect()
                ->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }
}
