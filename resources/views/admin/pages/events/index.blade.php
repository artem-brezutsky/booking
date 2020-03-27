@extends('admin.layouts.app')

@section('content')
    @include('admin.includes.event-delete-modal')
    <div class="right-sidebar">
        <div class="page-title">События</div>
        <div class="card">
            <div class="card-header">
                <div class="form-group mb-0">
                    <form class="" action="{{ route('admin.events_list') }}" method="get">
                        <div class="form-row align-items-center">
                            <div class="col-auto my-1">
                                <select class="form-control" name="choice-studio" id="choice-studio">
                                    @foreach($studios as $studio)
                                        <option @if ($studio_id == $studio->id) selected
                                                @endif value="{{ $studio->id }}">{{ $studio->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto my-1">
                                <input class="btn btn-primary" type="submit" value="Фильтровать">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                {{-- Session popup --}}
                @include('admin.includes.toastr-session-messages')
                <table id="theTable" class="table table-striped table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Название события</th>
                        <th>Начало события</th>
                        <th>Конец события</th>
                        <th>Начало повторений</th>
                        <th>Конец повторений</th>
                        <th>Дни недели</th>
                        <th>Автор</th>
                        <th>Действия</th>
                    </tr>
                    @if ( $studio_events )
                        @foreach($studio_events as $event)
                            <tr id="trID_{{$event->id}}">
                                <td>{{ $event->id }}</td>
                                <td>{{ $event->event_name }}</td>
                                <td>{{ $event->start_date }}</td>
                                <td>{{ $event->end_date }}</td>
                                <td>{{ $event->start_recur }}</td>
                                <td>{{ $event->end_recur }}</td>
                                <td>{{ $event->days_of_week }}</td>
                                <td>{{ $event->author }}</td>
                                <td class="actions">
                                    <div class="delete-item">
                                        <input type="hidden" name="_method" value="delete"/>
                                        <a class="btn btn-danger btn-sm" title="Delete" data-toggle="modal"
                                           href="#modalDelete"
                                           data-id="{{$event->id}}"
                                           data-token="{{csrf_token()}}">
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>
@endsection
