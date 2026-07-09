<div class="row">
    @if (session()->has('success'))
        <div class="arlert alert-success">
            <button class="close" type="button" data-dismiss="alert">X</button>
            {{ session()->get('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="arlert alert-danger">
            <button class="close" type="button" data-dismiss="alert">X</button>
            {{ session()->get('error') }}
        </div>
    @endif
</div>