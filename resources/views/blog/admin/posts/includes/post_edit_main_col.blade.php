@php
    /** @var BlogPost $item */use App\Models\BlogPost;
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @if($item->is_published)
                    Опубликовано
                @else
                    Черновик
                @endif
            </div>
            <div class="card-body">
                <div class="card-title"></div>
                <div class="card-subtitle mb-2 text-muted"></div>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a data-bs-toggle="tab" id="main-tab" data-bs-target="#maindata" type="button" role="tab" aria-controls="maindata" aria-selected="true" class="nav-link active">Основные данные</a>
                    </li>
                    <li class="nav-item">
                        <a data-bs-toggle="tab" id="add-tab" data-bs-target="#adddata" type="button" role="tab" aria-controls="adddata" aria-selected="false" class="nav-link">Доп. данные</a>
                    </li>
                </ul>
                <br>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="maindata" role="tabpanel" aria-labelledby="main-tab">
                        <div class="form-group">
                            <label for="title">Заголовок</label>
                            <input type="text" name="title" value="{{ $item->title }}" id="title" class="form-control" minlength="3" required>
                        </div>
                        <div class="form-group">
                            <label for="content_raw">Статья</label>
                            <textarea name="content_raw" id="content_raw" class="form-control" rows="20">{{ old('content_raw', $item->content_raw) }}</textarea>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="adddata" role="tabpanel" aria-labelledby="add-tab">
                        <div class="form-group">
                            <label for="category_id">Категория</label>
                            <select name="category_id" id="category_id" class="form-control" placeholder="Выберите категорию" required>
                                @foreach ($categoryList as $categoryOption)
                                    <option value="{{ $categoryOption->id }}" @if($categoryOption->id == $item->category_id) selected @endif>{{ $categoryOption->id_title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="slug">Идентификатор</label>
                            <input class="form-control" type="text" name="slug" id="slug" value="{{ $item->slug }}">
                        </div>
                        <div class="form-group">
                            <label for="excerpt">Выжержка</label>
                            <textarea name="excerpt" id="excerpt" rows="3" class="form-control">{{ old('excerpt', $item->excerpt) }}</textarea>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="is_published" value="0">
                            <input type="checkbox" name="is_published" class="form-check-input" value="1" @if($item->is_published) checked="checked" @endif>
                            <label class="form-check-label" for="is_published">Опубликованно</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
