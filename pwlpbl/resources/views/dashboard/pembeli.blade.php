<h1>Dashboard Pembeli</h1>
<p>Login sebagai: {{ session('email') }}</p>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>