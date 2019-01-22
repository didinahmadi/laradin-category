@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ laradin_route('destroy', $model) }}" method="POST">
                @method('DELETE')
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h1>Delete #{{ $model->id }}</h1>

                        Are you sure will delete this data ?

                    </div>
                    <div class="card-footer">
                        <a href="{{ laradin_route('show', $model) }}" class="btn btn-sm btn-secondary">
                            {{ laradin_trans('Cancel') }}
                        </a>
                        <button type="submit" class="btn btn-sm btn-danger" name="action" value="destroy">
                            {{ laradin_trans('Delete Permanently') }}
                        </button>

                        <button type="submit" class="btn btn-sm btn-warning"  name="action" value="disable">
                            {{ laradin_trans('Disable') }}
                        </button>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
