<?php
if(isset($_GET['path']))
{
    $url = "C:/zamowienia/".$_GET['path'];
    clearstatcache();
    if(file_exists($url))
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($url).'"');
        header('Content-Length: ' . filesize($url));
        header('Pragma: public');
        flush();
        readfile($url,true);
        die();
    }
    else
    {
        echo "File path does not exist.";
    }
}
echo "File path is not defined."
?>