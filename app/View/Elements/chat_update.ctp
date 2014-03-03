<?php
/**
 * Created by PhpStorm.
 * User: ishigetani
 * Date: 14/01/04
 * Time: 16:05
 */
?>
<script>
    $(function(){
        setInterval(function(){
            <?php echo $this->Js->request(
                array(
                    'action' => 'update_check',
                ),
                array(
                    'method' => 'get',
                    'async' => true,
                    'update' => '#chat-updating',
                )
            );
            ?>
        }, <?php echo UPDATE_TIME; ?>);
    });
</script>