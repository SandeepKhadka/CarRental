<!-- Notify section starts here-->
@if (session('success'))
    <div class="alert alert-dismissible fade show" id="alert" role="alert" style="background-color: lightgreen">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@elseif (session('error'))
    <div class="alert alert-dismissible fade show" id="alert" role="alert" style="background-color: lightcoral">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<!-- Notify section ends here-->
