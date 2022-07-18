<h1>Hell'o World

@auth
    <h1>Usuário Autenticado</h1>
    <p>{{Auth::user()->id}}</p>
    <p>{{Auth::user()->name}}</p>
    <p>{{Auth::user()->email}}</p>
@endauth

@guest
    <h1>Olá visitante</h1>
@endguest