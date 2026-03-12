<title>Shop | Bulk Clothing Supplier – House of Stitches</title>
<meta name="description"
  content="Browse our wholesale kidswear shop – premium bulk clothing for boys & girls aged 6–15 years. Trusted supplier in India for bulk orders only. Quality at scale.">
<meta name="keywords"
  content="wholesale kidswear shop, bulk kids clothing India, wholesale children’s fashion, kidswear supplier India, wholesale boys & girls wear, bulk order kids clothes, kidswear wholesale online, wholesale kids clothing distributor, House of Stitches shop, kidswear wholesale supplier">

<div class="main_banner">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 px-0">
        <img src="<?php echo base_url(); ?>assets/gallery/shop.webp" alt="Shop" class="w-100">
      </div>
    </div>
  </div>
</div>

<div class="shop-area">
  <div class="container-lg container-xxl">
    <div class="row g-lg-4 g-3">
      <div class="col-lg-4 col-xl-3 d-lg-block d-none">
        <div class="all-shop-filters">
          <div class="top-shop-sidebar">
            <p class="wg-title gfamily">SHOP BY</p>
          </div>
          <?php
          // Active filter state from GET (for initial page load pre-selection)
          $active_cats    = array_filter(array_map('intval', explode(',', $_GET['category'] ?? '')));
          $active_seasons = array_map('strtolower', array_filter(array_map('trim', explode(',', $_GET['season'] ?? ''))));
          $active_genders = strtolower(trim($_GET['gender'] ?? ''));
          $active_sizes   = array_filter(array_map('trim', explode(',', $_GET['search_in_size'] ?? '')));
          ?>

          <div class="shop-one">
            <p class="filter-title">Gender</p>
            <ul class="product_categories filter_height">
              <?php foreach (['Girls','Boys','Infant','Unisex'] as $gen): ?>
              <li class="go-gender" data-gender="<?= $gen ?>">
                <label class="filter-radio">
                  <input type="checkbox" class="go-gender-cb" name="gender_filter"
                    value="<?= $gen ?>"
                    <?= (strtolower($gen) === $active_genders) ? 'checked' : '' ?>>
                  <span class="check-box"></span>
                  <span class="check-label"><?= $gen ?></span>
                </label>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <?php if (!empty($filter_seasons)): ?>
          <div class="shop-one">
            <p class="filter-title">Season</p>
            <ul class="product_categories filter_height">
              <?php foreach ($filter_seasons as $ssn): ?>
              <li>
                <label class="filter-radio">
                  <input type="checkbox" class="go-season" name="season_filter"
                    value="<?= htmlspecialchars($ssn) ?>"
                    <?= in_array(strtolower($ssn), $active_seasons) ? 'checked' : '' ?>>
                  <span class="check-box"></span>
                  <span class="check-label"><?= htmlspecialchars(ucwords(strtolower($ssn))) ?></span>
                </label>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>

          <?php if (!empty($all_categories)): ?>
          <div class="shop-one">
            <p class="filter-title">Categories</p>
            <ul class="product_categories filter_height">
              <?php foreach ($all_categories as $cat): ?>
              <li class="go-category" data-category="<?= (int)$cat['id'] ?>">
                <label class="filter-radio">
                  <input type="checkbox" class="go-category" name="category_filter"
                    value="<?= (int)$cat['id'] ?>"
                    <?= in_array((int)$cat['id'], $active_cats) ? 'checked' : '' ?>>
                  <span class="check-box"></span>
                  <span class="check-label"><?= htmlspecialchars($cat['name']) ?></span>
                </label>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>

          <?php
          // Dynamic size values from product_variations + products_translations
          $dyn_sizes = isset($filter_sizes) ? $filter_sizes : [];
          if (!empty($dyn_sizes)): ?>
          <div class="shop-one">
            <p class="filter-title">Size</p>
            <ul class="product_categories filter_height">
              <?php foreach ($dyn_sizes as $sz): ?>
              <li>
                <label class="filter-radio">
                  <input type="checkbox" class="go-size" name="size_filter"
                    value="<?= htmlspecialchars($sz) ?>"
                    <?= in_array($sz, $active_sizes) ? 'checked' : '' ?>>
                  <span class="check-box"></span>
                  <span class="check-label"><?= htmlspecialchars($sz) ?></span>
                </label>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>

          <div class="shop-one">
            <button type="button" id="clear-filters-btn" class="btn btn-sm btn-outline-secondary w-100">Clear Filters</button>
          </div>
          <!-- <div class="shop-one">
            <p class="filter-title">Our Brand</p>
            <div class="product_categories">
              <div id="nav-categories">
                <?php

                function loop_tree($pages, $is_recursion = false)
                {
                ?>
                  <ul class="<?= $is_recursion === true ? 'children' : 'parent' ?>">
                    <?php
                    foreach ($pages as $page) {
                      $children = false;
                      if (isset($page['children']) && !empty($page['children'])) {
                        $children = true;
                      }
                      if (!empty($page['name'])) {
                    ?>
                        <li>
                          <a href="javascript:void(0);" data-categorie-id="<?= $page['id'] ?>" class="go-category left-side <?= isset($_GET['category']) && $_GET['category'] == $page['id'] ? 'selected' : '' ?>">
                            <?= htmlspecialchars($page['name'], ENT_QUOTES, 'UTF-8') ?>
                          </a>
                          <?php
                          /* if ($children === true) {
                                        loop_tree($page['children'], true);
                                    } else {*/
                          ?>
                        </li>
                    <?php
                        //}
                      }
                    }
                    ?>
                  </ul>
                  <?php
                  if ($is_recursion === true) {
                  ?>
                    </li>
                <?php
                  }
                }

                loop_tree($home_categories);
                ?>
              </div>
            </div>
          </div> -->
          <!-- <div class="shop-one">
            <p class="filter-title">Choose Color</p>
            <ul class="product_categories filter_height" id="fill"> -->
          <?php
          // $colors = [
          //     '6 COL' => '#000000',  // Default black, adjust as needed
          //     'A,GREEN' => '#00FF00',
          //     'AFTER SUN' => '#FFA500',
          //     'AIR FORCE' => '#5D8AA8',
          //     'AIRFORCE BLUE' => '#5D8AA8',
          //     'ANTHRA' => '#293462',
          //     'APRICOT' => '#FBCEB1',
          //     'AQUA' => '#00FFFF',
          //     'AQUA BLUE' => '#4FC3F7',
          //     'AQUA SKY' => '#7FCEFF',
          //     'ASH' => '#B2BEB5',
          //     'ASH GREY' => '#B2BEB5',
          //     'B.GREEN' => '#228B22',
          //     'BABY BLUE' => '#89CFF0',
          //     'BABY PINK' => '#F4C2C2',
          //     'BEIGE' => '#F5F5DC',
          //     'BISCUIT' => '#E8DAB2',
          //     'BISKIT' => '#E8DAB2',
          //     'BIT OF BLUE' => '#4682B4',
          //     'BLACK' => '#000000',
          //     'BLAZING YELLOW' => '#FFFF00',
          //     'BLUE' => '#0000FF',
          //     'BLUE FOREST' => '#228B22',
          //     'BLUE MILLA' => '#4169E1',
          //     'BLUE MILLANGE' => '#4169E1',
          //     'BLUSH' => '#DE5D83',
          //     'BOSSY PINK' => '#FF1493',
          //     'BRICKS' => '#B22222',
          //     'BROWN' => '#8B4513',
          //     'BURGUNDY' => '#800020',
          //     'BURNET ORANGE' => '#CC5500',
          //     'BUTTER' => '#FFFF99',
          //     'BUTTER CREAM' => '#FFFDD0',
          //     'BUTTER MILK' => '#FFF8DC',
          //     'BUTTER YELLOW' => '#FFFF99',
          //     'C.GRAY' => '#808080',
          //     'C.GREEN' => '#228B22',
          //     'CAMEL' => '#C19A6B',
          //     'CANDY' => '#FF69B4',
          //     'CANDY PINK' => '#FF69B4',
          //     'CARAMEL PEACH' => '#F4A460',
          //     'CARBON BLACK' => '#1C2526',
          //     'CAREMEL' => '#C68E17',
          //     'CEMENT' => '#8D8172',
          //     'CHALK GRAY' => '#D3D3D3',
          //     'CHALK PINK' => '#FADADD',
          //     'CHAMPAGNE BEIGE' => '#F7E7CE',
          //     'CHARCOAL GREY' => '#36454F',
          //     'CHARCOL' => '#36454F',
          //     'CHERRY' => '#DE3163',
          //     'CHICORY COFFEE' => '#4B2E2A',
          //     'CHOCOLATE' => '#D2691E',
          //     'CLASSIC BLUE' => '#0F4C81',
          //     'COFFEE' => '#6F4E37',
          //     'COOLED GREEN' => '#90EE90',
          //     'CORAL' => '#FF7F50',
          //     'CREAM' => '#FFFDD0',
          //     'CUPCAKE LINK' => '#FFB6C1',
          //     'CYAN BLUE' => '#00B7EB',
          //     'CYBER YELLOW' => '#FFD700',
          //     'D.GRAY' => '#696969',
          //     'D.GREY' => '#696969',
          //     'D.LILAC' => '#C8A2C8',
          //     'D.OLIVE' => '#556B2F',
          //     'D.PEACH' => '#FF9999',
          //     'DARK BLUE' => '#00008B',
          //     'DARK BROWN' => '#654321',
          //     'DARK FAWN' => '#7C4D3B',
          //     'DARK GREEN' => '#006400',
          //     'DARK TEAL' => '#014D4E',
          //     'DENIM BLUE' => '#1560BD',
          //     'DESERT SAND' => '#EDC9AF',
          //     'DOWNTOWN BROWN' => '#8B4513',
          //     'DUSK RED' => '#8B0000',
          //     'DUSTY BLUE' => '#6699CC',
          //     'DUSTY BROWN' => '#8B7355',
          //     'DUSTY GREEN' => '#6B8E23',
          //     'DUSTY MAUVE' => '#917393',
          //     'DUSTY PINK' => '#DCAE96',
          //     'DUSTY ROSE' => '#DCAE96',
          //     'DUSTY STEEL BLUE' => '#4682B4',
          //     'DX' => '#696969',
          //     'E.BLUE' => '#1E90FF',
          //     'F' => '#FF1493',
          //     'FAWN' => '#E5AA68',
          //     'FLUSHING PINK' => '#FF69B4',
          //     'FOAM GREEN' => '#90EE90',
          //     'FOREST GREEN' => '#228B22',
          //     'FUSCIA' => '#FF00FF',
          //     'GERANIUM PINK' => '#FF1493',
          //     'GOLD' => '#FFD700',
          //     'GOSSAMER GREEN' => '#90EE90',
          //     'GRAY' => '#808080',
          //     'GRAY MILL' => '#778899',
          //     'GRAY WHALE' => '#778899',
          //     'GREEN' => '#008000',
          //     'GREEN MILLANGE' => '#228B22',
          //     'GREY' => '#808080',
          //     'H.PINK' => '#FF69B4',
          //     'HIBISCUS RED' => '#DC143C',
          //     'HONEY BRONZE' => '#B5651D',
          //     'ICE' => '#E0FFFF',
          //     'ICE GREEN' => '#E0FFE0',
          //     'ICE SKY' => '#B0E0E6',
          //     'KHAKI' => '#F0E68C',
          //     'KIKO GREEN' => '#32CD32',
          //     'KIWI GREEN' => '#8FBC8F',
          //     'L-PEACH' => '#FFDAB9',
          //     'L.BLUE' => '#ADD8E6',
          //     'L.CORAL' => '#F08080',
          //     'L.GREEN' => '#90EE90',
          //     'L.ORANGE' => '#FFA07A',
          //     'LAVENDER' => '#E6E6FA',
          //     'LEAF GREEN' => '#6B8E23',
          //     'LEMON' => '#FFF44F',
          //     'LEMON MERINGUE' => '#F59E42',
          //     'LEMONDE' => '#FFF44F',
          //     'LETTE' => '#F4A460',
          //     'LIGHT FAWN' => '#E5AA68',
          //     'LIGHT PEACH' => '#FFDAB9',
          //     'LIGHT TAUPE' => '#B38B6D',
          //     'LILAC' => '#C8A2C8',
          //     'LIME' => '#00FF00',
          //     'LIME GREEN' => '#32CD32',
          //     'LIME YELLOW' => '#BFFF00',
          //     'LT-GRAY' => '#D3D3D3',
          //     'LT.BLUE' => '#ADD8E6',
          //     'LT.PINK' => '#FFB6C1',
          //     'M.GREEN' => '#228B22',
          //     'MANGO' => '#FFCC00',
          //     'MEHANDI' => '#90EE90',
          //     'MEHROON' => '#8B0000',
          //     'MELLOW YELLOW' => '#F0E68C',
          //     'MIDNIGHT BLUE' => '#191970',
          //     'MILTED BUTTER' => '#FFFF99',
          //     'MINT' => '#98FB98',
          //     'MINT GREEN' => '#98FB98',
          //     'MIX' => '#808080',
          //     'MOCHA MOUSSE' => '#8B4513',
          //     'MOSS GREEN' => '#8A9A5B',
          //     'MOUSE' => '#808080',
          //     'MULTI' => '#808080',
          //     'MULTI CHECKS' => '#808080',
          //     'MUSTARD' => '#FFDB58',
          //     'N.GREEN' => '#228B22',
          //     'NAVY' => '#000080',
          //     'OFF-WHITE' => '#FAF9F6',
          //     'OLIVE' => '#808000',
          //     'OLIVE GREEN' => '#6B8E23',
          //     'ONION' => '#F4A460',
          //     'ORANGE' => '#FFA500',
          //     'ORANGE PEEL' => '#FFA500',
          //     'P.BLUE' => '#1E90FF',
          //     'P.GREEN' => '#32CD32',
          //     'PALE MAUVE' => '#DDA0DD',
          //     'PALE PEACH' => '#FFDAB9',
          //     'PASTEL LILAC' => '#DDA0DD',
          //     'PASTEL YELLOW' => '#FDFD96',
          //     'PEACH' => '#FFCBA4',
          //     'PEACH BLUSH' => '#FFCBA4',
          //     'PEACH CLAY' => '#F4A460',
          //     'PEACH DUST' => '#F4A460',
          //     'PEACH MIST' => '#FFDAB9',
          //     'PETCH' => '#FF9999',
          //     'PINK' => '#FFC0CB',
          //     'PINK MILL.' => '#FF69B4',
          //     'PISTA' => '#93C572',
          //     'PISTACHIO GREEN' => '#93C572',
          //     'POWDER' => '#B0E0E6',
          //     'POWDER BLUE' => '#B0E0E6',
          //     'PULM VOILET' => '#8A2BE2',
          //     'PURPLE' => '#800080',
          //     'QUIET GREEN' => '#90EE90',
          //     'R.BLUE' => '#4169E1',
          //     'R.GREEN' => '#228B22',
          //     'RASPBERY PINK' => '#FF5C8A',
          //     'RAW' => '#8B4513',
          //     'RED' => '#FF0000',
          //     'ROSE' => '#FF007F',
          //     'ROSE DUST' => '#DCAE96',
          //     'RUST' => '#B7410E',
          //     'RUSTED GOLD' => '#DAA520',
          //     'RUSTIC BROWN' => '#8B4513',
          //     'S.BLUE' => '#4682B4',
          //     'SAGE' => '#BCB88A',
          //     'SAGE GREEN' => '#BCB88A',
          //     'SAND BEIGE' => '#F4A460',
          //     'SEPIA ROSE' => '#9C661F',
          //     'SHARK GREY' => '#2C3539',
          //     'SILVER CLOUD' => '#C0C0C0',
          //     'SKY BLUE' => '#87CEEB',
          //     'SLATE TEAL' => '#008080',
          //     'SMOKE GREEN' => '#8FBC8F',
          //     'SOFT GREY' => '#D3D3D3',
          //     'SOFT MINT' => '#98FB98',
          //     'STEAL GREY' => '#808080',
          //     'SUBTLE GREEN' => '#90EE90',
          //     'SULFER YELLOW' => '#FFFF00',
          //     'SUNLIT VANILLA' => '#FFFDD0',
          //     'SURF' => '#00CED1',
          //     'T.BLUE' => '#4682B4',
          //     'TANDER YELLOW' => '#F0E68C',
          //     'TANGERINE RUSH' => '#FF8C00',
          //     'TEA GREEN' => '#D0F0C0',
          //     'TEAL' => '#008080',
          //     'TOFFEE' => '#C68E17',
          //     'UDX' => '#696969',
          //     'ULTIMATE GRAY' => '#939597',
          //     'VANILA CREAM' => '#FFFDD0',
          //     'VANILLA' => '#F3E5AB',
          //     'VIOLET' => '#8F00FF',
          //     'WARM NUDE' => '#E8CDBA',
          //     'WARM PINK' => '#FF69B4',
          //     'WHITE' => '#FFFFFF',
          //     'WHITE MIL.' => '#FFFAFA',
          //     'WINE' => '#722F37',
          //     'YELLOW' => '#FFFF00',
          //     'YELLOW OCHRE' => '#CC7722'
          // ];

          $colors = isset($colors) ? $colors : [];
          foreach ($colors as $name => $hexCode): ?>
            <li class="cat-item d-flex align-items-center" style="position: static!important; cursor:pointer;">
              <a class="go-color" data-brand-color="<?php echo $name; ?>"><?php echo htmlspecialchars($name); ?></a>
              <span class="color-box" style="background:<?php echo $hexCode; ?>;"></span>
              <span class="count"></span>
            </li>
          <?php endforeach; ?>
          <!--<div class="shop-one">
            <p class="filter-title">Fabric</p>
            <ul class="product_categories">
              <li class="cat-item">
                <a href="<?php echo base_url('home/shop'); ?>">Cotton</a>
                <span class="count">()</span>
              </li>
              <li class="cat-item">
                <a href="<?php echo base_url('home/shop'); ?>">Polyester</a>
                <span class="count">()</span>
              </li>
              <li class="cat-item">
                <a href="<?php echo base_url('home/shop'); ?>">Linen</a>
                <span class="count">()</span>
              </li>
              <li class="cat-item">
                <a href="<?php echo base_url('home/shop'); ?>">Denim</a>
                <span class="count">()</span>
              </li>
              <li class="cat-item">
                <a href="<?php echo base_url('home/shop'); ?>">Silk</a>
                <span class="count">()</span>
              </li>
              <li class="cat-item">
                <a href="<?php echo base_url('home/shop'); ?>">Wool</a>
                <span class="count"></span>
              </li>
            </ul>
          </div>-->
        </div>
      </div>
      <div class="col-lg-8 col-xl-9 col-12">
        <div class="row">
          <div class="col-12">
            <div class="features-tab">
              <div class="shop-all-tab d-lg-flex">
                <div class="row w-100 d-flex justify-content-between align-items-center g-2">
                  <div class="col-lg-4 col-md-6 col-9">
                    <div class="shop5">
                      <label style="width: 100px;">Sort By :</label>
                      <select class="selectpicker order form-control" data-order-to="order_new">
                        <option>Select Order By</option>
                        <option <?= isset($_GET['order_new']) && $_GET['order_new'] == "desc" ? 'selected' : '' ?> <?= !isset($_GET['order_new']) || $_GET['order_new'] == "" ? 'selected' : '' ?> value="desc"><?= lang('new') ?> </option>
                        <option <?= isset($_GET['order_new']) && $_GET['order_new'] == "asc" ? 'selected' : '' ?> value="asc"><?= lang('old') ?> </option>
                        <option value="offer_desc" <?= (isset($sort) && $sort === 'offer_desc') ? 'selected' : '' ?>>
                          <?= lang('highest offer') ?>
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <div class="shop5">
                      <button title="Download full page pdf" onclick="divToPdf('product-cards', 'invoice-123.pdf')" class="btn btn-outline-dark rounded-0"><i class="bi bi-cloud-download"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-content" id="product-cards">
                <div class="shop-tab">
                  <div class="row g-2" id="catalog" aria-live="polite">
                    <?php
                    $all_variations = isset($variations) ? $variations : [];
                    if (isset($products)) {
                      foreach ($products as $val) {  ?>
                        <?php
                          $prod_url = base_url($val['url'] . '_' . $val['id']);
                          $folderPath = $_SERVER['DOCUMENT_ROOT'] . '/attachments/shop_images/';
                          $imagePath  = $folderPath . trim($val['image']);
                        ?>
                        <div class="col-lg-3 col-md-4 col-6">
                          <div class="tb-product-item-inner">
                            <div class="card product-card border-0">
                              <a href="<?= $prod_url ?>">
                                <?php if (is_file($imagePath)): ?>
                                  <div class="product-img-wrapper">
                                    <img alt="<?= htmlspecialchars($val['title']) ?>"
                                      src="<?= base_url('attachments/shop_images/' . $val['image']) ?>"
                                      style="object-fit:scale-down;"
                                      class="w-100 img_products"
                                      onload="this.parentElement.classList.remove('skeleton')">
                                    <span class="brand-badge-animated"><?= htmlspecialchars($val['brand']) ?></span>
                                  </div>
                                <?php else: ?>
                                  <img alt="<?= htmlspecialchars($val['title']) ?>"
                                    src="<?= base_url('attachments/shop_images/' . $val['image']) ?>"
                                    onerror="this.onerror=null;this.src='<?= base_url('/attachments/shop_images/spark_logo-06.jpg') ?>';"
                                    style="object-fit:scale-down!important;" class="w-100 img_products"
                                    onload="this.parentElement.classList.remove('skeleton')">
                                <?php endif; ?>
                              </a>
                            </div>
                            <div><a href="javascript:void(0);"><i data-product-id="<?= $val['id'] ?>" class="<?= in_array($val['id'], $wishlist_ids ?? []) ? 'bi bi-heart-fill text-danger' : 'bi bi-heart' ?> wishlist-btn"></i></a></div>
                            <ul class="list-unstyled tb-content">
                              <li><a href="<?= $prod_url ?>"><?= htmlspecialchars($val['title']) ?></a></li>
                              <li><a href="<?= $prod_url ?>" class="text-muted small"><?= htmlspecialchars(mb_strimwidth(strip_tags($val['description']), 0, 60, '...')) ?></a></li>
                              <li class="small var-chips">
                                <?php if (!empty($all_variations[$val['id']])): ?>
                                  <?php foreach ($all_variations[$val['id']] as $v): if (trim($v['color'])): ?>
                                    <span class="var-tag-color"><?= htmlspecialchars(trim($v['color'])) ?></span>
                                  <?php endif; endforeach; ?>
                                <?php else: ?>
                                  <span class="text-muted"><?= htmlspecialchars($val['color']) ?></span>
                                <?php endif; ?>
                              </li>
                              <li class="var-chips">
                                <?php if (!empty($all_variations[$val['id']])): ?>
                                  <?php
                                    $uniq_sizes = [];
                                    foreach ($all_variations[$val['id']] as $v) {
                                      foreach (array_map('trim', explode(',', $v['sizes'])) as $s) {
                                        if ($s !== '') $uniq_sizes[$s] = $s;
                                      }
                                    }
                                  ?>
                                  <?php foreach ($uniq_sizes as $s): ?>
                                    <span class="var-tag-size"><?= htmlspecialchars($s) ?></span>
                                  <?php endforeach; ?>
                                <?php else: ?>
                                  <span class="text-muted"><?= htmlspecialchars($val['size_range']) ?></span>
                                <?php endif; ?>
                              </li>
                              <li>
                                <ol class="price-list">
                                  <li>WSP <?= $val['wsp'] ?> /-</li>
                                  <li>MRP <?= $val['msp'] ?> /-</li>
                                </ol>
                              </li>
                              <li>
                                <a href="javascript:void(0);" data-price="<?= $val['wsp'] ?>" data-mrp="<?= $val['msp'] ?>" class="btn btn-dark w-100 rounded-pill mt-2 add-to-cart_new" data-action="add" data-id="<?= $val['id'] ?>">Add To Cart</a>
                              </li>
                            </ul>
                          </div>
                        </div>
                    <?php  }
                    }
                    ?>
                  </div>
                </div>
              </div>
              <!-- Hidden filter state inputs -->
              <div id="filter-state" style="display:none;">
                <input type="hidden" name="category" id="fs_category" value="">
                <input type="hidden" name="season" id="fs_season" value="">
                <input type="hidden" name="gender" id="fs_gender" value="">
                <input type="hidden" name="search_in_title" id="fs_title" value="">
                <input type="hidden" name="search_in_brand" id="fs_brand" value="">
                <input type="hidden" name="search_in_desc" id="fs_desc" value="">
                <input type="hidden" name="search_in_color" id="fs_color" value="">
                <input type="hidden" name="search_in_size" id="fs_size" value="">
                <input type="hidden" name="order_new" id="fs_order_new" value="">
                <input type="hidden" name="order_price" id="fs_order_price" value="">
                <input type="hidden" name="price_from" id="fs_price_from" value="">
                <input type="hidden" name="price_to" id="fs_price_to" value="">
                <input type="hidden" name="brand_id" id="fs_brand_id" value="">
              </div>
              <div id="filter-result-count" class="text-muted small px-1 mb-1"></div>
              <div class="shop-all-tab-nor">
                <ul class="pagination justify-content-center align-items-center gap-3 mt-3">
                  <?php if ($links_pagination != '') { ?>
                    <div class="row">
                      <div class="col-sm-6 col-sm-offset-3">
                        <?= $links_pagination ?>
                      </div>
                    </div>
                  <?php } ?>
                </ul>
              </div>
              <div class="copyfilter d-lg-none">
                <div aria-label="Sort By" data-at="sort-by" class="sortdroupdown" id="sortshowBtn"
                  onclick="document.getElementById('sortpanel').hidden=false;this.setAttribute('aria-expanded','true')">
                  <div class="filtername">Sort By<div class="n-subtitle">Popularity</div>
                  </div>
                  <div class="filtericon"><i class="bi bi-sort-up"></i></div>
                </div>
                <div class="filterborder"></div>
                <div aria-label="Filter" data-at="plp-filters-btn" class="sortdroupdown" id="filtershowBtn"
                  onclick="document.getElementById('filterpanel').hidden=false;this.setAttribute('aria-expanded','true')">
                  <div class="filtername">Filter<div class="n-subtitle"><span>Applied
                        <div class="applied-filter">0</div>
                      </span></div>
                  </div>
                  <div class="filtericon"><i class="bi bi-sliders2"></i></div>
                </div>
              </div>
              <div id="sortpanel" hidden>
                <div class="filtershadow"></div>
                <div class="shortbycontent">
                  <p class="title">Sort by <span class="float-end"
                      onclick="document.getElementById('sortpanel').hidden=true;document.getElementById('sortshowBtn').setAttribute('aria-expanded','false');document.getElementById('sortshowBtn').focus()"><i
                        class="bi bi-x-square"></i></span></p>
                  <ul class="short-list" role="radiogroup" aria-label="Sort by">
                    <li class="short is-selected">
                      <span class="short-label">Popularity</span>
                      <input class="radio" type="radio" name="sort" value="Popularity" checked>
                    </li>
                    <li class="short">
                      <span class="short-label">Price Low To High</span>
                      <input class="radio" type="radio" name="sort" value="Price Low To High">
                    </li>
                    <li class="short">
                      <span class="short-label">Price High To Low</span>
                      <input class="radio" type="radio" name="sort" value="Price High To Low">
                    </li>
                    <li class="short">
                      <span class="short-label">New Arrivals</span>
                      <input class="radio" type="radio" name="sort" value="New Arrivals">
                    </li>
                    <li class="short">
                      <span class="short-label">Bestseller</span>
                      <input class="radio" type="radio" name="sort" value="Bestseller">
                    </li>
                    <li class="short">
                      <span class="short-label">Discount High to Low</span>
                      <input class="radio" type="radio" name="sort" value="Discount High to Low">
                    </li>
                    <li class="short">
                      <span class="short-label">Fastest Shipping Time</span>
                      <input class="radio" type="radio" name="sort" value="Fastest Shipping Time">
                    </li>
                  </ul>
                </div>
              </div>
              <div id="filterpanel" hidden>
                <div class="filtershadow"></div>
                <div class="filtercontent">
                  <div class="f-header">
                    <p class="title">Filters</p>
                  </div>
                  <div class="f-content">
                    <ul class="nav" role="tablist">
                      <li class="nav-item" role="presentation"> <button class="filterheading active position-relative"
                          id="pills-gender" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab"
                          aria-controls="pills-home" aria-selected="true">Gender</button>
                      </li>
                      <li class="nav-item" role="presentation"> <button class="filterheading position-relative"
                          id="pills-category-tab" data-bs-toggle="pill" data-bs-target="#pills-category" type="button"
                          role="tab" aria-controls="pills-category" aria-selected="false">Category</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="filterheading position-relative" id="pills-size-tab" data-bs-toggle="pill"
                          data-bs-target="#pills-size" type="button" role="tab" aria-controls="pills-size"
                          aria-selected="false">Size</button>
                      </li>
                      <li class="nav-item" role="presentation"> <button class="filterheading position-relative"
                          id="pills-price-tab" data-bs-toggle="pill" data-bs-target="#pills-price" type="button"
                          role="tab" aria-controls="pills-price" aria-selected="false">Price</button>
                      </li>
                      <li class="nav-item" role="presentation"> <button class="filterheading position-relative"
                          id="pills-label-tab" data-bs-toggle="pill" data-bs-target="#pills-label" type="button"
                          role="tab" aria-controls="pills-label" aria-selected="false">Product Label</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="filterheading position-relative" id="pills-color-tab" data-bs-toggle="pill"
                          data-bs-target="#pills-color" type="button" role="tab" aria-controls="pills-color"
                          aria-selected="false">Color</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="filterheading position-relative" id="pills-pattern-tab" data-bs-toggle="pill"
                          data-bs-target="#pills-pattern" type="button" role="tab" aria-controls="pills-pattern"
                          aria-selected="false">Pattern</button>
                      </li>
                      <li class="nav-item" role="presentation"> <button class="filterheading position-relative"
                          id="pills-material-tab" data-bs-toggle="pill" data-bs-target="#pills-material" type="button"
                          role="tab" aria-controls="pills-material" aria-selected="false">Material</button>
                      </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                      <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-gender">
                        <ul class="short-list px-3" role="radiogroup" aria-label="Sort by">
                          <li class="short is-selected">
                            <span class="short-label">Boys</span>
                            <input class="radio" type="radio" name="sort" value="Boys" checked>
                          </li>
                          <li class="short">
                            <span class="short-label">Girls</span>
                            <input class="radio" type="radio" name="sort" value="Girls">
                          </li>
                        </ul>
                      </div>
                      <div class="tab-pane fade" id="pills-category" role="tabpanel"
                        aria-labelledby="pills-category-tab">
                        <ul class="short-list px-3" role="radiogroup" aria-label="Sort by">
                          <li class="short is-selected">
                            <span class="short-label">T-shirt</span>
                            <input class="radio" type="radio" name="sort" value="tshirt" checked>
                          </li>
                          <li class="short">
                            <span class="short-label">Shirt</span>
                            <input class="radio" type="radio" name="sort" value="shirt">
                          </li>
                          <li class="short">
                            <span class="short-label">Dresses</span>
                            <input class="radio" type="radio" name="sort" value="dresses">
                          </li>
                          <li class="short">
                            <span class="short-label">Bottom</span>
                            <input class="radio" type="radio" name="sort" value="bottom">
                          </li>
                          <li class="short">
                            <span class="short-label">Top's</span>
                            <input class="radio" type="radio" name="sort" value="top">
                          </li>
                          <li class="short">
                            <span class="short-label">Dungarees</span>
                            <input class="radio" type="radio" name="sort" value="dungarees">
                          </li>
                          <li class="short">
                            <span class="short-label">Set</span>
                            <input class="radio" type="radio" name="sort" value="set">
                          </li>
                          <li class="short">
                            <span class="short-label">Two Piece Sets</span>
                            <input class="radio" type="radio" name="sort" value="two-peice-sets">
                          </li>
                          <li class="short">
                            <span class="short-label">Three Piece Sets</span>
                            <input class="radio" type="radio" name="sort" value="three-peice-sets">
                          </li>
                        </ul>
                      </div>
                      <div class="tab-pane fade" id="pills-size" role="tabpanel" aria-labelledby="pills-size-tab">
                        <ul class="short-list px-3" role="radiogroup" aria-label="Sort by">
                          <li class="short is-selected">
                            <span class="short-label">06 - 24 Months</span>
                            <input class="radio" type="radio" name="sort" value="06-24m" checked>
                          </li>
                          <li class="short">
                            <span class="short-label">2 - 5 Years</span>
                            <input class="radio" type="radio" name="sort" value="2-5y">
                          </li>
                          <li class="short">
                            <span class="short-label">6 - 16 Years</span>
                            <input class="radio" type="radio" name="sort" value="6-16y">
                          </li>
                        </ul>
                      </div>
                      <div class="tab-pane fade" id="pills-price" role="tabpanel" aria-labelledby="pills-price-tab">
                        <ul class="short-list px-3" role="radiogroup" aria-label="Sort by Price">
                          <li class="short is-selected">
                            <span class="short-label">Under ₹500</span>
                            <input class="radio" type="radio" name="price" value="under-500" checked>
                          </li>
                          <li class="short">
                            <span class="short-label">₹500 – ₹1000</span>
                            <input class="radio" type="radio" name="price" value="500-1000">
                          </li>
                          <li class="short">
                            <span class="short-label">₹1000 – ₹2000</span>
                            <input class="radio" type="radio" name="price" value="1000-2000">
                          </li>
                          <li class="short">
                            <span class="short-label">Above ₹2000</span>
                            <input class="radio" type="radio" name="price" value="above-2000">
                          </li>
                        </ul>
                      </div>
                      <div class="tab-pane fade" id="pills-label" role="tabpanel" aria-labelledby="pills-label-tab">
                        <ul class="short-list px-3" role="radiogroup" aria-label="Sort by Price">
                          <li class="short">
                            <span class="short-label">Bloomup</span>
                            <input class="radio" type="radio" name="price" value="bloomup" checked>
                          </li>
                          <li class="short">
                            <span class="short-label">Spark</span>
                            <input class="radio" type="radio" name="price" value="spark">
                          </li>
                          <li class="short">
                            <span class="short-label">Sucasa</span>
                            <input class="radio" type="radio" name="price" value="sucas">
                          </li>
                          <li class="short">
                            <span class="short-label">Basic</span>
                            <input class="radio" type="radio" name="price" value="basic">
                          </li>
                          <li class="short">
                            <span class="short-label">Botton Noses</span>
                            <input class="radio" type="radio" name="price" value="bottton-noses">
                          </li>
                        </ul>
                      </div>
                      <div class="tab-pane fade" id="pills-color" role="tabpanel" aria-labelledby="pills-color-tab">
                        <ul class="short-list px-3" role="radiogroup" aria-label="Choose Color">
                          <li class="short is-selected d-flex align-items-center">
                            <a class="short-label me-2">Blue
                              <span class="color-box"
                                style="background:#0D6EFD; width:16px; height:16px; border-radius:4px; display:inline-block;"></span></a>
                            <input class="radio" type="radio" name="color" value="blue" checked>
                          </li>
                          <li class="short d-flex align-items-center">
                            <a class="short-label me-2">Green
                              <span class="color-box"
                                style="background:#198754; width:16px; height:16px; border-radius:4px; display:inline-block;"></span></a>
                            <input class="radio" type="radio" name="color" value="green">
                          </li>
                          <li class="short d-flex align-items-center">
                            <a class="short-label me-2">Gold
                              <span class="color-box"
                                style="background:#F4B400; width:16px; height:16px; border-radius:4px; display:inline-block;"></span></a>
                            <input class="radio" type="radio" name="color" value="gold">
                          </li>
                          <li class="short d-flex align-items-center">
                            <a class="short-label me-2">Dark
                              <span class="color-box"
                                style="background:#333333; width:16px; height:16px; border-radius:4px; display:inline-block;"></span></a>
                            <input class="radio" type="radio" name="color" value="dark">
                          </li>
                          <li class="short d-flex align-items-center">
                            <a class="short-label me-2">Light
                              <span class="color-box"
                                style="background:#F9FAFB; width:16px; height:16px; border-radius:4px; display:inline-block;"></span></a>
                            <input class="radio" type="radio" name="color" value="light">
                          </li>
                        </ul>
                      </div>
                      <div class="tab-pane fade" id="pills-pattern" role="tabpanel" aria-labelledby="pills-pattern-tab">
                        <ul class="short-list px-3" role="radiogroup" aria-label="Sort by Pattern">
                          <li class="short is-selected">
                            <span class="short-label">Solid (15)</span>
                            <input class="radio" type="radio" name="pattern" value="solid" checked>
                          </li>
                          <li class="short">
                            <span class="short-label">Striped (9)</span>
                            <input class="radio" type="radio" name="pattern" value="striped">
                          </li>
                          <li class="short">
                            <span class="short-label">Checked (7)</span>
                            <input class="radio" type="radio" name="pattern" value="checked">
                          </li>
                          <li class="short">
                            <span class="short-label">Printed (11)</span>
                            <input class="radio" type="radio" name="pattern" value="printed">
                          </li>
                          <li class="short">
                            <span class="short-label">Floral (6)</span>
                            <input class="radio" type="radio" name="pattern" value="floral">
                          </li>
                          <li class="short">
                            <span class="short-label">Geometric (5)</span>
                            <input class="radio" type="radio" name="pattern" value="geometric">
                          </li>
                        </ul>
                      </div>
                      <div class="tab-pane fade" id="pills-material" role="tabpanel" aria-labelledby="pills-material-tab">
                        <ul class="short-list px-3" role="radiogroup" aria-label="Sort by Fabric">
                          <li class="short is-selected">
                            <span class="short-label">Cotton (12)</span>
                            <input class="radio" type="radio" name="fabric" value="cotton" checked>
                          </li>
                          <li class="short">
                            <span class="short-label">Polyester (8)</span>
                            <input class="radio" type="radio" name="fabric" value="polyester">
                          </li>
                          <li class="short">
                            <span class="short-label">Linen (6)</span>
                            <input class="radio" type="radio" name="fabric" value="linen">
                          </li>
                          <li class="short">
                            <span class="short-label">Denim (5)</span>
                            <input class="radio" type="radio" name="fabric" value="denim">
                          </li>
                          <li class="short">
                            <span class="short-label">Silk (3)</span>
                            <input class="radio" type="radio" name="fabric" value="silk">
                          </li>
                          <li class="short">
                            <span class="short-label">Wool (4)</span>
                            <input class="radio" type="radio" name="fabric" value="wool">
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="f-actions gap-2">
                    <button kind="secondary" shape="default" class="btn_button w-25 fs-6"
                      onclick="document.getElementById('filterpanel').hidden=true;document.getElementById('filtershowBtn').setAttribute('aria-expanded','false');document.getElementById('filtershowBtn').focus()">Close</button>
                    <button kind="primary" disabled="" shape="default" class="btn btn-dark fs-4 rounded-0 w-75">Apply Filters</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<style>
  .color-text-chip {
    display: inline-block;
    padding: 3px 10px;
    border: 1.5px solid #ccc;
    border-radius: 4px;
    font-size: 12px;
    cursor: pointer;
    margin: 2px;
    background: #fff;
    white-space: nowrap;
  }
  .color-text-chip.selected, .color-text-chip:hover {
    border-color: #111;
    background: #111;
    color: #fff;
  }
  .size-chip-btn {
    display: inline-block;
    padding: 5px 12px;
    border: 1.5px solid #ccc;
    border-radius: 4px;
    font-size: 12px;
    cursor: pointer;
    margin: 2px;
    background: #fff;
  }
  .size-chip-btn.selected, .size-chip-btn:hover {
    border-color: #111;
    background: #111;
    color: #fff;
  }
  .var-tag-color, .var-tag-size {
    display: inline-block;
    font-size: 10px;
    padding: 1px 5px;
    border-radius: 3px;
    margin: 1px;
    border: 1px solid #ddd;
    background: #f8f8f8;
    color: #444;
  }
  .var-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 2px;
    list-style: none;
    padding: 0;
    margin: 0;
  }
</style>
<script>
  // modal removed — products now navigate to detail page
  if (false) { // stub to prevent reference errors
  modal_stub_addEventListener("show.bs.modal", function(e) {
    var c = e.relatedTarget;
    if (!c) return;

    var setEl = function(id, val) {
      var el = document.getElementById(id);
      if (el) el.innerText = val || "";
    };
    setEl("modalTitle",        c.dataset.title);
    setEl("brandName",         c.dataset.brand);
    setEl("skuId",             c.dataset.sku);
    setEl("fabric",            c.dataset.fabric);
    setEl("fabricCategory",    c.dataset.fabricCategory);
    setEl("fabricType",        c.dataset.fabricType);
    setEl("category",          c.dataset.category);
    setEl("subcategory",       c.dataset.subcategory);
    setEl("composition",       c.dataset.composition);
    setEl("modalMrp",          c.dataset.mrp   ? "₹" + c.dataset.mrp   : "");
    setEl("modalSale",         c.dataset.price ? "₹" + c.dataset.price : "");
    setEl("productDescription", c.dataset.desc);

    currentProductId  = c.dataset.id    || 0;
    currentProductWsp = c.dataset.price  || 0;
    currentProductMrp = c.dataset.mrp    || 0;
    mainImage.src = c.dataset.images || "";
    galleryThumbs.innerHTML = "";
    selectedColor = "";
    selectedSize = "";
    if (sizeError) sizeError.style.display = "none";

    var variations = [];
    try { variations = JSON.parse(c.dataset.variations || "[]"); } catch(ex) {}

    renderVariations(variations, c.dataset.colors || "", c.dataset.sizes || "");
  });

  function renderVariations(variations, fallbackColors, fallbackSizes) {
    colorThumbs.innerHTML = "";
    sizeContainer.innerHTML = "";

    if (variations.length > 0) {
      variations.forEach(function(v, idx) {
        var chip = document.createElement("button");
        chip.type = "button";
        chip.className = "color-text-chip" + (idx === 0 ? " selected" : "");
        chip.innerText = v.color || "";
        (function(variation, btn) {
          btn.onclick = function() {
            document.querySelectorAll(".color-text-chip").forEach(function(c) { c.classList.remove("selected"); });
            btn.classList.add("selected");
            colorName.innerText = variation.color;
            selectedColor = variation.color;
            selectedSize = "";
            renderSizesFromStr(variation.sizes || "");
          };
        })(v, chip);
        colorThumbs.appendChild(chip);
        if (idx === 0) {
          colorName.innerText = v.color;
          selectedColor = v.color;
          renderSizesFromStr(v.sizes || "");
        }
      });
    } else {
      colorName.innerText = fallbackColors || "";
      if (fallbackColors) {
        var span = document.createElement("span");
        span.className = "color-text-chip selected";
        span.innerText = fallbackColors;
        colorThumbs.appendChild(span);
        selectedColor = fallbackColors;
      }
      if (fallbackSizes) renderSizesFromStr(fallbackSizes);
    }
  }

  function renderSizesFromStr(sizesStr) {
    sizeContainer.innerHTML = "";
    if (!sizesStr) return;
    var sizes = sizesStr.split(",").map(function(s) { return s.trim(); }).filter(Boolean);
    sizes.forEach(function(s) {
      var btn = document.createElement("button");
      btn.type = "button";
      btn.className = "size-chip-btn";
      btn.innerText = s;
      btn.onclick = function() {
        document.querySelectorAll(".size-chip-btn").forEach(function(b) { b.classList.remove("selected"); });
        btn.classList.add("selected");
        selectedSize = s;
        if (sizeError) sizeError.style.display = "none";
      };
      sizeContainer.appendChild(btn);
    });
  }

  // stub to satisfy old references
  function renderSizes() {}

  if (addToCart) {
    addToCart.onclick = function() {
      if (!selectedSize) {
        if (sizeError) sizeError.style.display = "block";
        return;
      }
      if (typeof variable !== "undefined" && variable.manageShoppingCartUrl) {
        jQuery.ajax({
          type: "POST",
          url: variable.manageShoppingCartUrl,
          dataType: "text",
          data: { article_id: currentProductId, action: "add", wsp: currentProductWsp, mrp: currentProductMrp }
        }).done(function(data) {
          try { var r = JSON.parse(data); if (r && r.login_required) { window.location.href = '<?= base_url("login") ?>'; return; } } catch(e) {}
          document.dispatchEvent(new Event('cartItemAdded'));
          var closeBtn = document.querySelector("#productModal .btn-close");
          if (closeBtn) closeBtn.click();
          if (typeof ShowNotificator === "function") {
            ShowNotificator("alert-info", typeof action_success_msg !== "undefined" ? action_success_msg : "Added to cart!");
          }
        }).fail(function() {
          if (typeof ShowNotificator === "function") ShowNotificator("alert-danger", "Error adding to cart.");
        });
      } else {
        alert("Added to cart\nColor: " + selectedColor + "\nSize: " + selectedSize);
      }
    };
  }
  } // end stub
</script>

<?php
// footer is loaded by the CI render() method — removed stray include
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />

<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
  window.jsPDF = window.jspdf.jsPDF;
</script>

<script>
  // Shopping Cart Manager
  $(document).on('click', 'a.add-to-cart_new', function(e) {
    e.preventDefault();

    var reload = false;
    var action = $(this).data('action');
    var article_id = $(this).data('id');
    var goto_site = $(this).data('goto');
    var mrp = $(this).data('mrp') || 0;
    var wsp = $(this).data('price') || 0;
    $.ajax({
      type: "POST",
      url: variable.manageShoppingCartUrl,
      dataType: 'text',
      data: {
        article_id: article_id,
        action: action,
        wsp: wsp,
        mrp: mrp
      }
    }).done(function(data) {
      try { var r = JSON.parse(data); if (r && r.login_required) { window.location.href = '<?= base_url("login") ?>'; return; } } catch(e) {}

      if (reload == true) {
        location.reload(false);
        return;
      } else if (typeof reload == 'string' && reload) {
        location.href = reload;
        return;
      }

      document.dispatchEvent(new Event('cartItemAdded'));
      ShowNotificator('alert-info', action_success_msg);
    }).fail(function(err) {
      console.error('AJAX Error:', err);
      ShowNotificator('alert-danger', action_error_msg);
    }).always(function() {
      if (action == 'add') {
        $('.add-to-cart a[data-id="' + article_id + '"] span').show();
        $('.add-to-cart a[data-id="' + article_id + '"] img').hide();
      }
    });
  });

  // Call: onclick="divToPdf('product-cards','catalog.pdf')"
  async function divToPdf(divId, filename = 'catalog.pdf') {
    const root = document.getElementById(divId);
    if (!root) return alert('PDF failed: section not found.');

    const JsPDFCtor =
      (window.jspdf && window.jspdf.jsPDF) ? window.jspdf.jsPDF :
      (window.jsPDF ? window.jsPDF : null);

    if (!JsPDFCtor) return alert('PDF failed: jsPDF not loaded.');
    if (typeof html2canvas === 'undefined') return alert('PDF failed: html2canvas not loaded.');

    const clean = (s) => String(s || '').replace(/\s+/g, ' ').trim();
    const txt = (n) => (n ? clean(n.textContent) : '');
    const attr = (n, k) => (n ? clean(n.getAttribute(k)) : '');
    const escapeHtml = (s) => String(s || '').replace(/[&<>"']/g, m => ({
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    } [m]));
    const pick = (...vals) => vals.map(clean).find(v => v) || '';
    const extractNumber = (line) => {
      const m = String(line || '').match(/([0-9]+(?:\.[0-9]+)?)/);
      return m ? m[1] : '';
    };

    alert('Preparing PDF…');

    // ✅ Collect products from DOM (no checkbox)
    const rows = root.querySelectorAll('.tb-product-item-inner');
    if (!rows.length) return alert('No products found.');

    const products = [];
    rows.forEach(row => {
      const card = row.querySelector('.product-card');
      const imgEl =
        row.querySelector('img.img_products') ||
        row.querySelector('.product-img-wrapper img') ||
        row.querySelector('img');

      const begLinks = row.querySelectorAll('.tb-content .tb-beg a');
      const title = pick(txt(begLinks[0]), attr(card, 'data-title'));
      const size = pick(txt(begLinks[1]), attr(card, 'data-sizes'));

      const amountTexts = Array.from(row.querySelectorAll('.tb-content .tb-product-price .amount'))
        .map(a => txt(a))
        .filter(Boolean);

      const colorLine = amountTexts.find(t => !/mrp|wsp/i.test(t)) || '';
      const mrpLine = amountTexts.find(t => /mrp/i.test(t)) || '';
      const wspLine = amountTexts.find(t => /wsp/i.test(t)) || '';

      const color = pick(colorLine);
      const mrp = pick(extractNumber(mrpLine), attr(card, 'data-mrp'));
      const wsp = pick(extractNumber(wspLine), attr(card, 'data-price'));

      const brand =
        pick(txt(row.querySelector('.brand-badge-animated')), attr(card, 'data-brand'));

      const category = pick(attr(card, 'data-category'));
      const sku = pick(attr(card, 'data-sku'));
      const desc = pick(attr(card, 'data-desc'));

      products.push({
        image: imgEl ? imgEl.src : '',
        title,
        size,
        color,
        brand,
        category,
        sku,
        mrp,
        wsp,
        desc
      });
    });

    // A4 + 6 per page
    const pdf = new JsPDFCtor('p', 'mm', 'a4');
    const PAGE_W = 210,
      PAGE_H = 297;

    const MARGIN = 12,
      GAP = 6,
      FOOTER_H = 8,
      PER_PAGE = 6;

    const MM_TO_PX = 3.7795275591;
    const PAGE_W_PX = Math.round(PAGE_W * MM_TO_PX);
    const PAGE_H_PX = Math.round(PAGE_H * MM_TO_PX);
    const marginPx = Math.round(MARGIN * MM_TO_PX);
    const gapPx = Math.round(GAP * MM_TO_PX);
    const footerPx = Math.round(FOOTER_H * MM_TO_PX);

    const waitImages = async (node) => {
      const imgs = Array.from(node.querySelectorAll('img'));
      await Promise.all(imgs.map(img => {
        img.crossOrigin = 'anonymous';
        if (img.complete) return Promise.resolve();
        return new Promise(res => {
          img.onload = img.onerror = res;
        });
      }));
    };

    function buildPage(pageItems, pageNo, totalPages) {
      const page = document.createElement('div');
      page.style.width = PAGE_W_PX + 'px';
      page.style.height = PAGE_H_PX + 'px';
      page.style.background = '#fff';
      page.style.position = 'fixed';
      page.style.left = '-10000px';
      page.style.top = '0';
      page.style.boxSizing = 'border-box';
      page.style.fontFamily = 'Arial, sans-serif';

      const content = document.createElement('div');
      content.style.position = 'absolute';
      content.style.left = marginPx + 'px';
      content.style.top = marginPx + 'px';
      content.style.right = marginPx + 'px';
      content.style.bottom = (marginPx + footerPx) + 'px';
      content.style.display = 'grid';
      content.style.gridTemplateColumns = '1fr 1fr';
      content.style.gridTemplateRows = '1fr 1fr 1fr';
      content.style.gap = gapPx + 'px';

      pageItems.forEach(p => {
        const card = document.createElement('div');
        card.style.border = '1px solid #e6e6e6';
        card.style.borderRadius = '14px';
        card.style.overflow = 'hidden';
        card.style.background = '#fff';
        card.style.boxShadow = '0 2px 10px rgba(0,0,0,0.06)';
        card.style.display = 'flex';
        card.style.flexDirection = 'column';

        // Header: Brand + Category + Color
        const head = document.createElement('div');
        head.style.padding = '10px 12px 8px 12px';
        head.style.display = 'flex';
        head.style.justifyContent = 'space-between';
        head.style.alignItems = 'flex-start';
        head.style.gap = '10px';

        const left = document.createElement('div');
        left.innerHTML = `
        <div style="font-size:11px;font-weight:800;color:#111;">${escapeHtml(p.brand || '-')}</div>
        <div style="font-size:10px;color:#666;margin-top:2px;">
          Category: ${escapeHtml(p.category || '-')}
        </div>
        <div style="font-size:10px;color:#666;margin-top:2px;">
          Color: ${escapeHtml(p.color || '-')}
        </div>
      `;

        const right = document.createElement('div');
        right.style.textAlign = 'right';
        right.innerHTML = `
        <div style="font-size:10px;color:#777;">MRP</div>
        <div style="font-size:12px;font-weight:700;color:#111;">${escapeHtml(p.mrp || '-')} /-</div>
        <div style="font-size:10px;color:#777;margin-top:4px;">WSP</div>
        <div style="font-size:13px;font-weight:800;color:#111;">${escapeHtml(p.wsp || '-')} /-</div>
      `;

        head.appendChild(left);
        head.appendChild(right);

        // Image box
        const imgWrap = document.createElement('div');
        imgWrap.style.margin = '0 12px';
        imgWrap.style.border = '1px solid #f0f0f0';
        imgWrap.style.borderRadius = '12px';
        imgWrap.style.height = '170px';
        imgWrap.style.display = 'flex';
        imgWrap.style.alignItems = 'center';
        imgWrap.style.justifyContent = 'center';

        const img = document.createElement('img');
        img.crossOrigin = 'anonymous';
        img.src = p.image;
        img.style.maxWidth = '100%';
        img.style.maxHeight = '100%';
        img.style.objectFit = 'contain';
        imgWrap.appendChild(img);

        // Title + size + SKU
        const info = document.createElement('div');
        info.style.padding = '10px 12px 12px 12px';
        info.innerHTML = `
        <div style="font-size:13px;font-weight:900;color:#111;line-height:1.2;margin-bottom:6px;">
          ${escapeHtml(p.title || '-')}
        </div>
        <div style="font-size:11px;color:#444;margin-bottom:4px;">
          Size: ${escapeHtml(p.size || '-')} &nbsp; | &nbsp; SKU: ${escapeHtml(p.sku || '-')}
        </div>
        <div style="font-size:10px;color:#666;line-height:1.25;">
          ${escapeHtml((p.desc || '').length > 85 ? (p.desc.slice(0, 84) + '…') : (p.desc || ''))}
        </div>
      `;

        card.appendChild(head);
        card.appendChild(imgWrap);
        card.appendChild(info);
        content.appendChild(card);
      });

      const footer = document.createElement('div');
      footer.style.position = 'absolute';
      footer.style.left = marginPx + 'px';
      footer.style.right = marginPx + 'px';
      footer.style.bottom = marginPx + 'px';
      footer.style.height = footerPx + 'px';
      footer.style.display = 'flex';
      footer.style.alignItems = 'center';
      footer.style.justifyContent = 'space-between';
      footer.style.fontSize = '11px';
      footer.style.color = '#666';
      footer.innerHTML = `<span>Catalog Export</span><span>Page ${pageNo} of ${totalPages}</span>`;

      page.appendChild(content);
      page.appendChild(footer);
      document.body.appendChild(page);
      return page;
    }

    try {
      const totalPages = Math.ceil(products.length / PER_PAGE);

      for (let i = 0; i < products.length; i += PER_PAGE) {
        const pageNo = Math.floor(i / PER_PAGE) + 1;
        const pageItems = products.slice(i, i + PER_PAGE);

        const pageEl = buildPage(pageItems, pageNo, totalPages);
        await waitImages(pageEl);

        const canvas = await html2canvas(pageEl, {
          scale: 2,
          useCORS: true,
          allowTaint: false,
          backgroundColor: '#ffffff'
        });

        const imgData = canvas.toDataURL('image/jpeg', 0.92);
        if (pageNo > 1) pdf.addPage();
        pdf.addImage(imgData, 'JPEG', 0, 0, PAGE_W, PAGE_H);

        document.body.removeChild(pageEl);
      }

      pdf.save(filename);
      alert('Download started successfully.');
    } catch (err) {
      console.error(err);
      alert('Download failed. Check console.');
    }
  }


  $(function() {
    $('.product-card').on('click', function() {
      var price = $(this).attr('data-price');
      var data_id = $(this).attr('data-id');
      $('#estSubtotal').text('INR. ' + price);
      var total = parseFloat(price);
      var gst = total * 0.05; // 5% GST
      var finalAmount = total + gst;
      $('#estGST').text('INR. ' + Math.round(gst.toFixed(2)));
      $('#grandTotal').text('INR. ' + Math.round(finalAmount.toFixed(2)));
      // Set data-id attribute of a button with id "#myButton"
      $('#btnAddToCart').attr('data-id', data_id);
      var title = $(this).attr('data-title');
      var src = $(this).attr('data-images');
      var wsp = $(this).attr('data-price');
      var mrp = $(this).attr('data-mrp');
      var msp = $(this).attr('data-msp');
      var clr = $(this).attr('data-colors');
      var size = $(this).attr('data-sizes');
      var desc = $(this).attr('data-desc');
      var fabric = $(this).attr('data-fabric');
      $('#mainImage').attr('src', src);
      $('#modalTitle').text(title);
      $('#modalMrp').text(mrp);
      $('#modalSale').text(wsp);
      $('#description').text(desc);
      $('#colorThumbs').text(clr);
      $('#fabric').text(fabric);
      $('#sizeOptions').text(size);

    });

    $(".order").change(function() {
      var order_to = $(this).data('order-to');
      $('#fs_' + order_to).val($(this).val());
      applyFilters();
    });

    // Filters Technique

    $('.go-category').click(function() {
      var categoryString = $('.go-category:checked').map(function() {
        return $(this).val();
      }).get().join(',');
      $('#fs_category').val(categoryString);
      applyFilters();
    });

    $('.go-season').click(function() {
      var seasonString = $('.go-season:checked').map(function() {
        return $(this).val();
      }).get().join(',');
      $('#fs_season').val(seasonString.trim());
      applyFilters();
    });

    $('.go-gender-cb').click(function() {
      // Only one gender at a time (radio-style)
      var gen = $(this).val();
      if ($(this).is(':checked')) {
        $('.go-gender-cb').not(this).prop('checked', false);
        $('#fs_gender').val(gen);
      } else {
        $('#fs_gender').val('');
      }
      applyFilters();
    });
    $('.go-filter').click(function() {
      // go_filter (new/offer) maps to order_new for now
      applyFilters();
    });
    $('.go-brand').click(function() {
      $('#fs_desc').val($(this).data('brand-desc'));
      $('#fs_brand').val($(this).data('brand'));
      applyFilters();
    });
    $('.go-color').click(function() {
      $('#fs_color').val($(this).data('brand-color'));
      applyFilters();
    });
    $('.go-size').click(function() {
      var brand_siz = $('.go-size:checked').map(function() {
        return $(this).val();
      }).get().join(',');
      $('#fs_size').val(brand_siz);
      applyFilters();
    });
    $('.brand').click(function() {
      $('#fs_brand_id').val($(this).data('brand-id'));
      applyFilters();
    });
  });

  $(document).on('click', '#clear-filters-btn', function() {
    $('#filter-state input').val('');
    $('.go-category, .go-season, .go-size, .go-gender-cb').prop('checked', false);
    applyFilters();
  });

  function applyFilters() {
    var data = {
      category:        $('#fs_category').val(),
      season:          $('#fs_season').val(),
      gender:          $('#fs_gender').val(),
      search_in_title: $('#fs_title').val(),
      search_in_brand: $('#fs_brand').val(),
      search_in_desc:  $('#fs_desc').val(),
      search_in_color: $('#fs_color').val(),
      search_in_size:  $('#fs_size').val(),
      order_new:       $('#fs_order_new').val(),
      order_price:     $('#fs_order_price').val(),
      price_from:      $('#fs_price_from').val(),
      price_to:        $('#fs_price_to').val(),
      brand_id:        $('#fs_brand_id').val()
    };
    var $catalog = $('#catalog');
    $catalog.css('opacity', '0.5');
    $.ajax({
      url: '<?= base_url("ajax_cart_filter") ?>',
      type: 'POST',
      data: data,
      dataType: 'json',
      success: function(res) {
        $catalog.css('opacity', '1');
        if (res && res.html !== undefined) {
          $catalog.html(res.html);
          if (res.count !== undefined) {
            $('#filter-result-count').text(res.count + ' product(s) found');
          }
          // Rebind wishlist click handlers on new cards
          bindWishlistHandlers();
        }
      },
      error: function() {
        $catalog.css('opacity', '1');
      }
    });
  }

  function bindWishlistHandlers() {
    // Use delegated event on #catalog so it works after AJAX reload
    $('#catalog').off('click', '.wishlist-btn').on('click', '.wishlist-btn', function(e) {
      e.preventDefault();
      e.stopPropagation();
      var $btn = $(this);
      var productId = $btn.attr('data-product-id');
      $.ajax({
        url: '<?= base_url("wishlist/toggle") ?>',
        type: 'POST',
        data: { product_id: productId },
        dataType: 'json',
        success: function(response) {
          if (response.status === 'added') {
            $btn.removeClass('bi-heart').addClass('bi-heart-fill text-danger');
            if (typeof alertify !== 'undefined') {
              alertify.set('notifier', { position: 'top-center' });
              alertify.success('Product Added to wishlist');
            }
          } else if (response.status === 'removed') {
            $btn.removeClass('bi-heart-fill text-danger').addClass('bi-heart');
            if (typeof alertify !== 'undefined') alertify.success('Removed from wishlist!');
          }
          $('#wishlistCount').text(response.count);
        },
        error: function() { alert('Error occurred. Please try again.'); }
      });
    });
  }

  $(document).ready(function() {
    bindWishlistHandlers();
    // Check initial wishlist status on page load
    checkWishlistStatus();
  });

  function checkWishlistStatus() {
    $('.wishlist-btn').each(function() {
      var productId = $(this).data('product-id');
      $.ajax({
        url: '<?= base_url("wishlist/check/") ?>' + productId,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response.in_wishlist) {
            $(`.wishlist-btn[data-product-id="${productId}"]`)
              .find('.wishlist-icon').removeClass('far fa-heart').addClass('fas fa-heart')
              .end().find('.wishlist-text').text('Remove')
              .end().addClass('active');
          }
        }
      });
    });
  }

  function showNotification(message) {
    $('<div class="notification">' + message + '</div>')
      .hide().appendTo('body').fadeIn(300).delay(2000).fadeOut(300);
  }
</script>