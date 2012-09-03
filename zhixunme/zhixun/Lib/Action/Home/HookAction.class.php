<?php
/**
 * Description of HookAction
 *
 * @author moi
 */
class HookAction extends Action{
    public function aedm20120725hook(){
        $count = file_get_contents('Files/edmhook/aedm20120725hook.txt');
        file_put_contents('Files/edmhook/aedm20120725hook.txt' ,++$count);
        header("Content-type: image/png");
        $img = file_get_contents(APP_PATH.'/Theme/default/vocat/imgs/temp/transparent.png');
        echo $img;
    }
}

?>
