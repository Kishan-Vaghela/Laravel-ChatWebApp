<nav class="navbar navbar-expand-lg navbar navbar-light" style="background-color: #e6e2e1   ;">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">User Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('friendlist.get')}}">Friend List</a>
                </li>
                <li class ="nav-item">
                    <a class="nav-link" href="{{ route('friend.requestslist')}}">Friend Request's</a>
                </li>
                <li class ="nav-item">
                    <a class ="nav-link" href="{{ route('accepted.friend.requests')}}">Chat</a>
                </li>
                
            </ul>
            
        </div>
    </div>
</nav>