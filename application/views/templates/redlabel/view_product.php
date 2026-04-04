<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$pid        = (int)$product['id'];
$p_url      = isset($product['url'])   ? $product['url']   : '';
$p_title    = isset($product['title']) ? $product['title'] : '';
$p_brand    = isset($product['brand']) ? $product['brand'] : '';
$p_wsp      = isset($product['wsp'])   ? $product['wsp']   : (isset($product['price']) ? $product['price'] : '');
$p_msp      = isset($product['msp'])   ? $product['msp']   : '';
$p_color    = isset($product['color']) ? $product['color'] : '';
$p_sizes    = isset($product['size_range']) ? $product['size_range'] : '';
$p_fabric   = isset($product['fabric'])  ? $product['fabric']  : '';
$p_season   = isset($product['season'])  ? $product['season']  : '';
$p_desc     = isset($product['description']) ? $product['description'] : '';
$p_qty      = isset($product['quantity'])    ? (int)$product['quantity'] : 0;
$p_catname  = isset($product['categorie_name']) ? $product['categorie_name'] : '';
$p_image    = '';
if (!empty($product['image'])) {
    $p_image = base_url('attachments/shop_images/' . $product['image']);
}
$fallback = base_url('attachments/shop_images/spark_logo-06.jpg');

// Gallery images from folder
$gallery = [];
if (!empty($product['folder'])) {
    $dir = 'attachments/shop_images/' . $product['folder'] . '/';
    if (is_dir($dir) && ($dh = opendir($dir))) {
        while (($file = readdir($dh)) !== false) {
            if (is_file($dir . $file)) {
                $gallery[] = base_url($dir . $file);
            }
        }
        closedir($dh);
        sort($gallery);
    }
}
if ($p_image && !in_array($p_image, $gallery)) {
    array_unshift($gallery, $p_image);
}
if (empty($gallery) && $p_image) $gallery[] = $p_image;
?>

<div class="product-detail-page py-4">
  <div class="container-xxl container-lg">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb small">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-dark">Home</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('home/shop') ?>" class="text-dark">Shop</a></li>
        <?php if ($p_catname): ?>
          <li class="breadcrumb-item"><a href="<?= base_url('home/shop?category=' . (int)$product['shop_categorie']) ?>" class="text-dark"><?= htmlspecialchars($p_catname) ?></a></li>
        <?php endif; ?>
        <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($p_title) ?></li>
      </ol>
    </nav>

    <div class="row g-4 g-lg-5">

      <!-- Images Column -->
      <div class="col-lg-6">
        <div class="product-gallery sticky-top" style="top:80px;">
          <!-- Main image -->
          <div class="main-image-wrap mb-3 position-relative overflow-hidden rounded-2" style="background:#f8f8f8;">
            <img id="pdMainImg"
                 src="<?= $gallery ? $gallery[0] : $fallback ?>"
                 alt="<?= htmlspecialchars($p_title) ?>"
                 class="w-100"
                 style="max-height:520px; object-fit:contain; display:block; margin:auto;"
                 onerror="this.onerror=null;this.src='<?= $fallback ?>'">
            <?php if ($p_brand): ?>
              <span class="brand-badge-animated position-absolute top-0 start-0 m-2"><?= htmlspecialchars($p_brand) ?></span>
            <?php endif; ?>
          </div>
          <!-- Thumbnails — always rendered so JS can populate with variation images -->
          <div class="d-flex flex-wrap gap-2" id="pdThumbs" <?= count($gallery) <= 1 ? 'style="display:none;"' : '' ?>>
            <?php foreach ($gallery as $i => $img): ?>
              <div class="pd-thumb <?= $i === 0 ? 'active' : '' ?>"
                   data-src="<?= $img ?>"
                   style="width:72px;height:72px;border:2px solid <?= $i===0 ? '#111' : '#ddd' ?>;border-radius:6px;overflow:hidden;cursor:pointer;flex-shrink:0;">
                <img src="<?= $img ?>" alt="thumb <?= $i+1 ?>"
                     style="width:100%;height:100%;object-fit:cover;"
                     onerror="this.onerror=null;this.src='<?= $fallback ?>'">
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Info Column -->
      <div class="col-lg-6">

        <!-- Title + wishlist -->
        <div class="d-flex align-items-start justify-content-between gap-2 mb-1">
          <h1 class="fs-4 fw-bold mb-0"><?= htmlspecialchars($p_title) ?></h1>
          <a href="javascript:void(0);" class="fs-4 ms-2 flex-shrink-0">
            <i data-product-id="<?= $pid ?>"
               class="<?= !empty($is_wishlisted) ? 'bi bi-heart-fill text-danger' : 'bi bi-heart' ?> wishlist-btn"></i>
          </a>
        </div>

        <?php if ($p_brand): ?>
          <p class="text-muted mb-2">Brand: <span class="text-dark fw-semibold"><?= htmlspecialchars($p_brand) ?></span></p>
        <?php endif; ?>

        <!-- Price -->
        <div class="mb-3">
          <?php if ($p_msp): ?>
            <span class="text-muted me-2">MRP: ₹<?= htmlspecialchars($p_msp) ?> <span style="font-size:12px;font-weight:400;">/ per piece</span></span>
          <?php endif; ?>
          <?php if ($p_wsp): ?>
            <strong class="fs-5">WSP: ₹<?= htmlspecialchars($p_wsp) ?></strong> <span class="text-muted" style="font-size:13px;">/ per piece</span>
          <?php endif; ?>
        </div>

        <hr>

        <!-- Details grid -->
        <?php
        $p_sub_category      = isset($product['sub_category'])      ? $product['sub_category']      : '';
        $p_fabric_category   = isset($product['fabric_category'])   ? $product['fabric_category']   : '';
        $p_fabric_type       = isset($product['fabric_type'])       ? $product['fabric_type']       : '';
        $p_fabric_composition= isset($product['fabric_composition'])? $product['fabric_composition']: '';
        $details = array_filter([
          'Category'          => $p_catname,
          'Sub Category'      => $p_sub_category,
          'Fabric Category'   => $p_fabric_category,
          'Fabric'            => $p_fabric,
          'Fabric Type'       => $p_fabric_type,
          'Fabric Composition'=> $p_fabric_composition,
          'Season'            => $p_season,
        ]); ?>
        <?php if (!empty($details)): ?>
        <div class="row g-2 mb-3 small">
          <?php foreach ($details as $label => $val): ?>
            <div class="col-6">
              <span class="text-muted"><?= $label ?>:</span>
              <span class="fw-semibold ms-1"><?= htmlspecialchars($val) ?></span>
            </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Color + Size Selector -->
        <?php
        // Color name → hex map (normalised uppercase keys)
        $colorMap = [
            'RED'=>'#E53935','BRICK RED'=>'#B22222','DARK RED'=>'#8B0000','WINE'=>'#722F37','MAROON'=>'#800000','RUST'=>'#B7410E',
            'ORANGE'=>'#FFA500','TANGERINE RUSH'=>'#FF8C00','BURNT ORANGE'=>'#CC5500',
            'YELLOW'=>'#FDD835','MUSTARD'=>'#FFDB58','LEMON'=>'#FFF44F','GOLDEN'=>'#FFD700','GOLD'=>'#FFD700',
            'GREEN'=>'#43A047','DARK GREEN'=>'#1B5E20','OLIVE'=>'#808000','OLIVE GREEN'=>'#6B8E23','PISTA'=>'#93C572',
            'PISTACHIO GREEN'=>'#93C572','MINT'=>'#98FF98','SOFT MINT'=>'#98FB98','TEA GREEN'=>'#D0F0C0',
            'TEAL'=>'#008080','DARK TEAL'=>'#014D4E','AQUA'=>'#00FFFF','AQUA BLUE'=>'#4FC3F7','SURF'=>'#00CED1',
            'BLUE'=>'#1E88E5','DARK BLUE'=>'#0D47A1','NAVY'=>'#001F5B','NAVY BLUE'=>'#003087','SKY BLUE'=>'#87CEEB',
            'POWDER BLUE'=>'#B0E0E6','DENIM BLUE'=>'#1560BD','AIR FORCE'=>'#5D8AA8','AIRFORCE BLUE'=>'#5D8AA8',
            'ROYAL BLUE'=>'#4169E1','COBALT'=>'#0047AB','STEEL BLUE'=>'#4682B4','CLASSIC BLUE'=>'#0F4C81',
            'PURPLE'=>'#7B1FA2','VIOLET'=>'#7F00FF','LAVENDER'=>'#967BB6','LILAC'=>'#C8A2C8','MAUVE'=>'#E0B0FF',
            'PALE MAUVE'=>'#DDA0DD','PASTEL LILAC'=>'#DDA0DD',
            'PINK'=>'#EC407A','BABY PINK'=>'#F4C2C2','HOT PINK'=>'#FF1493','DEEP PINK'=>'#FF1493',
            'CANDY PINK'=>'#FF69B4','WARM PINK'=>'#FF69B4','ROSE'=>'#E91E8C','BLUSH'=>'#DE5D83',
            'PEACH'=>'#FFCBA4','PEACH BLUSH'=>'#FFCBA4','APRICOT'=>'#FBCEB1','SALMON'=>'#FA8072',
            'BROWN'=>'#6D4C41','DARK BROWN'=>'#3E2723','CHOCOLATE'=>'#D2691E','COFFEE'=>'#6F4E37',
            'CAMEL'=>'#C19A6B','TOFFEE'=>'#C68E17','BISCUIT'=>'#E8DAB2','SAND BEIGE'=>'#F4A460',
            'BEIGE'=>'#F5F5DC','CREAM'=>'#FFFDD0','VANILLA'=>'#F3E5AB','BUTTER'=>'#FFFF99','BUTTER CREAM'=>'#FFFDD0',
            'WHITE'=>'#FFFFFF','OFF WHITE'=>'#FAF9F6','IVORY'=>'#FFFFF0','WHITE MIL.'=>'#FFFAFA',
            'BLACK'=>'#212121','CHARCOAL'=>'#36454F','CHARCOAL GREY'=>'#36454F','CARBON BLACK'=>'#1C2526',
            'GREY'=>'#9E9E9E','GRAY'=>'#9E9E9E','DARK GREY'=>'#616161','DARK GRAY'=>'#616161',
            'LIGHT GREY'=>'#BDBDBD','SOFT GREY'=>'#D3D3D3','SILVER'=>'#C0C0C0','ASH'=>'#B2BEB5','ASH GREY'=>'#B2BEB5',
            'CORAL'=>'#FF6F61','CHERRY'=>'#DE3163','BURGUNDY'=>'#800020',
            'LIME'=>'#CDDC39','SAGE'=>'#BCB88A','SAGE GREEN'=>'#BCB88A',
            'INDIGO'=>'#3F51B5','CYAN'=>'#00BCD4','TURQUOISE'=>'#40E0D0',
            'MAGENTA'=>'#E91E63','FUCHSIA'=>'#FF00FF',
        ];
        function pd_color_hex($name, $map) {
            $key = strtoupper(trim($name));
            if (isset($map[$key])) return $map[$key];
            // Try partial match on first word
            $parts = explode(' ', $key);
            if (isset($map[$parts[0]])) return $map[$parts[0]];
            // Derive a hue from the string so unknown colours still get a unique swatch
            $hash = crc32($key);
            $h = abs($hash) % 360;
            return 'hsl(' . $h . ',55%,50%)';
        }
        // Determine if a hex is dark (to decide text colour on swatch)
        function pd_is_dark($hex) {
            if (strpos($hex, 'hsl') === 0) return false;
            $hex = ltrim($hex, '#');
            if (strlen($hex) === 3) $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
            $r = hexdec(substr($hex,0,2)); $g = hexdec(substr($hex,2,2)); $b = hexdec(substr($hex,4,2));
            return (0.299*$r + 0.587*$g + 0.114*$b) < 140;
        }
        ?>
        <?php
        // Color siblings swatches
        $siblings = isset($color_siblings) ? $color_siblings : [];
        if (!empty($siblings) || !empty($p_color)):
        ?>
        <div class="mb-3">
          <p class="fw-semibold mb-2">Color:
            <span class="text-muted fw-normal ms-1"><?= htmlspecialchars(ucwords(strtolower($p_color))) ?></span>
          </p>
          <div class="d-flex flex-wrap gap-2 align-items-center">
            <!-- Current product swatch (selected) -->
            <?php if ($p_color):
              $curHex   = pd_color_hex($p_color, $colorMap);
              $curDark  = pd_is_dark($curHex);
            ?>
            <div title="<?= htmlspecialchars(ucwords(strtolower($p_color))) ?>"
                 style="position:relative;cursor:default;">
              <div style="
                width:44px;height:44px;border-radius:6px;
                background:<?= $curHex ?>;
                outline:2px solid #111;outline-offset:3px;
              "></div>
              <div style="font-size:10px;text-align:center;margin-top:3px;color:#111;font-weight:600;">
                <?= htmlspecialchars(ucwords(strtolower($p_color))) ?>
              </div>
            </div>
            <?php endif; ?>
            <!-- Sibling swatches -->
            <?php foreach ($siblings as $sib):
              $sibColor = trim($sib['color']);
              $sibHex   = pd_color_hex($sibColor, $colorMap);
              $sibDark  = pd_is_dark($sibHex);
              $sibUrl   = base_url($sib['url'] . '_' . $sib['id']);
              $sibOos   = (int)$sib['quantity'] === 0;
            ?>
            <a href="<?= $sibUrl ?>"
               title="<?= htmlspecialchars(ucwords(strtolower($sibColor))) ?><?= $sibOos ? ' (Out of Stock)' : '' ?>"
               style="text-decoration:none;">
              <div style="
                width:44px;height:44px;border-radius:6px;
                background:<?= $sibHex ?>;
                outline:2px solid rgba(0,0,0,.15);outline-offset:0;
                transition:outline-color .15s,outline-offset .15s;
                <?= $sibOos ? 'opacity:.45;' : '' ?>
                position:relative;overflow:hidden;
              ">
                <?php if ($sibOos): ?>
                  <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                    <div style="width:120%;height:2px;background:rgba(180,0,0,.6);transform:rotate(-45deg);"></div>
                  </div>
                <?php endif; ?>
              </div>
              <div style="font-size:10px;text-align:center;margin-top:3px;color:#555;">
                <?= htmlspecialchars(ucwords(strtolower($sibColor))) ?>
              </div>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <?php
        // Set info from barcodes
        $set_barcodes      = isset($product_barcodes) ? $product_barcodes : [];
        $available_sizes   = array_filter($set_barcodes, function($b) { return (int)$b['stock_qty'] > 0; });
        $set_count         = count($available_sizes);
        $total_sizes       = count($set_barcodes);
        ?>
        <?php if (!empty($set_barcodes)): ?>
          <!-- Set indicator -->
          <div class="mb-3">
            <span class="badge rounded-pill" style="background:#111;color:#fff;font-size:13px;padding:6px 14px;letter-spacing:.3px;">
              Set of <?= $set_count ?>
              <?php if ($set_count < $total_sizes): ?>
                <span style="opacity:.65;font-weight:400;font-size:11px;"> (<?= $total_sizes - $set_count ?> size<?= ($total_sizes - $set_count) > 1 ? 's' : '' ?> out of stock)</span>
              <?php endif; ?>
            </span>
          </div>
          <!-- Size availability chips -->
          <div class="mb-3">
            <p class="fw-semibold mb-2">Sizes included in this set:</p>
            <div class="d-flex flex-wrap gap-2">
              <?php foreach ($set_barcodes as $bc): ?>
                <?php $in_stock = (int)$bc['stock_qty'] > 0; ?>
                <div style="
                  display:inline-flex;flex-direction:column;align-items:center;gap:3px;
                  min-width:48px;padding:6px 10px;border-radius:8px;text-align:center;
                  border:1.5px solid <?= $in_stock ? '#198754' : '#dee2e6' ?>;
                  background:<?= $in_stock ? '#f0fdf4' : '#f8f9fa' ?>;
                  <?= !$in_stock ? 'opacity:.55;position:relative;' : '' ?>
                ">
                  <span style="font-weight:700;font-size:13px;color:<?= $in_stock ? '#111' : '#999' ?>;"><?= htmlspecialchars($bc['size']) ?></span>
                  <?php if (!$in_stock): ?>
                    <span style="font-size:9px;color:#dc3545;font-weight:600;letter-spacing:.2px;">OUT OF STOCK</span>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <?php if (!empty($variations)): ?>
          <div class="mb-2">
            <p class="fw-semibold mb-1">Color: <span id="pdColorName" class="text-muted fw-normal"></span></p>
            <div class="d-flex flex-wrap gap-2 mb-3" id="pdColorThumbs">
              <?php $firstVar = true; foreach ($variations as $i => $v):
                $vColor = trim($v['color']);
                $vSwatch = !empty($v['swatch']) ? trim($v['swatch']) : '';
                if (!$vColor && !$vSwatch) continue;
                // Use stored hex if available, else derive from name
                $hex = (!empty($v['hex']) && trim($v['hex']) !== '#cccccc') ? trim($v['hex'])
                     : ($vColor ? pd_color_hex($vColor, $colorMap) : '#cccccc');
                $isDark     = pd_is_dark($hex);
                $txtColor   = $isDark ? '#fff' : '#111';
                $swatchFile = $vSwatch;
                $swatchUrl  = $swatchFile ? base_url('attachments/product_swatches/' . $swatchFile) : '';
                $colorLabel = $vColor ? htmlspecialchars(ucwords(strtolower($vColor))) : '';
                $vImgUrls = [];
                if (!empty($v['images'])) {
                    foreach (array_filter(array_map('trim', explode(',', $v['images']))) as $imgFile) {
                        $vImgUrls[] = base_url('attachments/variation_images/' . $imgFile);
                    }
                }
              ?>
                <div class="color-swatch-wrap <?= $firstVar ? 'selected' : '' ?>"
                     data-color="<?= htmlspecialchars($vColor) ?>"
                     data-sizes="<?= htmlspecialchars($v['sizes']) ?>"
                     data-hex="<?= $hex ?>"
                     data-images="<?= htmlspecialchars(implode(',', $vImgUrls)) ?>"
                     title="<?= $colorLabel ?>">
                  <div class="color-swatch-thumb" style="<?= $swatchUrl ? '' : 'background:' . $hex . ';' ?>">
                    <?php if ($swatchUrl): ?>
                      <img src="<?= $swatchUrl ?>"
                           style="width:100%;height:100%;object-fit:cover;display:block;"
                           onerror="this.style.display='none';this.parentElement.style.background='<?= $hex ?>'">
                    <?php endif; ?>
                    <span class="swatch-check" style="color:<?= $swatchUrl ? '#fff' : $txtColor ?>;<?= $swatchUrl ? 'text-shadow:0 0 3px rgba(0,0,0,.55);' : '' ?>">✓</span>
                  </div>
                  <div class="swatch-label"><?= $colorLabel ?></div>
                </div>
              <?php $firstVar = false; endforeach; ?>
            </div>
            <p class="fw-semibold mb-1">Size</p>
            <select id="pdSizeSelect" class="mb-2">
              <option value="">— Select Size —</option>
            </select>
            <div class="size-error fw-semibold text-danger small" id="pdSizeError" style="display:none;">PLEASE SELECT A SIZE</div>
          </div>
        <?php elseif ($p_color || $p_sizes): ?>
          <div class="mb-3">
            <?php if ($p_color): ?>
              <?php $hex = pd_color_hex($p_color, $colorMap); $isDark = pd_is_dark($hex); ?>
              <p class="fw-semibold mb-1">Color:
                <span class="d-inline-flex align-items-center gap-2 ms-1">
                  <span style="display:inline-block;width:18px;height:18px;border-radius:50%;background:<?= $hex ?>;border:1px solid rgba(0,0,0,.15);vertical-align:middle;"></span>
                  <span class="text-muted fw-normal"><?= htmlspecialchars(ucwords(strtolower($p_color))) ?></span>
                </span>
              </p>
            <?php endif; ?>
            <?php if ($p_sizes && empty($set_barcodes)): ?>
              <p class="fw-semibold mb-1">Size Range: <span class="text-muted fw-normal"><?= htmlspecialchars($p_sizes) ?></span></p>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <!-- Add to Cart / Out of Stock -->
        <?php if ($p_qty > 0): ?>
          <div class="d-flex gap-2 mt-3 mb-4">
            <button type="button" id="pdAddToCart"
                    class="btn btn-dark rounded-pill flex-grow-1"
                    data-id="<?= $pid ?>"
                    data-wsp="<?= htmlspecialchars($p_wsp) ?>"
                    data-mrp="<?= htmlspecialchars($p_msp) ?>">
              Add to Cart
            </button>
            <a href="<?= base_url('checkout') ?>"
               id="pdBuyNow"
               class="btn btn-outline-dark rounded-pill flex-grow-1">
              Buy Now
            </a>
          </div>
        <?php else: ?>
          <div class="alert alert-secondary mt-3">Out of Stock</div>
        <?php endif; ?>

        <!-- Description -->
        <?php if ($p_desc): ?>
          <div class="product-description mt-3">
            <p class="fw-semibold mb-1">Description</p>
            <div class="text-muted small"><?= $p_desc ?></div>
          </div>
        <?php endif; ?>

      </div>
    </div>

    <!-- Related Products -->
    <?php if (!empty($sameCagegoryProducts)): ?>
    <div class="mt-5 pt-4 border-top">
      <h2 class="h2_heading mb-4">You May Also Like</h2>
      <div class="row g-3">
        <?php foreach ($sameCagegoryProducts as $rp): ?>
          <div class="col-lg-3 col-md-4 col-6">
            <div class="tb-product-item-inner">
              <div class="card product-card border-0">
                <a href="<?= base_url($rp['url'] . '_' . $rp['id']) ?>">
                  <div class="product-img-wrapper overflow-hidden">
                    <img src="<?= base_url('attachments/shop_images/' . $rp['image']) ?>"
                         class="w-100 img_products" alt="<?= htmlspecialchars($rp['title']) ?>" loading="lazy"
                         onerror="this.onerror=null;this.src='<?= $fallback ?>'">
                  </div>
                </a>
              </div>
              <ul class="list-unstyled tb-content mt-2">
                <li class="product-title">
                  <a href="<?= base_url($rp['url'] . '_' . $rp['id']) ?>">
                    <?= htmlspecialchars($rp['title']) ?>
                  </a>
                </li>
                <?php if (!empty($rp['price'])): ?>
                  <li class="product-price">₹<?= htmlspecialchars($rp['price']) ?></li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

  </div>
</div>

<style>
.product-detail-page .main-image-wrap img { transition: opacity 0.2s; }
.pd-thumb { transition: border-color 0.15s; }
.pd-thumb.active { border-color: #111 !important; }
/* Swatch thumbnail wrapper */
.color-swatch-wrap {
  display: flex; flex-direction: column; align-items: center;
  cursor: pointer; flex-shrink: 0; width: 44px;
}
.color-swatch-thumb {
  position: relative; overflow: hidden;
  width: 44px; height: 44px; border-radius: 6px;
  border: 2px solid transparent;
  outline: 2px solid rgba(0,0,0,.12);
  outline-offset: 0;
  transition: outline-color .15s, outline-offset .15s, transform .1s;
}
.color-swatch-wrap:hover .color-swatch-thumb { outline-color: rgba(0,0,0,.4); transform: scale(1.05); }
.color-swatch-wrap.selected .color-swatch-thumb {
  outline: 2px solid #111;
  outline-offset: 3px;
  transform: scale(1.05);
}
.swatch-check {
  position: absolute; inset: 0;
  display: flex; align-items: center; justify-content: center;
  font-size: 14px; font-weight: 700; opacity: 0; transition: opacity .15s;
  pointer-events: none;
}
.color-swatch-wrap.selected .swatch-check { opacity: 1; }
.swatch-label {
  font-size: 9px; text-align: center; margin-top: 3px;
  color: #555; max-width: 44px; overflow: hidden;
  white-space: nowrap; text-overflow: ellipsis; line-height: 1.2;
}
.color-swatch-wrap.selected .swatch-label { color: #111; font-weight: 600; }
#pdSizeSelect {
  width: 100%; max-width: 220px; padding: 8px 12px;
  border: 1.5px solid #ccc; border-radius: 6px;
  font-size: 14px; background: #fff; cursor: pointer;
  appearance: auto;
}
</style>

<script>
(function(){
  var variations   = <?= json_encode(!empty($variations) ? $variations : []) ?>;
  var fallbackColor = <?= json_encode($p_color) ?>;
  var fallbackSizes = <?= json_encode($p_sizes) ?>;
  var productId   = <?= $pid ?>;
  var productWsp  = <?= json_encode($p_wsp) ?>;
  var productMrp  = <?= json_encode($p_msp) ?>;
  var selectedColor = '', selectedSize = '';

  // Default gallery images (from folder/main image)
  var defaultGallery = <?= json_encode($gallery) ?>;
  var fallbackSrc = '<?= $fallback ?>';

  function setGallery(imgs) {
    var mainImg = document.getElementById('pdMainImg');
    var thumbsDiv = document.getElementById('pdThumbs');
    if (!mainImg) return;
    if (!imgs || !imgs.length) imgs = defaultGallery;

    // Update main image
    mainImg.style.opacity = '0.5';
    mainImg.src = imgs[0] || fallbackSrc;
    mainImg.onload = function(){ mainImg.style.opacity = '1'; };

    if (!thumbsDiv) return;

    // Rebuild thumbnail strip (show for >=2 images, hide for <=1)
    thumbsDiv.innerHTML = '';
    if (imgs.length >= 2) {
      imgs.forEach(function(url, i) {
        var div = document.createElement('div');
        div.className = 'pd-thumb' + (i === 0 ? ' active' : '');
        div.dataset.src = url;
        div.style.cssText = 'width:72px;height:72px;border:2px solid '+(i===0?'#111':'#ddd')+';border-radius:6px;overflow:hidden;cursor:pointer;flex-shrink:0;';
        div.innerHTML = '<img src="'+url+'" style="width:100%;height:100%;object-fit:cover;" onerror="this.onerror=null;this.src=\''+fallbackSrc+'\'">';
        div.addEventListener('click', function(){
          document.querySelectorAll('.pd-thumb').forEach(function(t){ t.classList.remove('active'); t.style.borderColor='#ddd'; });
          div.classList.add('active'); div.style.borderColor='#111';
          var mi = document.getElementById('pdMainImg');
          if (mi) { mi.style.opacity='0.5'; mi.src=url; mi.onload=function(){ mi.style.opacity='1'; }; }
        });
        thumbsDiv.appendChild(div);
      });
      thumbsDiv.style.display = '';
    } else {
      thumbsDiv.style.display = 'none';
    }
  }

  // Thumbnail gallery (default page-load clicks)
  document.querySelectorAll('.pd-thumb').forEach(function(thumb){
    thumb.addEventListener('click', function(){
      document.querySelectorAll('.pd-thumb').forEach(function(t){ t.classList.remove('active'); t.style.borderColor='#ddd'; });
      this.classList.add('active'); this.style.borderColor='#111';
      var mainImg = document.getElementById('pdMainImg');
      if (mainImg) { mainImg.style.opacity='0.5'; mainImg.src = this.dataset.src; mainImg.onload = function(){ mainImg.style.opacity='1'; }; }
    });
  });

  // Size renderer
  function renderSizes(sizesStr) {
    var sel = document.getElementById('pdSizeSelect');
    if (!sel) return;
    sel.innerHTML = '<option value="">— Select Size —</option>';
    selectedSize = '';
    if (!sizesStr) return;
    sizesStr.split(',').map(function(s){ return s.trim(); }).filter(Boolean).forEach(function(s){
      var opt = document.createElement('option');
      opt.value = s; opt.textContent = s;
      sel.appendChild(opt);
    });
    sel.onchange = function(){
      selectedSize = sel.value;
      var err = document.getElementById('pdSizeError');
      if (err) err.style.display = 'none';
    };
  }

  // Format color name nicely (TITLE CASE)
  function fmtColor(s) {
    return s.replace(/\w\S*/g, function(w){ return w.charAt(0).toUpperCase() + w.slice(1).toLowerCase(); });
  }

  // Init variations
  if (variations.length > 0) {
    var colorSwatches = document.querySelectorAll('#pdColorThumbs .color-swatch-wrap');
    colorSwatches.forEach(function(chip){
      chip.onclick = function(){
        colorSwatches.forEach(function(c){ c.classList.remove('selected'); });
        chip.classList.add('selected');
        selectedColor = chip.dataset.color;
        selectedSize = '';
        var colorNameEl = document.getElementById('pdColorName');
        if (colorNameEl) colorNameEl.innerText = fmtColor(chip.dataset.color);
        renderSizes(chip.dataset.sizes || '');
        // Swap gallery if variation has images
        var imgs = chip.dataset.images ? chip.dataset.images.split(',').map(function(s){ return s.trim(); }).filter(Boolean) : [];
        setGallery(imgs.length ? imgs : null);
      };
    });
    // Auto-select first
    if (colorSwatches.length > 0) {
      var first = colorSwatches[0];
      selectedColor = first.dataset.color;
      var colorNameEl = document.getElementById('pdColorName');
      if (colorNameEl) colorNameEl.innerText = fmtColor(first.dataset.color);
      renderSizes(first.dataset.sizes || '');
      var firstImgs = first.dataset.images ? first.dataset.images.split(',').map(function(s){ return s.trim(); }).filter(Boolean) : [];
      if (firstImgs.length) setGallery(firstImgs);
    }
  } else if (fallbackSizes) {
    renderSizes(fallbackSizes);
    if (fallbackColor) selectedColor = fallbackColor;
  }

  // Add to cart
  var addBtn = document.getElementById('pdAddToCart');
  var buyBtn = document.getElementById('pdBuyNow');
  if (addBtn) {
    addBtn.addEventListener('click', function(){
      var sel = document.getElementById('pdSizeSelect');
      if (!selectedSize && sel && sel.options.length > 1) {
        var err = document.getElementById('pdSizeError');
        if (err) err.style.display = 'block';
        return;
      }
      addBtn.disabled = true; addBtn.innerText = 'Adding...';
      if (typeof variable !== 'undefined' && variable.manageShoppingCartUrl) {
        jQuery.ajax({
          type: 'POST', url: variable.manageShoppingCartUrl, dataType: 'text',
          data: { article_id: productId, action: 'add', wsp: productWsp, mrp: productMrp }
        }).done(function(data){
          try { var r = JSON.parse(data); if (r && r.login_required) { window.location.href = '<?= base_url("login") ?>'; return; } } catch(e){}
          document.dispatchEvent(new Event('cartItemAdded'));
          addBtn.disabled = false; addBtn.innerText = 'Add to Cart';
          if (typeof ShowNotificator === 'function') ShowNotificator('alert-info', 'Added to cart!');
        }).fail(function(){
          addBtn.disabled = false; addBtn.innerText = 'Add to Cart';
        });
      }
    });
  }
  if (buyBtn) {
    buyBtn.addEventListener('click', function(e){
      e.preventDefault();
      var sel = document.getElementById('pdSizeSelect');
      if (!selectedSize && sel && sel.options.length > 1) {
        var err = document.getElementById('pdSizeError');
        if (err) err.style.display = 'block';
        return;
      }
      if (typeof variable !== 'undefined' && variable.manageShoppingCartUrl) {
        jQuery.ajax({
          type: 'POST', url: variable.manageShoppingCartUrl, dataType: 'text',
          data: { article_id: productId, action: 'add', wsp: productWsp, mrp: productMrp }
        }).done(function(){
          window.location.href = '<?= base_url("checkout") ?>';
        });
      } else {
        window.location.href = '<?= base_url("checkout") ?>';
      }
    });
  }
})();
</script>
