<template>
    <div class="about-me">
        <mu-card>
            <mu-card-header title="伪全栈程序员" subTitle="自我介绍">
                <mu-avatar src="/images/uicon.jpg" slot="avatar"/>
            </mu-card-header>
            <!--<mu-card-media title="Hello" subTitle="Welcome to Here !">-->
                <!--<img src="/images/sun.jpg" />-->
            <!--</mu-card-media>-->
            <!--<mu-card-title title="自我介绍" subTitle=""/>-->
            <mu-card-text>
                本人学识渊博、经验丰富，代码风骚、效率恐怖，PHP、Java、Python、Javascript 无不精通，熟练掌握各种框架，深山苦练 20 余年，一天只睡 4 小时，
                千里之外定位问题，瞬息之间修复上线。身体强壮、健步如飞，可连续编程 100 小时不休息，讨论技术方案5小时。
            </mu-card-text>
        </mu-card>

    </div>

</template>
<script>

    export default {
name:'about'
    }
</script>
<style scoped>
    .about-me{
        margin-top: 48px;
    }

</style>