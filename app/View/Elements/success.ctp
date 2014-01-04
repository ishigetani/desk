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
    foreach($valerror as $error) {
        echo $error. "<br />\n";
    }
} else {
    echo "送信完了";
    ?>
    <script>
        $(function(){
            $('#chat-message').val("");
            setTimeout(function(){
                $(".chat-reply").fadeOut('slow');
            },2000);
        });
    </script>
<?php
}
?>
