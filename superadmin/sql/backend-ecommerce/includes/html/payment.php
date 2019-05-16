<div style="text-align: center; margin: 10%;" >
    <h1>Please wait you are being redirect to payment gateway</h1>
    <div class="meter red">
        <span style="width: 100%"></span>
    </div>
</div>

<form action="<?php echo PAYMENT_URL; ?>" method="post" id="payform">
    <input type="hidden" name="business" value="<?php echo BUSSINESS_NAME; ?>">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="item_name" value="Templates">
    <input type="hidden" name="amount" value="<?= $_SESSION['amount']; ?>">
    <input type="hidden" name="custom" value='<?= $_SESSION['orderId']; ?>'>
    <input type="hidden" name="quantity" value='<?= $_SESSION['quantity']; ?>'>   
    <!-- Notify. -->
    <input type="hidden" name="notify_url" value="<?php echo $notifyURL;?>">
    <input type="hidden" name="return" value="<?php echo $returnURL;?>">
    <input type="hidden" name="cancel_return" value="<?php echo $cancelURL;?>">
    </form>
    <script>
        document.getElementById("payform").submit();
    </script> 