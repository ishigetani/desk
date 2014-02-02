<?php
/**
 * Created by PhpStorm.
 * User: ishigetani
 * Date: 13/12/31
 * Time: 13:09
 */

echo $this->Html->css('validationEngine.jquery');
echo $this->Html->script('jquery.validationEngine');
echo $this->Html->script('jquery.validationEngine-ja');
?>
<script>
    jQuery(document).ready(function(){
        jQuery("#form-validate").validationEngine();
    });
</script>