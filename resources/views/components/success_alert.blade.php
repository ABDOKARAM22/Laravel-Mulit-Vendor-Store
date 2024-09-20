
@if (session('success'))
<div class="alert alert-success text-center" role="alert">
    {{ session('success') }}
</div>
@endif
