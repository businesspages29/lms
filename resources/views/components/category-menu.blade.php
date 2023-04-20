<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @foreach ($parentCategories as $parent)
                    <li class="nav-item dropdown">
                        <a class="nav-link"
                            href="{{ route('products.index', [
                                'category_id' => $parent->id,
                            ]) }}">
                            {{ $parent->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>
@if ($subCategoryMenu)
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <b>Sub Category: </b>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @foreach ($subCategoryMenu as $sub)
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('products.index', [
                                    'category_id' => $sub->id,
                                ]) }}">{{ $sub->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
@endif
