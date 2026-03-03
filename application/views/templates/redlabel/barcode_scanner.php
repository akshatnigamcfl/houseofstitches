<!DOCTYPE html>
<html>
<head>
    <title>Barcode Scanner</title>
    <script src="https://houseofstitches.in/assets/js/jquery.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
</head>
<body>
    <div id="reader" style="width: 400px; height: 300px;"></div>
    <p id="result"></p>
    <script src="https://houseofstitches.in/assets/js/jquery.min.js"></script>
<script src="https://houseofstitches.in/assets/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/Draggable.min.js"></script>
<script src="https://houseofstitches.in/assets/js/owl.carousel.min.js"></script>
<script src="https://houseofstitches.in/assets/js/main.js"></script>
<script src="https://houseofstitches.in/assets/js/system.js"></script>
<script src="https://houseofstitches.in/loadlanguage/all.js"></script>
    <script>
    var variable = {
        clearShoppingCartUrl: "https://houseofstitches.in//clearShoppingCart",
        manageShoppingCartUrl: "https://houseofstitches.in//manageShoppingCart",
        discountCodeChecker: "https://houseofstitches.in//discountCodeChecker"
    };
</script>
    <script>
    $(function(){
        const html5QrCode = new Html5Qrcode("reader");
        
        const config = { fps: 10, qrbox: {width: 250, height: 250} };
        
        html5QrCode.start(
            { facingMode: "environment" },
            config,
            (decodedText, decodedResult) => {
                $('#result').html('Not Found: ' + decodedText);
                $.post('<?=base_url()?>home/scan_result', 
                    {barcode: decodedText}, 
                    function(data) { //
                        if(data.success) { //alert(data.product)
                        var article_id = data.product;
                            //manageShoppingCart('add',article_id , reload);
                        window.location.href = '<?= base_url("shopping-cart") ?>';
                   

                        } else {
                            $('#result').html('Invalid code');
                        }
                    }, 'json'
                );
                html5QrCode.stop();
            },
            (error) => {
                console.log('Scan error:', error);
            }
        ).catch(err => {
            console.error('Camera failed:', err);
            $('#result').html('Camera access denied');
        });
    });
    </script>
</body>
</html>
