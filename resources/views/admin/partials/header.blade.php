<header class="bg-dark ">
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <a href="{{route('home')}}" class="navbar-brand">Vai al sito</a>
            <div class="d-flex">
                <form action="{{route('admin.search')}}" method="GET" class="me-3">
                    @csrf
                    <input type="text" name="toSearch" class="form-control mr-sm-2" placeholder="Cerca">
                </form>
                <a class="text-white text-decoration-none me-3" href="{{route('profile.edit')}}"> {{Auth::user()->name }}</a>
                
                <form class="d-flex" role="search" action="{{route('logout')}}" method="POST">
                @csrf
                <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-right-from-bracket"></i></button>
                </form>

            </div>

        </div>
    </nav>
</header>
