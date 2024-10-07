<?php
/**
 * ainews
 *
 * @package custom
 */
if (!defined("__TYPECHO_ROOT_DIR__")) {
  exit();
}

// 配置缓存文件路径和有效期
$cache_file = __DIR__ . '/ai_news_cache.json'; // 缓存文件路径
$cache_expiration = 3600; // 缓存有效期，单位为秒（1小时）

// 函数：抓取RSS新闻并解析为对象
function fetch_rss_news($feed_url) {
    $rss = simplexml_load_file($feed_url);
    $news_list = [];

    if ($rss) {
        foreach ($rss->channel->item as $item) {
            $news_list[] = [
                'title' => (string)$item->title,
                'link' => (string)$item->link,
                'description' => (string)$item->description,
                'pubDate' => (string)$item->pubDate,
                'source' => (string)$rss->channel->title
            ];
        }
    }

    return $news_list;
}

// 函数：加载缓存或抓取新闻
function load_or_fetch_news($cache_file, $cache_expiration) {
    // 如果缓存文件存在且未过期，直接读取缓存
    if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $cache_expiration) {
        return json_decode(file_get_contents($cache_file), true);
    }

    // 抓取新闻源
    $ai_news = fetch_rss_news('https://www.technologyreview.com/feed/');
    $ars_technica_news = fetch_rss_news('https://feeds.arstechnica.com/arstechnica/technology-lab');
    $zdnet_news = fetch_rss_news('https://www.zdnet.com/topic/artificial-intelligence/rss.xml');
    // $ai_trends_news = fetch_rss_news('https://www.aitrends.com/feed/');

    // 合并新闻条目
    $all_news = array_merge($ai_news, $ars_technica_news, $zdnet_news);

    // 将新闻保存到缓存文件
    file_put_contents($cache_file, json_encode($all_news));

    return $all_news;
}

// 读取缓存或抓取新闻
$all_news = load_or_fetch_news($cache_file, $cache_expiration);

// 分页逻辑
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$news_per_page = 10;
$total_news = count($all_news);
$total_pages = ceil($total_news / $news_per_page);
$start_index = ($page - 1) * $news_per_page;
$news_to_display = array_slice($all_news, $start_index, $news_per_page);

?>
<!DOCTYPE html>
<html lang="zh">
<?php $this->need("header.php"); ?>
<body class="jasmine-body">
<div class="jasmine-container grid grid-cols-12">
    <?php $this->need("component/sidebar-left.php"); ?>
    <div class="flex col-span-12 lg:col-span-8 flex-col border-x-2 border-stone-100 dark:border-neutral-600 lg:pt-0 lg:px-6 pb-10 px-3">
        <?php $this->need("component/menu.php"); ?>
        <div class="flex flex-col gap-y-12">
            <!-- AI 新闻推荐内容开始 -->
            <div id="app" class="ai-news-recommendation">
                <h1 style="text-align:center;">AI News Recommendations</h1>
                <div class="news-container">
                    <div v-for="news in paginatedNewsList" :key="news.link" class="news-card">
                        <h3><a :href="news.link" target="_blank">{{ news.title }}</a></h3>
                        <!--<p>{{ truncate(news.description, 100) }}</p>-->
                        <small>Source: {{ news.source }} | {{ formatDate(news.pubDate) }}</small>
                    </div>
                </div>
                <!-- 分页按钮 -->
                <div class="pagination">
                    <button @click="prevPage" :disabled="currentPage === 1">Previous</button>
                    <span>Page {{ currentPage }} of {{ totalPages }}</span>
                    <button @click="nextPage" :disabled="currentPage === totalPages">Next</button>
                </div>
            </div>
            <!-- AI 新闻推荐内容结束 -->
        </div>
    </div>
    <div class="hidden lg:col-span-3 lg:block" id="sidebar-right">
        <?php $this->need("component/sidebar.php"); ?>
    </div>
</div>
<?php $this->need("footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script>
  new Vue({
    el: '#app',
    data() {
      return {
        newsList: <?php echo json_encode($all_news); ?>, // 从PHP获取的新闻列表
        currentPage: 1,        // 当前页数
        itemsPerPage: 10       // 每页显示的条目数
      };
    },
    computed: {
      // 计算分页后的新闻条目
      paginatedNewsList() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        const end = start + this.itemsPerPage;
        return this.newsList.slice(start, end);
      },
      // 计算总页数
      totalPages() {
        return Math.ceil(this.newsList.length / this.itemsPerPage);
      }
    },
    methods: {
      // 截取内容摘要
      truncate(text, length) {
        return text && text.length > length ? text.substring(0, length) + '...' : text;
      },
      // 格式化日期
      formatDate(date) {
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        return new Date(date).toLocaleDateString(undefined, options);
      },
      // 下一页
      nextPage() {
        if (this.currentPage < this.totalPages) {
          this.currentPage++;
        }
      },
      // 上一页
      prevPage() {
        if (this.currentPage > 1) {
          this.currentPage--;
        }
      }
    }
  });
</script>

<style>
  .news-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* 2列布局 */
    gap: 20px;
    margin: 20px;
  }

  .news-card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 15px;
    text-align: center;
    transition: all 0.3s ease-in-out;
  }

  .news-card:hover {
    transform: scale(1.05);
  }

  .news-card h3 {
    font-size: 1.2em;
    margin-bottom: 10px;
  }

  .pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
  }

  .pagination button {
    background-color: #007bff;
    border: none;
    color: white;
    padding: 10px 20px;
    margin: 0 5px;
    cursor: pointer;
  }

  .pagination button[disabled] {
    background-color: #ccc;
    cursor: not-allowed;
  }

  .pagination span {
    display: inline-block;
    padding: 10px 20px;
  }
</style>

</body>
</html>
