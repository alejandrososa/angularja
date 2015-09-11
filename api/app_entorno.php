<?php
if(!empty($_SERVER['APP_ENV'])){

    switch ($_SERVER['APP_ENV']) {
        
        case "desarrollo":
            define("ENTORNO", 'config/dev/');
            break;
        case "test":
            define("ENTORNO", 'config/tst/');
            break;
        case "produccion":
            define("ENTORNO", 'config/pro/');
            break;
    }

}else{
    define("ENTORNO", 'config/tst/');
}
