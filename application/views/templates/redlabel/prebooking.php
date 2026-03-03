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
                    <div class="shop-one">
                        <p class="filter-title">Gender</p>
                        <ul class="product_categories filter_height" id="fill">
                            <li class="go-gender" data-gender="girls">
                                <label class="filter-radio">
                                    <input type="checkbox" name="gender_filter">
                                    <span class="check-box"></span>
                                    <span class="check-label">Girls</span>
                                    <span class="count">(24)</span>
                                </label>
                            </li>
                            <li class="go-gender" data-gender="boys">
                                <label class="filter-radio">
                                    <input type="checkbox" name="gender_filter">
                                    <span class="check-box"></span>
                                    <span class="check-label">Boys</span>
                                    <span class="count">(18)</span>
                                </label>
                            </li>
                            <li class="go-gender" data-gender="infant">
                                <label class="filter-radio">
                                    <input type="checkbox" name="gender_filter">
                                    <span class="check-box"></span>
                                    <span class="check-label">Infant</span>
                                    <span class="count">(12)</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <?php
                    $season  = !empty($_GET['season']) ? $_GET['season'] : '';
                    if (strpos($season, ',') !== false) {
                        $seasons_array = explode(',', $season);
                        $checked = ($seasons_array['0'] == 'summer') ? 'checked' : '';
                        $checked1 = ($seasons_array['1'] == 'winter') ? 'checked' : '';
                    } else {
                        $checked = ($season == 'summer') ? 'checked' : '';
                        $checked1 = ($season == 'winter') ? 'checked' : '';
                    }
                    ?>
                    <div class="shop-one">
                        <p class="filter-title">Season</p>
                        <ul class="product_categories filter_height" id="fill">
                            <li class="go-season1" data-season="summer">
                                <label class="filter-radio">
                                    <input type="checkbox" class="go-season" <?= $checked; ?> name="season_filter" value="summer">
                                    <span class="check-box"></span>
                                    <span class="check-label">Summer</span>
                                    <span class="count">(20)</span>
                                </label>
                            </li>
                            <li class="go-season1" data-season="winter">
                                <label class="filter-radio">
                                    <input type="checkbox" class="go-season" <?= $checked1; ?> name="season_filter" value="winter">
                                    <span class="check-box"></span>
                                    <span class="check-label">Winter</span>
                                    <span class="count">(8)</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="shop-one">
                        <p class="filter-title">Categories</p>
                        <?php
                        if (!empty($_GET['category'])) {
                            $cat = ($_GET['category']) ? $_GET['category'] : '';
                            if ($cat == 't-shirt') {
                                $chk = 'checked';
                            } elseif ($cat == 'dungree-set') {
                                $chk1 = 'checked';
                            } elseif ($cat == '3pcs-baba-suit') {
                                $chk4 = 'checked';
                            } elseif ($cat == 'bottom') {
                                $chk5 = 'checked';
                            } elseif ($cat == 'shirt') {
                                $chk6 = 'checked';
                            }
                        }
                        $categories = !empty($_GET['category']) ? $_GET['category'] : '';
                        $categories = explode(',', $categories);
                        if (is_array($categories)) {
                            $checkedbox1 = (in_array('dungree-set', $categories)) ? 'checked' : '';
                            $checkedbox_2 = (in_array('t-shirt', $categories)) ? 'checked' : '';
                            $checkedbox_3 = (in_array('bottom', $categories)) ? 'checked' : '';
                            $checkedbox_4 = (in_array('3pcs-baba-suit', $categories)) ? 'checked' : '';
                            $checkedbox_5 = (in_array('shirt', $categories)) ? 'checked' : '';
                        } else {
                            $checkedbox1 = ($categories == 'dungree-set') ? 'checked' : '';
                            $checkedbox_2 = ($categories == 't-shirt') ? 'checked' : '';
                            $checkedbox_3 = ($categories == 'bottom') ? 'checked' : '';
                            $checkedbox_4 = ($categories == '3pcs-baba-suit') ? 'checked' : '';
                            $checkedbox_5 = ($categories == 'shirt') ? 'checked' : '';
                        }
                        ?>
                        <ul class="product_categories filter_height">
                            <li class="go-category1" data-category="dungree-set">
                                <label class="filter-radio">
                                    <input type="checkbox" <?php echo $checkedbox1; ?> value="dungree-set" class="go-category" name="category_filter">
                                    <span class="check-box"></span>
                                    <span class="check-label">Dungree Set</span>
                                </label>
                            </li>
                            <li class="go-category" data-category="t-shirt">
                                <label class="filter-radio">
                                    <input type="checkbox" <?php echo $checkedbox_2; ?> value="t-shirt" class="go-category" name="category_filter">
                                    <span class="check-box"></span>
                                    <span class="check-label">T-Shirt</span>
                                </label>
                            </li>
                            <li class="go-category" data-category="bottom">
                                <label class="filter-radio">
                                    <input type="checkbox" <?php echo $checkedbox_3; ?> value="bottom" class="go-category" name="category_filter">
                                    <span class="check-box"></span>
                                    <span class="check-label">Bottom</span>
                                </label>
                            </li>
                            <li class="go-category" data-category="3pcs-baba-suit">
                                <label class="filter-radio">
                                    <input type="checkbox" <?php echo $checkedbox_4; ?> value="3pcs-baba-suit" class="go-category" name="category_filter">
                                    <span class="check-box"></span>
                                    <span class="check-label">3 Pcs Baba Suit</span>
                                </label>
                            </li>
                            <li class="go-category" data-category="shirt">
                                <label class="filter-radio">
                                    <input type="checkbox" <?= $checkedbox_5; ?> value="shirt" class="go-category" name="category_filter">
                                    <span class="check-box"></span>
                                    <span class="check-label">Shirt</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <?php
                    $var = !empty($_GET['search_in_size']) ? $_GET['search_in_size'] : '';
                    if ($var == '2Y*5Y') {
                        $range1 = 'checked';
                    } elseif ($var == '06*24M') {
                        $range2 = 'checked';
                    } elseif ($var == '20*30-2*10') {
                        $range4 = 'checked';
                    } elseif ($var = '2Y*8Y') {
                        // $range5='checked';
                    } elseif ($var = '6-9*36') {
                        $range6 = 'checked';
                    } elseif ($var = '6Y*16Y') {
                        $range7 = 'checked';
                    } elseif ($var = '8-9*16') {
                        $range8 = 'checked';
                    } else {
                        $range1 = '';
                    }
                    ?>
                    <?php
                    $search_in_size = !empty($_GET['search_in_size']) ? $_GET['search_in_size'] : '';
                    $search_in_size = explode(',', $search_in_size);
                    if (is_array($categories)) {
                        $range = (in_array('06*24M', $search_in_size)) ? 'checked' : '';
                        $range1 = (in_array('20*30-2*10', $search_in_size)) ? 'checked' : '';
                        $range2 = (in_array('2Y*5Y', $search_in_size)) ? 'checked' : '';
                        $range3 = (in_array('2Y*8Y', $search_in_size)) ? 'checked' : '';
                        $range4 = (in_array('6-9*36', $search_in_size)) ? 'checked' : '';
                        $range5 = (in_array('6Y*16Y', $search_in_size)) ? 'checked' : '';
                        $range8 = (in_array('8-9*16', $search_in_size)) ? 'checked' : '';
                    }
                    ?>
                    <div class="shop-one">
                        <p class="filter-title">Size</p>
                        <ul class="product_categories filter_height" id="fill">
                            <li class="go-size/" data-brand-size="06*24M">
                                <label class="filter-radio">
                                    <input type="checkbox" <?php echo $range; ?> class="go-size" value="06*24M" name="size_filter">
                                    <span class="check-box"></span>
                                    <span class="check-label">06×24 M</span>
                                </label>
                            </li>
                            <li class="go-size" data-brand-size="20*30-2*10">
                                <label class="filter-radio">
                                    <input type="checkbox" <?php echo $range1; ?> class="go-size" value="20*30-2*10" name="size_filter">
                                    <span class="check-box"></span>
                                    <span class="check-label">20×30–2×10</span>
                                </label>
                            </li>
                            <li class="go-size1" data-brand-size="2Y*5Y">
                                <label class="filter-radio">
                                    <input type="checkbox" <?php echo $range2; ?> class="go-size" value="2Y*5Y" name="size_filter">
                                    <span class="check-box"></span>
                                    <span class="check-label">2Y–5Y</span>
                                </label>
                            </li>
                            <li class="go-size1" data-brand-size="2Y*8Y">
                                <label class="filter-radio">
                                    <input type="checkbox" <?php echo $range3; ?> class="go-size" value="2Y*8Y" name="size_filter">
                                    <span class="check-box"></span>
                                    <span class="check-label">2Y–8Y</span>
                                </label>
                            </li>
                            <li class="go-size1" data-brand-size="6-9*36">
                                <label class="filter-radio">
                                    <input type="checkbox" <?= $range4; ?> class="go-size" value="6-9*36" name="size_filter">
                                    <span class="check-box"></span>
                                    <span class="check-label">6–9×36 M</span>
                                </label>
                            </li>
                            <li class="go-size1" data-brand-size="6Y*16Y">
                                <label class="filter-radio">
                                    <input type="checkbox" <?= $range5; ?> class="go-size" value="6Y*16Y" name="size_filter">
                                    <span class="check-box"></span>
                                    <span class="check-label">6Y–16Y</span>
                                </label>
                            </li>
                            <li class="go-size1" data-brand-size="8-9*16">
                                <label class="filter-radio">
                                    <input type="checkbox" <?= $range8; ?> class="go-size" value="8-9*16" name="size_filter">
                                    <span class="check-box"></span>
                                    <span class="check-label">8-9*16</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="shop-one">
                        <p class="filter-title">Filter By</p>
                        <ul class="product_categories filter_height" id="fill">
                            <li class="go-filter" data-filter="new">
                                <label class="filter-radio">
                                    <input type="checkbox" name="filter_by">
                                    <span class="check-box"></span>
                                    <span class="check-label">New Arrival</span>
                                    <span class="count">(15)</span>
                                </label>
                            </li>
                            <li class="go-filter" data-filter="offer">
                                <label class="filter-radio">
                                    <input type="checkbox" name="filter_by">
                                    <span class="check-box"></span>
                                    <span class="check-label">Offer</span>
                                    <span class="count">(8)</span>
                                </label>
                            </li>
                        </ul>
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
                                                <option value="offer_desc" <?= $sort === 'offer_desc' ? 'selected' : '' ?>>
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
                                        if (isset($products)) {
                                            foreach ($products as $val) {  ?>
                                                <div class="col-lg-3 col-md-4 col-6">
                                                    <div class="tb-product-item-inner">
                                                        <div class="card product-card" data-bs-toggle="modal" data-bs-target="#productModal" tabindex="0" onerror="this.onerror=null; this.src='<?php echo base_url('/attachments/shop_images/spark_logo-06.jpg'); ?>';"
                                                            data-title="<?php echo $val['title']; ?>" data-brand="<?php echo $val['brand']; ?>" data-sku=""
                                                            data-price="<?php echo $val['wsp']; ?>" data-mrp="<?php echo $val['msp']; ?>"
                                                            data-desc="<?php echo $val['description']; ?>"
                                                            data-fabric="<?php echo $val['fabric']; ?>"
                                                            data-id="<?php echo $val['id']; ?>" data-sizes="<?php echo $val['size_range']; ?>" data-images='<?php echo base_url(); ?>attachments/shop_images/<?php echo $val['image']; ?>'>
                                                            <?php
                                                            $folderPath = $_SERVER['DOCUMENT_ROOT'] . '/attachments/shop_images/';
                                                            $imageName = $val['image'];
                                                            $imagePath = $folderPath . trim($imageName);
                                                            if (is_file($imagePath)) {
                                                            ?>
                                                                <div class="product-img-wrapper" >
                                                                    <img alt="product"
                                                                    data-title="<?= $val['title']; ?>"
                                                                        src="<?php echo base_url(); ?>attachments/shop_images/<?php echo $val['image']; ?>"
                                                                        class="w-100 img_products"
                                                                        onload="this.parentElement.classList.remove('skeleton')">
                                                                    <span class="brand-badge-animated">
                                                                        <?php echo htmlspecialchars($val['brand']); ?>
                                                                    </span>
                                                                </div>
                                                            <?php } else { ?>
                                                                <img alt="product" src="<?php echo base_url(); ?>attachments/shop_images/<?php echo $val['image']; ?>" onerror="this.onerror=null; this.src='<?php echo base_url('/attachments/shop_images/spark_logo-06.jpg'); ?>';" style="object-fit: scale-down!important;" class="w-100 img_products"
                                                                    onload="this.parentElement.classList.remove('skeleton')">
                                                            <?php } ?>
                                                        </div>
                                                        <div><a href="#"><i data-product-id="<?php echo $val['id']; ?>" class="bi bi-heart wishlist-btn"></i></a></div>
                                                        <ul class="list-unstyled tb-content">
                                                            <li><a href="#"><?php echo $val['title']; ?></a></li>
                                                            <li class="small"><a href="#" class="text-muted"><?php echo $val['size_range']; ?></a></li>
                                                            <li><?php echo $val['color']; ?></li>
                                                            <li>
                                                                <ol class="price-list">
                                                                    <li>MRP <?php echo $val['msp']; ?> /-</li>
                                                                    <li>WSP <strong><?php echo $val['wsp']; ?></strong> /-</li>
                                                                </ol>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);" data-price="<?php echo $val['wsp']; ?>" data-mrp="<?php echo $val['msp']; ?>" class="btn btn-dark w-100 rounded-pill mt-2 add-to-cart_new" data-action="add" data-id="<?php echo $val['id']; ?>">Pre-Book Now</a>
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

<div class="shopprocutpopup">
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content p-3">
                <button class="btn-close" data-bs-dismiss="modal"></button>
                <div class="row">
                    <div class="col-md-6 text-center">
                        <img id="mainImage" class="main-img" src="" alt="Product image">
                        <div class="d-flex justify-content-center gap-2 mt-3" id="galleryThumbs"></div>
                    </div>
                    <div class="col-md-6 descriptioncontainer" id="descriptioncontainer">
                        <h4 id="modalTitle" class="fw-bold mt-md-0 mt-3"></h4>
                        <p class="mb-1 text-muted">Brand: <span id="brandName" class="text-dark fw-semibold"></span></p>
                        <div class="mb-3">
                            MRP: <span class="text-muted" id="modalMrp"></span>
                            <strong class="ms-2">WSP: </strong><span class="fs-5 fw-bold" id="modalSale"></span>
                        </div>
                        <hr>
                        <div class="row g-2 mb-3">
                            <div class="col-6"><span class="detail-label">SKU:</span> <span class="detail-value"
                                    id="skuId"></span></div>
                            <div class="col-6"><span class="detail-label">Fabric Category:</span> <span
                                    class="detail-value" id="fabricCategory"></span></div>
                            <div class="col-6"><span class="detail-label">Category:</span> <span class="detail-value"
                                    id="category"></span></div>
                            <div class="col-6"><span class="detail-label">Fabric Type:</span> <span class="detail-value"
                                    id="fabricType"></span></div>
                            <div class="col-6"><span class="detail-label">Sub Category:</span> <span
                                    class="detail-value" id="subcategory"></span></div>
                            <div class="col-6"><span class="detail-label">Fabric:</span> <span class="detail-value"
                                    id="fabric"></span></div>
                            <div class="col-6"><span class="detail-label">Composition:</span> <span class="detail-value"
                                    id="composition"></span></div>
                        </div>
                        <p class="fw-semibold">Color: <span id="colorName"></span></p>
                        <div class="d-flex mb-2" id="colorThumbs1"></div>
                        <div class="size-error fw-semibold" id="sizeError" role="alert">PLEASE SELECT A SIZE</div>
                        <p class="fw-semibold mb-1">Size <small class="text-muted">(Tap to see age breakup)</small></p>
                        <div id="sizeContainer"></div>
                        <p class="detail-label mt-3 mb-1">Description</p>
                        <p class="detail-value" id="productDescription"></p>
                        <div class="alert alert-warning rounded-0 p-3">
                            ⚠️ This is a pre-booking product.
                        </div>
                        <button class="cart-btn btn btn-dark" id="addToCart" aria-label="Add product to cart">
                            Pre-Book Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="prebookConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 shadow text-center p-4">
                <div class="mx-auto mb-2"
                    style="width:52px;height:52px;border-radius:50%;
                  background:#111;color:#fff;
                  display:flex;align-items:center;justify-content:center;font-size:24px;">
                    ✓
                </div>
                <div class="fw-semibold">Pre-Booked!</div>
                <div class="text-muted small mb-3">Thank you for your pre-booking.<br> Your order has been successfully placed.</div>
                <button type="button" class="btn btn-dark btn-sm px-4" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById("productModal");
    const mainImage = document.getElementById("mainImage");
    const galleryThumbs = document.getElementById("galleryThumbs");
    const colorThumbs = document.getElementById("colorThumbs");
    const sizeContainer = document.getElementById("sizeContainer");
    const sizeError = document.getElementById("sizeError");
    const addToCart = document.getElementById("addToCart");
    const colorName = document.getElementById("colorName");

    let images = [],
        selectedColor = "",
        selectedSize = "",
        parentSizes = [];

    const betweenSizes = {
        "2Y*5Y": ["2-3", "3-4", "4-5"],
        "6Y*16Y": ["6-8", "8-12", "12-16"],
        "06*24M": ["0-6m", "6-12m", "12-24m"]
    };

    modal.addEventListener("shown.bs.modal", e => {
        const c = e.relatedTarget;

        modalTitle.innerText = c.dataset.title;
        brandName.innerText = c.dataset.brand;
        skuId.innerText = c.dataset.sku;
        category.innerText = c.dataset.category;
        subcategory.innerText = c.dataset.subcategory;
        fabricCategory.innerText = c.dataset.fabricCategory;
        fabricType.innerText = c.dataset.fabricType;
        fabric.innerText = c.dataset.fabric;
        composition.innerText = c.dataset.composition;

        modalMrp.innerText = "₹" + c.dataset.mrp;
        modalSale.innerText = "₹" + c.dataset.price;
        productDescription.innerText = c.dataset.desc;
        parentSizes = c.dataset.sizes ? c.dataset.sizes.split(",").map(s => s.trim()) : [];

        images = JSON.parse(c.dataset.images);
        selectedColor = images[0].color;
        selectedSize = "";
        sizeError.style.display = "none";

        renderColors();
        loadColor(selectedColor);
        renderSizes();
    });

    function renderColors() {
        colorThumbs.innerHTML = "";

        images.forEach(obj => {
            const d = document.createElement("div");
            d.className = "color-thumb" + (obj.color === selectedColor ? " selected" : "");
            d.innerHTML = `<img src="${obj.imgs[0]}" width="60" height="80">`;

            d.onmouseenter = () => colorName.innerText = obj.color;
            d.onmouseleave = () => colorName.innerText = selectedColor;

            d.onclick = () => {
                selectedColor = obj.color;
                selectedSize = "";
                sizeError.style.display = "none";
                renderColors();
                loadColor(selectedColor);
            };

            colorThumbs.appendChild(d);
        });

        colorName.innerText = selectedColor;
    }

    function loadColor(color) {
        const obj = images.find(i => i.color === color);
        const gallery = obj.imgs;

        mainImage.src = gallery[0];
        galleryThumbs.innerHTML = "";

        gallery.forEach((img, i) => {
            const t = document.createElement("img");
            t.src = img;
            t.className = "gallery-thumb" + (i === 0 ? " active" : "");

            t.onclick = () => {
                mainImage.src = img;
                document.querySelectorAll(".gallery-thumb").forEach(g => g.classList.remove("active"));
                t.classList.add("active");
            };

            galleryThumbs.appendChild(t);
        });

        colorName.innerText = selectedColor;
    }

    function renderSizes() {
        sizeContainer.innerHTML = "";

        parentSizes.forEach(size => {
            const wrap = document.createElement("div");
            wrap.style.display = "flex";
            wrap.style.flexDirection = "column";

            const box = document.createElement("div");
            box.className = "size-box";
            box.innerText = size;

            const sub = document.createElement("div");
            sub.className = "size-subinfo";

            (betweenSizes[size] || []).forEach(s => {
                const sp = document.createElement("span");
                sp.innerText = s;
                sub.appendChild(sp);
            });

            box.onclick = () => {
                document.querySelectorAll(".size-box").forEach(b => b.classList.remove("selected"));
                document.querySelectorAll(".size-subinfo").forEach(d => d.style.display = "none");

                box.classList.add("selected");
                sub.style.display = "block";
                selectedSize = size;
                sizeError.style.display = "none";
            };

            wrap.appendChild(box);
            wrap.appendChild(sub);
            sizeContainer.appendChild(wrap);
        });
    }

    addToCart.onclick = () => {
        if (!selectedSize) {
            sizeError.style.display = "block";
            return;
        }
        const productModalEl = document.getElementById("productModal");
        const productModal = bootstrap.Modal.getInstance(productModalEl);
        if (productModal) productModal.hide();
        const prebookModalEl = document.getElementById("prebookConfirmModal");
        const prebookModal = new bootstrap.Modal(prebookModalEl);
        prebookModal.show();
    };
</script>
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


            if (reload == true) {
                location.reload(false);
                return;
            } else if (typeof reload == 'string' && reload) {
                location.href = reload;
                return;
            }

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
        $(document).on('click', '.gallery-thumb', function() {
       // var imgSrc = $(this).find('img').attr('src');  
        var imgSrc = $(this).attr('src');  //alert(imgSrc) 
        
        $('#mainImage').attr('src',imgSrc);
        
            
            
        });
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
            $('#skuId').html('');
            $('#category').html('');

        });

        $(".order").change(function() {
            var order_type = $(this).val();
            var order_to = $(this).data('order-to');
            $('[name="' + order_to + '"]').val(order_type);
            submitForm();
        });

        // Filters Technique

        $('.go-category').click(function() {
            var categoryString = $('.go-category:checked').map(function() {
                return $(this).val();
            }).get().join(','); //alert(categoryString) 
            $('[name="category"]').val(categoryString);
            $('#search_submit').trigger('click');
        });

        $('.go-season').click(function() {
            var seasonString = $('.go-season:checked').map(function() {
                return $(this).val();
            }).get().join(',');
            $('[name="season"]').val(seasonString.trim());
            $('#search_submit').trigger('click');
        });

        $('.go-gender').click(function() {
            var gen = $(this).data('gender');
            $('[name="gender"]').val(gen);
            $('#search_submit').trigger('click');
        });
        $('.go-filter').click(function() {
            var go_filter = $(this).data('filter');
            $('[name="go_filter"]').val(go_filter);
            $('#search_submit').trigger('click');
        });
        $('.go-brand').click(function() {
            var brand_desc = $(this).data('brand-desc');
            var brand = $(this).data('brand');
            $('[name="search_in_desc"]').val(brand_desc);
            <?php if (!empty(brand)) { ?>
                $('[name="search_in_brand"]').val(brand);
            <?php } ?>
            $('#search_submit').trigger('click');
        });
        $('.go-color').click(function() {
            var brand_color = $(this).data('brand-color'); //alert(brand_siz)
            $('[name="search_in_color"]').val(brand_color);
            $('#search_submit').trigger('click');
        });
        $('.go-size').click(function() {
            var brand_siz = $('.go-size:checked').map(function() {
                return $(this).val();
            }).get().join(',');
            $('[name="search_in_size"]').val(brand_siz);
            $('#search_submit').trigger('click');
            //submitForm();
        });
        $('.brand').click(function() {
            var brand_id = $(this).data('brand-id');
            $('[name="brand_id"]').val(brand_id);
            submitForm()
        });
    });

    $(document).ready(function() {
        $('.img_products').click(function(){
           var title = $(this).data('title');
    $.post('<?=base_url()?>home/get_image_diff_clr', { 
        title: title
    })
    .done(function(response) { //alert(response)
        $('#colorThumbs1').html(response);
        $('#galleryThumbs1').html('');
        $('#galleryThumbs1').html(response);
        
    });
        });
        // Toggle wishlist on button click
        $('.wishlist-btn').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var $btn = $(this);
            var productId = $(this).attr('data-product-id');
            $.ajax({
                url: '<?= base_url("wishlist/toggle") ?>',
                type: 'POST',
                data: {
                    product_id: productId
                },
                dataType: 'json',
                success: function(response) { //alert(response.status)
                    if (response.status === 'added') {
                        alertify.set('notifier', {
                            position: 'top-center' // ✅ Top Center
                        });
                        alertify.success('Product Added to wishlist ❤️');
                    } else if (response.status === 'removed') {
                        // Confirm dialog
                        alertify.confirm('Remove from wishlist?', function(e) {
                            if (e) {
                                alertify.success('Removed from wishlist!');
                            } else {
                                alertify.message('Cancelled');
                            }
                        });
                    }
                    $('#wishlistCount').text(response.count);
                    showNotification(response.message);
                },
                error: function() {
                    alert('Error occurred. Please try again.');
                }
            });
        });

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