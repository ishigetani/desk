<?php
/**
 * Created by PhpStorm.
 * User: ishigetani
 * Date: 14/01/04
 * Time: 16:05
 */
?>
<script>
<?php echo $this->Js->request(
    array(
        'action' => 'update_check',
    ),
    array(
        'method' => 'get',
        'sync' => true,
        'update' => '#chat-updating',
    )
);
?>
$(function(){
    $("#chat-updated").fadeOut('slow');
});
</script>