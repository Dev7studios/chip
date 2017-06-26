@extends('layouts.app')

@section('scripts-head')
	<script>
		billingData = {!! json_encode($billing_data) !!};
	</script>
	<script src="https://checkout.stripe.com/checkout.js"></script>
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				@if (session('success'))
					<div class="alert alert-success">
						{{ session('success') }}
					</div>
				@endif
				@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<billing></billing>
			</div>
		</div>
	</div>
@endsection
