<?php if (!defined("__TYPECHO_ROOT_DIR__")) {
    exit();
} ?>
<!--rgba(22,24,41,0.5)]-->
<!-- Desktop Menu -->
<div id="header-menu" class="jasmine-primary-color hidden lg:block sticky top-0 border-b border-stone-100 lg:py-5 bg-[rgba(255,255,255,0.5)] dark:bg-[rgba(22,24,41,0.5)] z-[999] dark:border-neutral-600 backdrop-blur">
    <div id="header-menu-wrap" class="flex justify-between hidden lg:flex z-50">
        <ul class="nav flex items-center gap-x-3">
            <li>
                <a title="首页" href="<?php $this->options->siteUrl(); ?>"
                class="<?php if ($this->is("index")) { echo "jasmine-primary-bg shadow-lg !text-white"; } ?> text-black dark:text-white rounded-full px-4 py-2">首页</a>
            </li>
            <?php $this->widget("Jasmine_Meta_Row")->to($categorys); ?>
            <?php if ($categorys->have()): ?>
                <?php while ($categorys->next()): ?>
                    <li>
                        <a href="<?php $categorys->permalink(); ?>"
                        title="<?php $categorys->name(); ?>"
                        class="<?php echo isActiveMenu($this, $categorys->slug); ?> rounded-full px-4 py-2 jasmine-primary-bg-hover hover:text-white hover:shadow-lg">
                            <?php $categorys->name(); ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            <?php endif; ?>
        </ul>
        <ul class="nav flex items-center gap-x-3">
            <li itemscope="" itemtype="https://schema.org/WebSite">
                <meta itemprop="url" content="<?php $this->options->siteUrl(); ?>">
                <form method="post" action="" id="search" itemprop="potentialAction" itemscope="" itemtype="https://schema.org/SearchAction">
                    <meta itemprop="target" content="<?php $this->options->siteUrl(); ?>search/{s}/">
                    <label for="search" class="flex flex-row">
                    <button class="my-2 pt-2" onclick="jasmine.clickSearch()">
                        <iconify-icon icon="tabler:search" class="rounded px-1 text-lg jasmine-link-color"></iconify-icon>
                    </button>
                    <input class="duration-300 my-2 w-0 focus:w-32 bg-transparent" itemprop="query-input" id="search-input" type="text" name="s" required="true" autocomplete="off" placeholder="Search">
                    </label>
                </form>
            </li>
        </ul>
    </div>
</div>

<!-- Mobile Menu Toggle -->
<div id="header-menu-mobile" class="jasmine-primary-color lg:hidden flex justify-between sticky top-0 border-b border-stone-100 py-3 z-50 bg-[rgba(255,255,255,0.5)] dark:bg-[rgba(22,24,41,0.5)] dark:text-neutral-300 dark:border-neutral-600 backdrop-blur">
    <ul class="nav flex items-center gap-x-3">
        <li><?php $this->need("component/logo.php"); ?></li>
    </ul>
    <ul class="nav flex items-center gap-x-3">
        <li>
            <button onclick="jasmine.switchDark()">
                <iconify-icon icon="<?php echo getOptionValueOrDefault('switchDarkIconPhone', 'tabler:sun-moon'); ?>" class="rounded px-3 py-2 text-lg"></iconify-icon>
            </button>
        </li>
        <li>
            <form method="post" action="" id="search" itemprop="potentialAction" itemscope="" itemtype="https://schema.org/SearchAction">
                <meta itemprop="target" content="<?php $this->options->siteUrl(); ?>search/{s}/">
                <label for="search" class="flex flex-row">
                    <button class="" onclick="jasmine.clickSearch()">
                        <iconify-icon icon="tabler:search" class="rounded px-3 py-2 text-lg"></iconify-icon>
                    </button>
                    <input class="duration-300 my-2 w-0 focus:w-32 bg-transparent" itemprop="query-input" id="search-input" type="text" name="s" required="true" autocomplete="off" placeholder="Search">
                </label>
            </form>
        </li>
        <li>
            <button onclick="jasmine.toggleMobileMenu()">
                <iconify-icon icon="tabler:menu-2" class="rounded px-3 py-2 text-lg"></iconify-icon>
            </button>
        </li>
    </ul>
</div>



<!-- Mobile Menu Background (for closing when clicking outside) -->
<div id="mobile-menus-bg" class="lg:hidden hidden fixed top-0 left-0 z-[999] bg-gray-500/50 dark:bg-[#0a0c19]/50 w-full min-h-screen" onclick="jasmine.toggleMobileMenu()"></div>

<!-- Mobile Menu -->
<div id="mobile-menus" class="lg:hidden fixed top-0 left-0 z-[1000] translate-x-[-1000px] w-4/5 duration-300">
    <div class="jasmine-primary-color bg-[rgba(255,255,255,0.8)] min-h-screen flex flex-col gap-y-14 px-5 pt-14 dark:bg-[#0d0d0d]">
        <ul class="flex flex-col items-center gap-y-3">
            <li class="bg-[rgba(255,255,255,0.8)] rounded w-full dark:bg-[#0d0d0d]">
                <a title="首页" href="<?php $this->options->siteUrl(); ?>" class="w-full block px-4 py-2">首页</a>
            </li>
            <?php $this->widget("Jasmine_Meta_Row")->to($categorys); ?>
            <?php if ($categorys->have()): ?>
                <?php while ($categorys->next()): ?>
                    <li class="bg-[rgba(255,255,255,0.8)] rounded w-full dark:bg-[#0d0d0d]">
                        <a href="<?php $categorys->permalink(); ?>" title="<?php $categorys->name(); ?>" class="w-full block px-4 py-2">
                            <?php $categorys->name(); ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            <?php endif; ?>
        </ul>
        <ul class="flex flex-col items-center gap-y-3 w-full">
            <?php $menus = getLeftSidebarMenu(); ?>
            <?php if (!empty($menus)): ?>
                <?php foreach ($menus as $menu): ?>
                    <li class="bg-[rgba(255,255,255,0.8)] rounded w-full dark:bg-[#0d0d0d]">
                        <a class="w-full block px-4 py-2" href="<?php echo $menu['url']; ?>" target="<?php echo $menu['newTab'] ? '_blank' : '_self'; ?>" title="<?php echo $menu['name']; ?>">
                            <?php echo $menu['name']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>

<!-- Search Results -->
<?php if (!$this->is('page')): ?>
    <div class="search-toggle">
        <?php if ($this->have()): ?>
            <!-- 只有有搜索结果时才显示展开/收起线条 -->
            <div id="toggle-search-results" class="toggle-line" data-tooltip="展开搜索结果"></div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<div class="search-results" style="display: <?php echo $this->have() ? 'none' : 'block'; ?>;">
    <?php if ($this->have()): ?>
        <!-- Loop through search results -->
        <?php while($this->next()): ?>
            <?php if (!$this->is('page')): ?>
                <!-- 只显示非独立页面的搜索结果 -->
                <div class="search-item">
                    <h2><a href="<?php $this->permalink(); ?>"><?php $this->title(); ?></a></h2>
                </div>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php else: ?>
        <!-- No search results message -->
        <div class="no-results-message">
            <iconify-icon icon="tabler:alert-circle" class="no-results-icon"></iconify-icon>
            <h2>没有找到相关内容</h2>
            <p>抱歉，没有找到与 "<strong><?php $this->archiveTitle(''); ?></strong>" 相关的内容。</p>
            <p>请尝试其他关键词，或查看 <a href="<?php $this->options->siteUrl(); ?>">首页</a> 浏览其他内容。</p>
        </div>
    <?php endif; ?>
</div>

<?php if ($this->have() && !$this->is('page')): ?>
<script>
    document.getElementById('toggle-search-results').addEventListener('click', function() {
        var searchResults = document.querySelector('.search-results');
        var toggleLine = document.getElementById('toggle-search-results');
        if (searchResults.style.display === 'none' || searchResults.style.display === '') {
            searchResults.style.display = 'block';
            // 显示上下两条细线，并更新提示为收起
            toggleLine.classList.add('expanded');
            toggleLine.setAttribute('data-tooltip', '收起搜索结果');
        } else {
            searchResults.style.display = 'none';
            // 只显示一条细线，并更新提示为展开
            toggleLine.classList.remove('expanded');
            toggleLine.setAttribute('data-tooltip', '展开搜索结果');
        }
    });
</script>
<?php endif; ?>



<script>
    function jasmine.toggleMobileMenu() {
        const menu = document.getElementById('mobile-menus');
        const menuBg = document.getElementById('mobile-menus-bg');
        if (menu.classList.contains('translate-x-[-1000px]')) {
            menu.classList.remove('translate-x-[-1000px]');
            menuBg.classList.remove('hidden');
        } else {
            menu.classList.add('translate-x-[-1000px]');
            menuBg.classList.add('hidden');
        }
    }
</script>


<!-- Improved Styling for No Results Message -->
<style>
/* 样式用于细长灰色线条 */
#toggle-search-results {
    width: 100%;
    height: 1px;
    background-color: gray;
    cursor: pointer;
    margin: 10px 0;
    position: relative;
}

/* 展开状态下的上下两条线 */
#toggle-search-results.expanded {
    height: 3px; /* 模拟两条线 */
    background-image: linear-gradient(to bottom, gray 1px, transparent 1px, transparent 2px, gray 2px);
}

/* 提示的样式 */
#toggle-search-results::after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: -25px; /* 提示框显示在线条下方 */
    left: 50%;
    transform: translateX(-50%);
    background-color: #333;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 12px;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease;
}

/* 鼠标悬停时显示提示 */
#toggle-search-results:hover::after {
    opacity: 1;
    visibility: visible;
}

/*无结果页面样式*/
.no-results-message {
    
    text-align: center;
    margin: 40px 0;
    padding: 30px;
    background-color: rgba(255, 255, 255, 0.2);
    color: #555;
    border: 2px solid #ff5757;
    border-radius: 12px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    animation: fadeIn 1s ease-in-out;
}

.no-results-message h2 {
    font-size: 24px;
    font-weight: bold;
    color: #ff5757;
}

.no-results-message p {
    font-size: 18px;
    margin-top: 10px;
}

.no-results-message a {
    color: #ff5757;
    text-decoration: underline;
}

.no-results-icon {
    font-size: 48px;
    color: #ff5757;
    margin-bottom: 15px;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
</style>
