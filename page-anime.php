<?php
/**
 * 番剧推荐
 *
 * @package custom
 */
if (!defined("__TYPECHO_ROOT_DIR__")) {
  exit();
}
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
            <!-- 动漫推荐内容开始 -->
            <div id="app" class="anime-recommendation">
                <h1 style="text-align:center;">Anime Recommendations</h1>
                <div class="anime-container">
                    <div v-for="anime in paginatedAnimeList" :key="anime.mal_id" class="anime-card">
                        <img :src="anime.images.jpg.image_url" :alt="anime.title">
                        <h3>{{ anime.title }}</h3>
                        <!-- 只显示内容摘要 -->
                        <!--<p>{{ truncate(anime.synopsis, 100) }}</p>-->
                    </div>
                </div>
                <!-- 分页按钮 -->
                <div class="pagination">
                    <button @click="prevPage" :disabled="currentPage === 1">Previous</button>
                    <span>Page {{ currentPage }} of {{ totalPages }}</span>
                    <button @click="nextPage" :disabled="currentPage === totalPages">Next</button>
                </div>
            </div>
            <!-- 动漫推荐内容结束 -->
        </div>
    </div>
    <div class="hidden lg:col-span-3 lg:block" id="sidebar-right">
        <?php $this->need("component/sidebar.php"); ?>
    </div>
</div>
<?php $this->need("footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  new Vue({
    el: '#app',
    data() {
      return {
        animeList: [],         // 存储所有的动漫数据
        currentPage: 1,        // 当前页数
        itemsPerPage: 16       // 每页显示的条目数
      };
    },
    computed: {
      // 计算分页后的动漫条目
      paginatedAnimeList() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        const end = start + this.itemsPerPage;
        return this.animeList.slice(start, end);
      },
      // 计算总页数
      totalPages() {
        return Math.ceil(this.animeList.length / this.itemsPerPage);
      }
    },
    mounted() {
      // 使用 Jikan v4 API 获取正在播出的动漫
      axios.get('https://api.jikan.moe/v4/top/anime?filter=airing')
        .then(response => {
          // API v4的返回数据在data.data中
          this.animeList = response.data.data;
        })
        .catch(error => {
          console.error("Error fetching data from Jikan API:", error);
        });
    },
    methods: {
      // 截取内容摘要
    //   truncate(text, length) {
    //     return text && text.length > length ? text.substring(0, length) + '...' : text;
    //   },
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
  .anime-container {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr)); /* 保持4列布局，自动调整宽度 */
    gap: 20px;
    margin: 20px;
  }

  .anime-card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 15px;
    text-align: center;
    transition: all 0.3s ease-in-out;
  }

  .anime-card:hover {
    transform: scale(1.05);
  }

  .anime-card img {
    width: 100%;
    height: auto;
    border-radius: 10px;
  }

  .anime-card h3 {
    font-size: 1.0em;
    margin: 10px 0;
  }

  /*.anime-card p {*/
  /*  font-size: 0.9em;*/
  /*  color: #666;*/
  /*}*/

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

  /* 自适应不同屏幕的缩放 */
  @media (max-width: 1200px) {
    .anime-card {
      padding: 12px;
    }
    .anime-card img {
      width: 90%;
    }
    .anime-card h3 {
      font-size: 1.1em;
    }
    .anime-card p {
      font-size: 0.85em;
    }
  }

  @media (max-width: 992px) {
    .anime-card {
      padding: 10px;
    }
    .anime-card img {
      width: 85%;
    }
    .anime-card h3 {
      font-size: 1em;
    }
    .anime-card p {
      font-size: 0.8em;
    }
  }

  @media (max-width: 768px) {
    .anime-card {
      padding: 8px;
    }
    .anime-card img {
      width: 80%;
    }
    .anime-card h3 {
      font-size: 0.9em;
    }
    .anime-card p {
      font-size: 0.75em;
    }
  }

  @media (max-width: 576px) {
    .anime-card {
      padding: 6px;
    }
    .anime-card img {
      width: 75%;
    }
    .anime-card h3 {
      font-size: 0.85em;
    }
    .anime-card p {
      font-size: 0.7em;
    }
  }

  /* 避免卡片内容溢出边界 */
  body {
    overflow-x: hidden;
  }
</style>

</body>
</html>
