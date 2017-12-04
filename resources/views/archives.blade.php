@extends('layout.main')

@section('articles')

    <div class="archive">
        <h2 class="archive-year">
            @if($name)
                {{$name}}
            @else
                所有文章
            @endif
        </h2>
        @foreach($articles as $item)
            <div class="post-item">
                <div class="post-info" style="width: 100px;">{{array_get($item,'created_at')}}</div>
                <a href="{{route('article_view',['id'=>$item->id])}}"
                   class="post-title-link">{{array_get($item,'title')}}</a></div>
        @endforeach

    </div>

@endsection