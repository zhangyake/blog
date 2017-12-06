@extends('layout.main')


@section('articles')

    <ul class="home post-list">
        @foreach($articles as  $article)

            <li class="post-list-item ">

                <article class="post-block">

                    <h1 class="post-title">
                        <a href="{{route('article_view',['id'=>$article->id])}}" class="post-title-link">

                            {{array_get($article,'title')}}    </a>
                    </h1>

                    <div class="post-info">
                        <div class="post-content">
                            <div class="info"
                                 style="margin: 0 auto;text-align: center"> {{array_get($article,'created_at')}} @foreach(array_get($article,'tags',[]) as $tag)
                                    <a href="{{route('tag_archives_view',['id'=>$tag->id])}}" target="_blank" title=""
                                       class="post-demo">
                                        {{array_get($tag,'name')}}</a>
                                @endforeach</div>

                            <div class="img" style="margin: 10px auto;text-align: center;width: 640px;">
                                @if(array_get($article,'id')%4 === 0)
                                    <img src="http://7xqeyw.com1.z0.glb.clouddn.com/usess.png" alt="">
                                @elseif(array_get($article,'id')%4 === 1)
                                    <img src="http://7xqeyw.com1.z0.glb.clouddn.com/201611-ipad-605420_1920.jpg" alt="">
                                @elseif(array_get($article,'id')%4 === 2)
                                    <img src="http://7xqeyw.com1.z0.glb.clouddn.com/qweqsad.png" alt="">
                                @elseif(array_get($article,'id')%4 === 3)
                                    <img src="http://imgmini.dfshurufa.com/mobile/20160325172758_220bfff17cc1d8fa3fb6c8fae974bde9_2.jpeg"
                                         alt="">
                                @endif


                            </div>


                        </div>
                    </div>
                </article>

            </li>
        @endforeach
    </ul>

@endsection

@section('next_page')


@endsection