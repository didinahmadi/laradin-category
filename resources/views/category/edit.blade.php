@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="{{ laradin_route('update', ['category' => $model]) }}">
                @method('PUT')
                @csrf
            <div class="card">
                <div class="card-header">{{ laradin_trans('Create New Category') }}</div>

                <div class="card-body">
                    
                    	<div class="form-group">
                    		<label for="name">{{ laradin_trans('Category Name') }}</label>
                    		<input type="text" name="name" value="{{ isset($model) ? old('name', optional($model)->name) :  '' }}" id="name" class="form-control{{ $errors->has('name') ?' is-invalid' : '' }}" />
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                    	</div>

                    	<div class="form-group">
                    		<label for="name">{{ laradin_trans('Part Of') }}</label>
                    		<select name="parent_id" id="parent_id" class="form-control{{ $errors->has('parent_id') ? ' is-invalid' : '' }}">
                    			@foreach ($categoryList as $k => $v)
                                    @if (isset($model) && $k === $model->parent_id)
                                        <option selected value="{{ $k }}">{{ $v }}</option>
                                    @elseif (isset($model) && $k !== $model->id)
                                        <option value="{{ $k }}">{{ $v }}</option>
                                    @endif
                                @endforeach
                    		</select>
                            <div class="invalid-feedback">
                                {{ $errors->first('parent_id') }}
                            </div>
                    	</div>

                        <div class="form-check">                            
                            <input type="checkbox" {{ isset($model) ? old('active', ($model->active ? 'checked':'') ) :  '' }} class="form-check-input" id="active" name="active" />
                            <label class="form-check-label" for="active">{{ laradin_trans('Active') }}</label>
                            <div class="invalid-feedback">
                                {{ $errors->first('active') }}
                            </div>
                        </div>                    
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        {{ laradin_trans('Submit') }}
                    </button>
                    <a href="{{ laradin_route('index') }}" class="btn btn-light">
                        {{ laradin_trans('Cancel') }}
                    </a>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
