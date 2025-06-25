<div class="container">
    <a class="btn btn-outline-primary mb-2" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
        <span>条件で検索</span>
        <i class="fa-solid fa-angles-right"></i>
    </a>
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5>条件から店舗を探す</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('shops.index') }}" method="GET" class="row g-1 mb-3">
                <div class="col-10">
                    <input class="form-control search_input" name="keyword" placeholder="店舗名で検索">
                </div>
                <div class="col-2">
                    <button type="submit" class="search_button">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
            <div class="mb-3">
                <p class="sidebar_title">カテゴリから探す</p>
                @foreach ($categories as $c)
                    <label class="sidebar_label"><a href="{{ route('shops.index', ['category' => $c->id]) }}">{{ $c->name }}</a></label>
                @endforeach
            </div>
            <div class="mb-3">
                <p class="sidebar_title">価格帯から探す</p>
                @foreach ($prices as $p)
                    <label class="sidebar_label"><a href="{{ route('shops.index', ['price' => $p->id]) }}">{{ $p->range }}</a></label>
                @endforeach
            </div>
        </div>
    </div>
</div>