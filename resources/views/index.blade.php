<!DOCTYPE html>
<!-- saved from url=(0042)http://zccblog.cn/2017/10/30/about-layout/ -->
<html lang="en" class=""><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#34495e">
    <title> {{array_get($article,'title')}} | Zcc's blog</title>
    <link rel="shortcut icon" type="image/ico" href="http://zccblog.cn/favicon.ico">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{--<link rel="stylesheet" href="{{ asset('https://dn-maxiang.qbox.me/res-min/themes/marxico.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.css') }}">






    <script src="{{ asset('js/hm.js') }}"></script><script async="" src="{{ asset('js/analytics.js') }}"></script><script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-107259922-1', 'auto');
        ga('send', 'pageview');
    </script>



    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?371551c311dd9639c63a31616a72af4b";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>


    <style type="text/css">.fancybox-margin{margin-right:0px;}</style></head>

<body>
<div class="mobile-header">
    <span><i class="iconfont icon-turnon" id="mobile-nav-toggle"></i></span>
    <div class="mobile-logo">
        <a href="http://zccblog.cn/">Xixiang's blog</a>
    </div>
</div>
<div class="page slideout-panel slideout-panel-left" id="mobile-nav-panel">
    <div class="container">
        <header class="site-nav" style="">
            <div class="nav-content">
                <div class="logo">
                    <a href="http://zccblog.cn/">XiXiang's blog</a>
                </div>
                <nav class="navbar">
                    <ul>

                        <li class="menu-item">
                            <a href="http://zccblog.cn/" class="menu-item-link"><i class="iconfont icon-home"></i>首页</a>
                        </li>

                        <li class="menu-item">
                            <a href="http://zccblog.cn/archives" class="menu-item-link"><i class="iconfont icon-archive"></i>归档</a>
                        </li>

                        <li class="menu-item">
                            <a href="http://zccblog.cn/categories" class="menu-item-link"><i class="iconfont icon-category"></i>分类</a>
                        </li>

                        <li class="menu-item">
                            <a href="http://zccblog.cn/tags" class="menu-item-link"><i class="iconfont icon-tags"></i>标签</a>
                        </li>

                        <li class="menu-item">
                            <a href="http://zccblog.cn/about" class="menu-item-link"><i class="iconfont icon-about"></i>关于</a>
                        </li>

                    </ul>
                </nav>
            </div>
        </header>

        <div class="banner">
            <div class="show">
                <!-- <img src="/" alt="banner"> -->
                <div class="banner-title">

                    <div class="post-title">
                        {{array_get($article,'title')}}
                        <div class="post-tags">

                            <a class="tag-link" href="http://zccblog.cn/tags/CSS/">{{array_get($article,'type.name')}}</a>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <main class="main" id="main">
            <article class="post">


                <header>
                    <div class="post-title mobile-post-title">
                        <h1> {{array_get($article,'title')}}</h1>
                        <div class="post-tags">

                            <a class="tag-link" href="http://zccblog.cn/tags/CSS/">{{array_get($article,'type.name')}}</a>

                        </div>
                    </div>
                    <div class="post-meta">
                        <span class="post-time"><i class="iconfont icon-calendar"></i>{{array_get($article,'created_at')}}</span>


                        <i class="iconfont icon-divide"></i>
                        <i class="iconfont icon-folder" style="color: #8a8a8a;"></i>
                        <a class="post-category" href="http://zccblog.cn/categories/%E5%AD%A6%E4%B9%A0%E7%AC%94%E8%AE%B0/">{{array_get($article,'type.name')}}</a>


                        <!----------------------------------->

                        <!----------------------------------->
                    </div>
                </header>

                {{--<div class="post-toc" id="post-toc" style="position: absolute; top: 0px;">--}}
                    {{--<h2 class="post-toc-title">目录</h2>--}}
                    {{--<div class="post-toc-content">--}}
                        {{--<ol class="toc"><li class="toc-item toc-level-3">--}}
                                {{--<a class="toc-link" href="http://zccblog.cn/2017/10/30/about-layout/#前言">--}}
                                    {{--<span class="toc-text">前言</span></a></li><li class="toc-item toc-level-3">--}}
                                {{--<a class="toc-link" href="http://zccblog.cn/2017/10/30/about-layout/#正文">--}}
                                    {{--<span class="toc-text">正文</span></a><ol class="toc-child"><li class="toc-item toc-level-4">--}}
                                        {{--<a class="toc-link" href="http://zccblog.cn/2017/10/30/about-layout/#双飞翼布局"><span class="toc-text">双飞翼布局</span></a></li><li class="toc-item toc-level-4"><a class="toc-link" href="http://zccblog.cn/2017/10/30/about-layout/#圣杯布局"><span class="toc-text">圣杯布局</span></a></li></ol></li><li class="toc-item toc-level-3"><a class="toc-link" href="http://zccblog.cn/2017/10/30/about-layout/#最后"><span class="toc-text">最后</span></a></li></ol>--}}
                    {{--</div>--}}
                {{--</div>--}}


                <div class="post-content">
                    {!!array_get($article,'content')!!}

                    <ol> <li> <p>安装webpack<br> 首先需要安装<a href="https://nodejs.org">node.js</a>环境,见<a href="https://nodejs.org">node官网</a>.<br> 安装nodejs后使用npm 安装 webpack命令</p> <pre><code> $ npm install webpack -g </code></pre> </li> </ol> <p>这样webpack 命令即能在全局环境下使用</p> <ol start="2"> <li> <p>webpack小示例第一步</p> <p>创建空目录Demo文件夹 文件夹中创建app空文件夹<br> 在app文件夹中创建entry.js文件<br> 文件内容如下 --entry.js</p> <pre><code> document.write("It works."); </code></pre> <p>在app文件夹中创建 index.html<br> 文件内容如下 --index.html</p> <pre><code> &lt;!DOCTYPE html&gt; &lt;html lang="en"&gt; &lt;head&gt; &lt;meta charset="UTF-8"&gt; &lt;title&gt;webpack入门&lt;/title&gt; &lt;/head&gt; &lt;body&gt; &lt;script type="text/javascript" src="bundle.js" charset="utf-8"&gt;&lt;/script&gt; &lt;/body&gt; &lt;/html&gt; </code></pre> <p>执行命令：</p> <pre><code> $ cd Demo/app $ webpack ./entry.js bundle.js </code></pre> </li> </ol> <p>该命令会对entry.js文件编译并创建一个bundle.js文件<br> 如果成功的话，它会显示如下：</p> <pre><code>	Hash: ca188ee5789bb780fcec Version: webpack 1.13.0 Time: 65ms Asset Size Chunks Chunk Names bundle.js 1.42 kB 0 [emitted] main [0] ./entry.js 28 bytes {0} [built] </code></pre> <p>在浏览器中打开index.html 显示 It works.<br> 3. 第二步依赖文件加载</p> <pre><code>在app文件夹下添加content.js内容为 module.exports = "It works from content.js."; 更改entry.js文件内容为: document.write(require("./content.js")); 执行命令： $ webpack ./entry.js bundle.js 刷新浏览器index.html页面, 显示It works from content.js. </code></pre> <p><code>webpack会分析你的输入文件的依赖的其他文件。这些文件（称为模块）都会最终包含在你的bundle.js中。webpack会给每个模块的一个独特的ID以及保存所有模块的ID以便在bundle.js文件访问。仅在启动时执行输入模块，在运行时提供需要的功能，并在需要时执行依赖。</code><br> 4. 第一次使用loaders</p> <pre><code>我们要添加一个CSS文件到我们的示例中 </code></pre> <p>webpack只能处理JavaScript本身，所以我们需要css-loader去装载CSS文件,同样也需要style-loader。<br> <em>执行命令</em></p> <pre><code>	$ npm install css-loader style-loader </code></pre> <p>在app文件夹下添加style.css文件<br> 文件内容如下–style.css</p> <pre><code>	body { background: yellow; } </code></pre> <p>更新entry.js文件</p> <pre><code>	require("!style!css!./style.css"); document.write(require("./content.js")); </code></pre> <p>执行命令：</p> <pre><code>	$ webpack ./entry.js bundle.js </code></pre> <p>刷新浏览器index.html页面, 显示带有黄色背景的It works from content.js.<br> webpack只能处理JavaScript本身，style.css通过!style!css!装载机管道以特定的方式中改变输出 bundle.js 文件的内容。这些转换后的结果是一个JavaScript模块。<br> 如果我们不想使用 require("!style!css!./style.css");<br> 而想直接使用require("./style.css");<br> 更新entry.js文件内容为:</p> <pre><code>	require("./style.css"); document.write(require("./content.js")); </code></pre> <p>执行命令时要绑定加载模块：</p> <pre><code>	$ webpack ./entry.js bundle.js --module-bind 'css=style!css' </code></pre> <p>刷新浏览器index.html页面, 显示同样的效果。<br> 某些环境下这里可能要用双引号 “css=style!css”</p> <ol start="5"> <li> <p>使用配置文件 <strong>webpack.config.js</strong></p> <p>在Demo文件夹下创建webpack.config.js<br> 文件内容如下:</p> <pre><code> module.exports = { entry: "./app/entry.js", output: { path: __dirname, filename: "./app/bundle.js" }, module: { loaders: [ { test: /\.css$/, loader: "style!css" } ] } }; </code></pre> <p>现在只需要在Demo目录下执行命令:</p> <pre><code> $ webpack 执行成功会显示: Hash: ab14e3789227f2cbf6c0 Version: webpack 1.13.0 Time: 955ms Asset Size Chunks Chunk Names ./app/bundle.js 11.8 kB 0 [emitted] main [0] ./app/entry.js 67 bytes {0} [built] [5] ./app/content.js 45 bytes {0} [built] + 4 hidden modules </code></pre> <p><strong>webpack会自动加载当前目录下的webpack.config.js文件</strong></p> </li> <li> <p>漂亮的输出<br> 随着项目的增长，编译可能需要更长的时间。所以我们要展示一些进度条、颜色…可以使用命令</p> <pre><code> $webpack --progress --colors </code></pre> </li> <li> <p>使用watch model<br> 使用watch model模式时，可理解为监听模式,如果检测到任何文件更改，它将再次运行编译。</p> <pre><code> $webpack --watch </code></pre> </li> <li> <p>使用webpack开发服务器</p> <pre><code> // npm 全局安装webpack开发服务器 $ npm install webpack-dev-server -g 在Demo文件夹下执行 $ webpack-dev-server --progress --colors </code></pre> <p>webpack-dev-server 会在本地提供一个静态文件服务器<br> http://localhost:8080/webpack-dev-server/<br> 同时内部也在使用webpack的watc模式自动编译更新<br> 浏览器中打开http://localhost:8080/webpack-dev-server/<br> 只要文件有更新 浏览器也会自动刷新页面。</p> </li> </ol>

                </div>
                <div class="post-footer">the end</div>
            </article>


            <nav class="pagination post-nav">


                <a href="http://zccblog.cn/2016/12/11/change/">
                    <span class="next-post">hexo主题的更换及修改<i class="iconfont icon-more"></i></span>
                </a>

            </nav>






        </main>
    </div>
    <footer>
        <div class="social-links">


            <a href="https://www.zhihu.com/people/zao-gao-tou-ding"><i class="iconfont icon-zhihu"></i></a>



            <a href="http://weibo.com/u/5629747157"><i class="iconfont icon-weibo"></i></a>



            <a href="https://github.com/wa-ri"><i class="iconfont icon-github"></i></a>



            <a href="http://zccblog.cn/atom.xml"><i class="iconfont icon-rss"></i></a>


















        </div>

        <div class="quote">
            <p>草在结它的种子，风在摇它的叶子。我们站着，不说话，就十分美好。——顾城《门前》</p>
        </div>

        <div class="copyright">
            <p>
                由 <a href="https://hexo.io/">Hexo</a> 强力驱动
                <span>|</span>
                主题 - <a href="https://github.com/wa-ri/hexo-theme-ztopic">ztopic</a>
            </p><p>
          <span>

          ©

            2016 - 2017

          </span>
                <i class="iconfont icon-circle"></i>
                <span>Zcc</span>
            </p>
        </div>
    </footer>

    <div class="back-to-top" id="back-to-top" style="display: none;">
        <i class="iconfont icon-up"></i>
    </div>
</div>
<div id="mobile-nav">
    <nav id="mobile-nav-menu" class="slideout-menu slideout-menu-left">

        <a href="http://zccblog.cn/" class="mobile-nav-link"><i class="iconfont icon-home"></i>首页</a>

        <a href="http://zccblog.cn/archives" class="mobile-nav-link"><i class="iconfont icon-archive"></i>归档</a>

        <a href="http://zccblog.cn/categories" class="mobile-nav-link"><i class="iconfont icon-category"></i>分类</a>

        <a href="http://zccblog.cn/tags" class="mobile-nav-link"><i class="iconfont icon-tags"></i>标签</a>

        <a href="http://zccblog.cn/about" class="mobile-nav-link"><i class="iconfont icon-about"></i>关于</a>

        <div class="mobile-intro"><i class="iconfont icon-pen"></i>practice makes perfect</div>
    </nav>
</div>


<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('js/slideout.min.js') }}"></script>

<script src="{{ asset('js/jquery.fancybox.pack.js') }}"></script>



<script src="{{ asset('js/ztopic.js') }}"></script>


</body></html>