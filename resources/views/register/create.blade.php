<form action="{{ route('register.store') }}" method="POST">
    {{ csrf_field() }}

    <div>
        <label for="">Name</label>
        <input name="name" type="text" value="">
    </div>

    <div>
        <label for="">Email</label>
        <input name="email" type="text" value="">
    </div>

    <div>
        <label for="">Password</label>
        <input name="password" type="password" value="">
    </div>

    <button>Register</button>
</form>
