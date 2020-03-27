@extends('admin.layouts.app')

@section('content')
    <div class="right-sidebar">
        <div class="page-title">Изменить комнату</div>
        <div class="card">
            <div class="card-body">
                <div class="studio-form">
                    <div class="errors-block">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <form method="post" action="{{ route('studios.update', $studio->id) }}">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label for="studio-name">Название</label>
                            <input id="studio-name" type="text" class="form-control" name="studio-name"
                                   value="{{ $studio->name }}"/>
                        </div>

                        <div class="form-group">
                            <label for="description">Описание</label>
                            <input id="description" type="text" class="form-control" name="description"
                                   value="{{ $studio->description }}"/>
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input id="slug" type="text" class="form-control" name="slug" value="{{ $studio->slug }}"/>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Обновить">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
