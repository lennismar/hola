<?php
include 'includes/config.php';
$debug = false;

echo '<h2>Trasladando fotos de establecimientos</h2>';

$db -> where("filename not like '%/%'");
$db -> orderBy("eid", "ASC");
$photos = $db -> get("establiments_images", 10);
if ($db->count > 0) {
    echo 'Moviendo un total de '.$db->count.' imagenes<br/>';

    foreach ($photos as $photo) {
        echo '<br>'.$photo['filename'].' de '.$photo['eid'];
        $ok = true; $actualizacion = false;
        if(!file_exists(FILE_DIR.'establiments/'.$photo['filename'])) { echo '<br>Foto no existe'; continue;}
        if(!file_exists(FILE_DIR.'establiments/'.$photo['eid'])) $ok = mkdir(FILE_DIR.'establiments/'.$photo['eid'], 0775);

        if($ok) {
            $movimiento = rename(FILE_DIR.'establiments/'.$photo['filename'], FILE_DIR.'establiments/'.$photo['eid'].'/'.$photo['filename']);
            if($movimiento) {
                $db->where ('filename', $photo['filename']);
                $actualizacion = $db->update ('establiments_images', array('filename' => $photo['eid'].'/'.$photo['filename']));
            }
        }
        if($actualizacion) echo '<br> Movido a '.$photo['eid'].'/'.$photo['filename'];
    }
}
