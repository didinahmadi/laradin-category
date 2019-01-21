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
					<a href="{{ laradin_route('create') }}" class="btn btn-primary btn-sm">Add New</a>
				</div>
				<div class="card-body p-0">
					<table class="table">
		            	<thead>
		            		<tr>
		            			<th>ID</th>
		            			<th>Parent</th>
		            			<th>Name</th>
		            			<th>Active</th>
		            			<th>Action</th>
		            		</tr>
		            	</thead>

		        		<tbody>
		        			@foreach ($items as $item)
			        			<tr>
			            			<th>{{ $item->id }}</th>
			            			<th>{{ $item->full_name }}</th>
			            			<th>{{ $item->name }}</th>
			            			<th>{{ $item->active_label }}</th>
			            			<th>
			            				<a href="{{ laradin_route('edit', [
											'category' => $item
										]) }}" class="btn btn-secondary btn-sm">
											<i class="fa fa-eye"></i> Edit
										</a>
			            				<a href="{{ laradin_route('show', [
											'category' => $item
										]) }}" class="btn btn-secondary btn-sm">
											<i class="fa fa-edit"></i> Show
										</a>
			            			</th>
			            		</tr>
		        			@endforeach
		        		</tbody>
		            	
		            </table>
				</div>
			</div>
            
        </div>
    </div>
</div>
@endsection
