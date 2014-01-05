<?php
/**
 * Created by PhpStorm.
 * User: ishigetani
 * Date: 14/01/03
 * Time: 11:08
 */
?>
<div id="notifyMessage">
<?php
if (!empty($valerror)){
    foreach($valerror as $error) {
        echo $error. "<br />\n";
    }
} else {
    echo "送信完了";
    ?>
    <script>
        $(function(){
            $('#chat-message').val("");
        });
    </script>
<?php
}
?>
</div>

<script type="text/javascript">
    $(function () {
        $(document).ready(function() {
            $("#notifyMessage").stop().fadeIn(1000).delay(2000).fadeOut("slow");
        });
    });
</script>