@if (isset($errors))
    @if(count($errors))
        @foreach($errors->all() as $error)
        	<script>alertify.error('{{ $error }}',25);</script>
       		@break
        @endforeach
    @endif
@endif

@if(session('success'))
	<script>alertify.success('{{ session()->get("success") }}',25);</script>
@endif

@if(session('warning'))
	<script>alertify.warning('{{ session()->get("warning") }}',25);</script>
@endif
