<?php
/**
 * Created by PhpStorm.
 * User: ishigetani
 * Date: 14/01/03
 * Time: 11:08
 */
?>

<?php
if (!empty($valerror)){
    foreach($valerror['chat'] as $error) {
        echo $error. "<br />\n";
    }
} else {
    echo "送信完了";
}
?>
<script>
$(function(){
    setTimeout(function(){
        $(".chat-message").fadeOut('slow');
    },3000);
});
</script>