@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        	@if (null!=($message=Session::get('notification')))
				<div class="alert alert-{{ $message['class'] }} d-flex bg-style5">
					<h3 class="p-0 m-0">
						@if ($message['class'] == 'success')
							<i class="fa fa-check-circle"></i>
						@else if ($message['class'] == 'error')
							<i class="fa fa-times-circle"></i>
						@endif
					</h3>
					<div class="pl-2">{{ $message['message'] }}</div>
				</div>
			@endif
			<div class="card">
				<div class="card-header">					
                    {{ $model->name }}
				</div>
				<div class="card-body p-0">
					<table class="table">
		            	<tbody>
		            		<tr>
		            			<th width="200">{{ laradin_trans('ID') }}</th>
		            			<td>{{ $model->id }}</td>
		            		</tr>
                            <tr>
		            			<th>{{ laradin_trans('Category Name') }}</th>
		            			<td>{{ $model->name }}</td>
		            		</tr>
                            <tr>
		            			<th>{{ laradin_trans('Full Name') }}</th>
		            			<td>{{ $model->full_name }}</td>
		            		</tr>
                            <tr>
		            			<th>{{ laradin_trans('Description') }}</th>
		            			<td>{{ $model->description }}</td>
		            		</tr>
                            <tr>
		            			<th>{{ laradin_trans('Active') }}</th>
		            			<td>{{ $model->active_label }}</td>
		            		</tr>
                            <tr>
		            			<th>{{ laradin_trans('Created At') }}</th>
		            			<td>{{ optional($model->created_at)->format('d F Y h:i:s') }}</td>
		            		</tr>
                            <tr>
		            			<th>{{ laradin_trans('Updated At') }}</th>
		            			<td>{{ optional($model->updated_at)->format('d F Y h:i:s') }}</td>
		            		</tr>
		            	</tbody>	            	
		            </table>
				</div>
                <div class="card-footer">
                    <a href="{{ laradin_route('create') }}" class="btn btn-primary btn-sm">{{ laradin_trans('Add New') }}</a>
                    <a href="{{ laradin_route('edit', $model) }}" class="btn btn-primary btn-sm">{{ laradin_trans('Edit') }}</a>
                    <a href="{{ laradin_route('index') }}" class="btn btn-primary btn-sm">{{ laradin_trans('Back To List') }}</a>
                </div>
			</div>
            
        </div>
    </div>
</div>
@endsection
