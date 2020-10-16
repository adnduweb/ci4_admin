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
