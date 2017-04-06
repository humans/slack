<form action="{{ route('login.store', $team) }}" method="POST">
    {{ csrf_field() }}

    <div>
        <label for="">Email</label>
        <input name="email" type="text" value="">
    </div>

    <div>
        <label for="">Password</label>
        <input name="password" type="password" value="">
    </div>

    <button>Login</button>
</form>
