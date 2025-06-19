<div class="container">
    <form action="{{ route('shops.index') }}" method="GET" class="row g-1 mb-3">
        <div class="col-10">
            <input class="form-control search_input" name="keyword">
        </div>
        <div class="col-2">
            <button type="submit" class="btn search_btn">
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