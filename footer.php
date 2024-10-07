<?php if (!defined("__TYPECHO_ROOT_DIR__")) {
  exit();
} ?>

<div class="flex flex-col lg:mb-16 py-3 dark:dark:text-gray-500">
    <div class="flex flex-col items-center">
        <div class="flex flex-row gap-x-1 items-center footer">
            <img src="https://www.chendk.info/usr/themes/jasmine/pictures/2.gif" alt="动态图片" class="dynamic-image" />
            <span><a href="https://beian.miit.gov.cn" target="_blank">豫ICP备2024087193号-1</a></span>
            <span><a target="_blank">Base on Jasmine</a></span>
        </div>
    </div>
</div>

<!-- 回到顶部按钮 -->
<div class="back-to-top" id="backToTop">
    <div class="back-to-top-container">
        <img src="https://www.chendk.info/usr/themes/jasmine/pictures/5.gif" alt="Back to Top" class="back-to-top-img" />
        <span class="back-to-top-text">TOP</span>
    </div>
</div>

<!-- Fish 特效 -->
<div id="jsi-flying-fish-container" class="container"></div>


<?php $this->footer(); ?>
<script>
    // 初始化自定义脚本
    <?php $this->options->customScript(); ?>

    // 初始化鱼特效
    // window.onload = () => {
    //     RENDERER.init();
    // };
    window.onload = function() {
        if (typeof RENDERER !== 'undefined' && RENDERER.init) {
            RENDERER.init();
        } else {
            console.error("Fish effect failed to load.");
        }
    };

    // 显示或隐藏回到顶部按钮的逻辑
    window.onscroll = function() {
        const backToTopButton = document.getElementById("backToTop");
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            backToTopButton.classList.add("show");
        } else {
            backToTopButton.classList.remove("show");
        }
    };

    // 点击回到顶部按钮，平滑滚动返回顶部
    document.getElementById("backToTop").addEventListener("click", function() {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
</script>

<!-- Fish 特效 JS -->
<script src="https://www.chendk.info/usr/themes/jasmine/assets/dist/fish.js"></script>

<!-- Fish 特效的样式 -->
<link rel="stylesheet" href="https://www.chendk.info/usr/themes/jasmine/assets/dist/fish-style.css">

<!-- 内联样式 -->
<style>

    .dynamic-image {
        height: 1.6em;   /* 图片高度设置为与文本高度相似 */
        width: auto;   /* 宽度自动调整，保持纵横比 */
      }
    /* 回到顶部按钮样式 */
    .back-to-top {
        position: fixed;
        bottom: 50px;
        right: 30px;
        display: none; /* 默认隐藏 */
        align-items: center;
        cursor: pointer;
        z-index: 1000;
    }

    .back-to-top-container {
        position: relative; /* 使内部元素可以进行绝对定位 */
        display: inline-block;
    }

    .back-to-top-img {
        height: 45px; /* 图片大小 */
        width: auto;
    }

    /* 提示文本样式，显示在图片顶部 */
    .back-to-top-text {
        position: absolute;
        top: -20px; /* 调整文字的顶部距离 */
        left: 50%;  /* 水平居中 */
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.5); /* 半透明背景 */
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        font-size: 5px;
        white-space: nowrap; /* 防止文字换行 */
    }

    /* 鼠标悬停时仍显示提示文本 */
    .back-to-top:hover .back-to-top-text {
        display: inline-block;
    }

    /* 页面滚动一定距离后显示按钮 */
    .show {
        display: flex !important; /* 显示回到顶部按钮 */
    }

</style>
