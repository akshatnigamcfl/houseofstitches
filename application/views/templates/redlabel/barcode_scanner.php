<style>
#scanner-box { max-width: 480px; margin: 40px auto; text-align: center; }
#reader { width: 100%; border-radius: 8px; overflow: hidden; background: #000; min-height: 280px; }
#scan-result { margin-top: 15px; min-height: 40px; }
#start-btn { font-size: 18px; padding: 12px 32px; }
</style>

<div id="scanner-box">
    <h2><i class="fa fa-barcode"></i> Barcode Scanner</h2>
    <p class="text-muted">Scan a product barcode to add it to your cart.</p>

    <button id="start-btn" class="btn btn-primary btn-lg">
        <i class="fa fa-camera"></i> Open Camera
    </button>

    <div id="camera-ui" style="display:none;margin-top:15px;">
        <div id="reader"></div>
        <div style="margin-top:8px;">
            <button id="flip-btn" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Flip Camera</button>
            <button id="stop-btn" class="btn btn-default btn-sm"><i class="fa fa-stop"></i> Stop</button>
        </div>
    </div>

    <div id="scan-result"></div>

    <hr style="margin-top:30px;">
    <p class="text-muted small">Or enter the item code manually:</p>
    <div class="input-group" style="max-width:300px;margin:0 auto;">
        <input type="text" id="manual-code" class="form-control" placeholder="e.g. A24710BLZ961">
        <span class="input-group-btn">
            <button id="manual-btn" class="btn btn-default"><i class="fa fa-search"></i></button>
        </span>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var html5QrCode = null;
    var scanning    = false;
    var usingBack   = true;

    var startBtn  = document.getElementById('start-btn');
    var stopBtn   = document.getElementById('stop-btn');
    var flipBtn   = document.getElementById('flip-btn');
    var cameraUi  = document.getElementById('camera-ui');
    var resultBox = document.getElementById('scan-result');
    var manualIn  = document.getElementById('manual-code');
    var manualBtn = document.getElementById('manual-btn');

    function setResult(html) { resultBox.innerHTML = html; }

    var barcodeFormats = [
        Html5QrcodeSupportedFormats.QR_CODE,
        Html5QrcodeSupportedFormats.CODE_128,
        Html5QrcodeSupportedFormats.CODE_39,
        Html5QrcodeSupportedFormats.CODE_93,
        Html5QrcodeSupportedFormats.EAN_13,
        Html5QrcodeSupportedFormats.EAN_8,
        Html5QrcodeSupportedFormats.UPC_A,
        Html5QrcodeSupportedFormats.UPC_E,
        Html5QrcodeSupportedFormats.ITF,
    ];

    function startScanner() {
        if (!html5QrCode) {
            html5QrCode = new Html5Qrcode("reader", { formatsToSupport: barcodeFormats });
        }
        setResult('<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Starting camera…</div>');

        html5QrCode.start(
            usingBack ? { facingMode: "environment" } : { facingMode: "user" },
            { fps: 15, qrbox: { width: 320, height: 120 } },
            onScanSuccess,
            function () {}
        ).then(function () {
            startBtn.style.display = 'none';
            cameraUi.style.display = 'block';
            scanning = true;
            setResult('');
        }).catch(function (err) {
            setResult('<div class="alert alert-danger"><strong>Camera error:</strong> ' + err + '</div>');
        });
    }

    function stopScanner() {
        if (html5QrCode && html5QrCode.isScanning) {
            html5QrCode.stop().then(function () {
                cameraUi.style.display = 'none';
                startBtn.style.display = '';
                scanning = false;
            });
        }
    }

    function onScanSuccess(decodedText) {
        if (!scanning) return;
        scanning = false;
        setResult('<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Found: <strong>' + decodedText + '</strong> — looking up…</div>');
        lookupCode(decodedText);
    }

    function lookupCode(code) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= base_url('home/scan_result') ?>', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            try {
                var data = JSON.parse(xhr.responseText);
                if (data.success) {
                    stopScanner();
                    setResult('<div class="alert alert-success"><i class="fa fa-check"></i> Added to cart! Redirecting…</div>');
                    setTimeout(function () { window.location.href = '<?= base_url('shopping-cart') ?>'; }, 800);
                } else {
                    setResult('<div class="alert alert-warning">Product not found: <strong>' + code + '</strong>. Try again.</div>');
                    setTimeout(function () { scanning = true; }, 2500);
                }
            } catch (e) {
                setResult('<div class="alert alert-danger">Invalid server response.</div>');
                setTimeout(function () { scanning = true; }, 2500);
            }
        };
        xhr.onerror = function () {
            setResult('<div class="alert alert-danger">Server error. Please try again.</div>');
            setTimeout(function () { scanning = true; }, 2500);
        };
        xhr.send('barcode=' + encodeURIComponent(code));
    }

    startBtn.addEventListener('click', startScanner);
    stopBtn.addEventListener('click', stopScanner);

    flipBtn.addEventListener('click', function () {
        usingBack = !usingBack;
        if (html5QrCode && html5QrCode.isScanning) {
            html5QrCode.stop().then(startScanner);
        }
    });

    manualBtn.addEventListener('click', function () {
        var code = manualIn.value.trim();
        if (!code) return;
        setResult('<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Looking up <strong>' + code + '</strong>…</div>');
        lookupCode(code);
    });

    manualIn.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') manualBtn.click();
    });
});
</script>
