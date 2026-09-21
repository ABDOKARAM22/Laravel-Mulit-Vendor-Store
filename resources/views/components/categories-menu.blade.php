
<div class="col-md-3">
    
    <nav class="navbar bg-light">
        <ul class="navbar-nav">
            
            <h2 class="title text-center">
                Categories
            </h2>


            @foreach ($categories as $category)

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="{{ route('products.index', ['category' => $category->slug]) }}"
                    >
                        <i class="fa fa-tag"></i>
                        {{ $category->name }}
                    </a>
                </li>

            @endforeach

        </ul>
    </nav>
</div>