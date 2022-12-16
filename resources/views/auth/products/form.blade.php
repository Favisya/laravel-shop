@extends('auth.layouts.layout')

@isset($product)
    @section('title', 'Редактировать товар ' . $product->name)
@else
    @section('title', 'Создать товар')
@endisset

@section('content')
    <div class="col-md-12">
        @isset($product)
            <h1>Редактировать товар <b>{{ $product->name }}</b></h1>
        @else
            <h1>Добавить товар</h1>
        @endisset
        <form method="POST" enctype="multipart/form-data"
              @isset($product)
                  action="{{ route('products.update', $product) }}"
              @else
                  action="{{ route('products.store') }}"
            @endisset
        >
            <div>
                @isset($product)
                    @method('PUT')
                @endisset
                @csrf
                <div class="input-group row">
                    <label for="code" class="col-sm-2 col-form-label">Код: </label>
                    <div class="col-sm-6">

                        @include('auth.layouts.error', ['field' => 'code'])

                        <input type="text" class="form-control" name="code" id="code"
                               value="@isset($product){{ $product->code }}@endisset">
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    @include('auth.layouts.error', ['field' => 'code'])
                    <label for="name" class="col-sm-2 col-form-label">Название: </label>
                    <div class="col-sm-6">

                        @include('auth.layouts.error', ['field' => 'name'])

                        <input type="text" class="form-control" name="name" id="name"
                               value="@isset($product){{ $product->name }}@endisset">
                    </div>
                </div>

                    <br>
                    <div class="input-group row">
                        @include('auth.layouts.error', ['field' => 'code'])
                        <label for="name_en" class="col-sm-2 col-form-label">Название en: </label>
                        <div class="col-sm-6">

                            @include('auth.layouts.error', ['field' => 'name_en'])

                            <input type="text" class="form-control" name="name_en" id="name"
                                   value="@isset($product){{ $product->name_en }}@endisset">
                        </div>
                    </div>

                <br>
                <div class="input-group row">
                    <label for="category_id" class="col-sm-2 col-form-label">Категория: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['field' => 'category_id'])
                        <select name="category_id" id="category_id" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                        @isset($product)
                                            @if($product->category_id == $category->id)
                                                selected
                                    @endif
                                    @endisset
                                >{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="description" class="col-sm-2 col-form-label">Описание: </label>
                    @include('auth.layouts.error', ['field' => 'description'])
                    <div class="col-sm-6">
								<textarea name="description" id="description" cols="72"
                                          rows="7">@isset($product){{ $product->description }}@endisset</textarea>
                    </div>
                </div>
                <br>
                    <div class="input-group row">
                        <label for="description_en" class="col-sm-2 col-form-label">Описание en: </label>
                        @include('auth.layouts.error', ['field' => 'description_en'])
                        <div class="col-sm-6">
								<textarea name="description_en" id="description_en" cols="72"
                                          rows="7">@isset($product){{ $product->description_en }}@endisset</textarea>
                        </div>
                    </div>
                    <br>
                <div class="input-group row">
                    <label for="image" class="col-sm-2 col-form-label">Картинка: </label>
                    <div class="col-sm-10">
                        <label class="btn btn-default btn-file">
                            Загрузить <input type="file" style="display: none;" name="image" id="image">
                        </label>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    @include('auth.layouts.error', ['field' => 'price'])
                    <label for="price" class="col-sm-2 col-form-label">Цена: </label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="price" id="price"
                               value="@isset($product){{ $product->price }}@endisset">
                    </div>
                </div>

                <br>
                <div class="input-group row">
                    @include('auth.layouts.error', ['field' => 'count'])
                    <label for="count" class="col-sm-2 col-form-label">Кол-во: </label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="count" id="count"
                               value="@isset($product){{ $product->count }}@endisset">
                    </div>
                </div>

                <br>
                    @foreach([
                    'hit'       => 'Хит',
                    'new'       => 'Новинка',
                    'recommend' => 'Рекомендуемые'
                    ] as $field => $tittle)
                        <div class="form-group row">
                            <label for="price" class="col-sm-2 col-form-label">{{ $tittle }}: </label>
                            <div class="col-sm-6">
                                <input type="checkbox" class="form-control" name="{{ $field }}" id="{{ $field }}"
                                       @if (isset($product) && $product->$field)
                                            checked="checked"
                                       @endif
                                >
                            </div>
                        </div>
                        <br>
                    @endforeach
                <button class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
