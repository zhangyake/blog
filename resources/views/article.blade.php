
@extends('layout.main')


@section('articles')



<div id="postAr" class="post">
    <article class="post-block">
        <h1 class="post-title">{{array_get($article,'title')}}</h1>
        <div class="post-info">{{array_get($article,'created_at')}}
            <p class="visit">
                <i data-hk-page="current">1</i>
                <span>次访问</span>
            </p>
            {{--<a href="http://bubuzou.com/demos/201708/traverse-of-array-like.html" target="_blank" title="" class="post-demo">去看示例</a>--}}
        </div>

        <div class="post-content">
            {!!  array_get($article,'content')!!}
        </div>
    </article>
</div>

@endsection

@section('next_page')
<div class="paginator"><a href="{{ route('article_view',['id'=>(array_get($article,'id',0) + 1) ]) }}" class="next">下一篇</a></div>

@endsection