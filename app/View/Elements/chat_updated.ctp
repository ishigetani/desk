<?php
/**
 * Created by PhpStorm.
 * User: ishigetani
 * Date: 14/01/04
 * Time: 16:05
 */
?>
<div id="dataMessage">
    データが更新できます
</div>
<script>
    $(function(){
        $("#dataMessage").stop().fadeIn(1000).delay(2000).fadeOut("slow");
        $("#chat-updated").fadeIn('slow');
    });
</script>