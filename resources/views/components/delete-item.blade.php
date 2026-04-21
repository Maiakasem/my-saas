<form method="POST" action="{{ $action }}">
    @method('delete')
    @csrf

    <a href="#"
        onclick="event.preventDefault();
            this.closest('form').submit();">
        {{ $text }}
    </a>
</form>
