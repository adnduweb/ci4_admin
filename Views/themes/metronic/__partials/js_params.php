<!--begin::Lang Skins(used by all pages) -->
<script src="<?= assetAdmin('js/language/lang_'. service('request')->getLocale() . '.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
    <?php
    $htmlJs = "";
    foreach ($paramJs as $k => $v) {
        $htmlJs .= ' var ' . $k . ' = ';
        if (preg_match('`\[(.+)\]`iU', $v)) {
            $htmlJs .=  $v;
        } else {
            $htmlJs .= "'" . $v . "'";
        }

        $htmlJs .= '; ' . "\n";
    }
    echo $htmlJs;
    ?>
</script>

<script type="text/javascript">
/**
 * ----------------------------------------------------------------------------
 * Javascript Auto Logout in CodeIgniter 4
 * ---------------------------------------------------------------------------
 */
// Set timeout variables.
var timoutNow = <?= env('app.sessionExpiration') * 1000; ?>; // Timeout of 1800000 / 30 mins - time in ms
var logoutUrl = base_url + segementAdmin + '/logout'; // URL to logout page.

var timeoutTimer;

// Start timer
function StartTimers() {
    timeoutTimer = setTimeout("IdleTimeout()", timoutNow);
}

// Reset timer
function ResetTimers() {
    clearTimeout(timeoutTimer);
    StartTimers();
}

// Logout user
function IdleTimeout() {
    window.location = logoutUrl;
}



</script>
