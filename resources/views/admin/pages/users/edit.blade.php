@extends('admin.layouts.app')

@section('content')
    <div class="right-sidebar">
        <div class="page-title">Изменить пользователя</div>
        <div class="card">
            <div class="card-body">
                <div class="errors-block">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="user-form">
                    <form method="post" action="{{ route('users.update', $user->id) }}">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label for="name">Имя пользователя</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}"/>
                        </div>
                        <div class="form-row">
                            <fieldset class="form-group col-md-6">
                                <legend class="col-form-label">Доступы к комнатам</legend>
                                @foreach($studios as $key => $studio)
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="studioID[]"
                                                   value="STUDIO_ID_{{ $studio->id }}"
                                                   @if($user->hasPermission('STUDIO_ID_' . $studio->id))
                                                   checked
                                                    @endif >
                                            {{ $studio->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <legend class="col-form-label">Подписка на рассылку</legend>
                                @foreach($studios as $key => $studio)
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="mailingStudioID[]"
                                                   value="STUDIO_ID_{{ $studio->id }}"
                                                   @if($user->hasMailings('STUDIO_ID_' . $studio->id))
                                                   checked
                                                    @endif >
                                            {{ $studio->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="role" value="ROLE_ADMIN"
                                           @if( in_array('ROLE_ADMIN', $user->permissions ?? [], true))
                                           checked
                                            @endif >
                                    Администратор
                                </label>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Обновить">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
