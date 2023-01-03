<h6>
<img class="currency-dashboard" src="<?= site_url('assets/images/currencies/' . strtolower($this_page['code']) . '.png') ?>" /> Balance Status:
<?php
	$param = array(
		'api_key' => $this_page['api'],
		'currency' => $this_page['code']
	);
	$url = 'https://faucetpay.io/api/v1/getbalance';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, count($param));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
	$faucetpay_url = json_decode(curl_exec($ch), true);
	curl_close($ch);
$str = number_format($this_page['reward']/$this_page['price'], 8);
$int = filter_var($str, FILTER_SANITIZE_NUMBER_INT);
	
                                    if ($faucetpay_url['status'] == 200 && $faucetpay_url['balance'] > $int) {
                                            echo ' <span class="text-success">Ready</span>';
                                    }else if ($faucetpay_url['status'] == 200 && $faucetpay_url['balance'] <= $int) {
                                            echo ' <span class="text-danger">Balance empty, refilling can take up to 24 hours, please be patient</span>';
                                    }else{
                                        echo ' <span class="text-warning">'.$faucetpay_url['message'].'</span>';
                                    }
?>
</h6>
<?php
    $a = $this_page['last_price'];
    $b = $this_page['price'];
function percent($a, $b)
{
    $result = 0;
    $result = (($b - $a) * 100) / $a;
    return $result;
}
if($this_page['price'] > $this_page['last_price']) {
echo '<p>Yesterday Price <span class="text-info"><i class="fas fa-dollar-sign"></i>'.format_money($this_page['last_price'],6).'</span><br>';
echo 'Current Price <span class="text-success"><i class="fas fa-dollar-sign"></i>'.format_money($this_page['price'],6); 
echo ' <i class="fas fa-caret-up"></i>+'.number_format(percent($a, $b),2) . "%</span></p>";
}else if($this_page['price'] < $this_page['last_price']) {
echo '<p>Yesterday Price <span class="text-info"><i class="fas fa-dollar-sign"></i>'.format_money($this_page['last_price'],6).'</span><br>';
echo 'Current Price <span class="text-danger"><i class="fas fa-dollar-sign"></i>'.format_money($this_page['price'],6); 
echo ' <i class="fas fa-caret-down"></i>'.number_format(percent($a, $b),2) . "%</span></p>";
}else if($this_page['price'] == $this_page['last_price']) {
echo '<p>Yesterday Price <span class="text-info"><i class="fas fa-dollar-sign"></i>'.format_money($this_page['last_price'],6).'</span><br>';
echo 'Current Price <span class="text-info"><i class="fas fa-dollar-sign"></i>'.format_money($this_page['price'],6); 
echo ' <i class="fas fa-sort"></i>'.number_format(percent($a, $b),2) . "%</span></p>";
}else{
echo 'price calculation error!';
}
?>
        <?php if ($limit) { ?>
            <div class="alert alert-danger text-center">Daily claim limit for this coin reached, please comeback again tomorrow, or invite more people to get additional claims.</div>
        <?php } else if ($wait) { ?>
                <div class="media">
                    <div class="media-body text-center">
                        <?php
                        if ($wait) { ?>
                            <h4 class="next-button lh-1 mb-1 fw-bold"><i class="fas fa-sync fa-spin"></i> Please wait <b id="minute"><?= floor($wait / 60) ?></b>:<b id="second"><?= $wait % 60 ?></b></h4>
                        <?php } else { ?>
                            <h4 class="lh-1 mb-1 fw-bold">READY</h4>
                        <?php } ?>
                    </div>
                </div>                                
            <script type="text/javascript">
                var wait = <?= $wait ?> - 1;
            </script>
        <?php } ?>