<?php
$logs = [];
$logs[] = $_FILES;

function parseFileSize(int $size):string
{
    $newSize = $size / 1024;
    if($newSize < 1100) {
        return round($newSize, 2) . ' KB';
    }

    $newSize = $newSize / 1024;
    return round($newSize, 2) . ' MB';
}

$fileKey = 'fileUpload';
$uploaded = $_FILES[$fileKey] ?? false;

if($uploaded) {
    $dest = 'C:/Users/c_sobey/Documents/personal-scripts/upload-files/';

    $logs[] = 'uploaded a file';
    $logs[] = 'uploaded filename "' . $uploaded['name'] . '" - ' . $uploaded['type'] . ', ' . parseFileSize($uploaded['size']);
    $logs[] = 'temporary location "' . $uploaded['tmp_name'] . '"';

    $destfile = $dest . $uploaded['name'];
    move_uploaded_file($uploaded['tmp_name'], $destfile);
    usleep(50);
    
    $logs[] = file_exists($destfile)
        ? 'File successfully moved to "' . $destfile . '"'
        : 'Unable to move file';
}

?>
<main class='main'>
    <h1>Upload</h1>
    <form action='' method='post' enctype='multipart/form-data'>
        <p>
            <label>Select image</label>
            <input type='file' name='<?=$fileKey;?>' />
        </p>
        <p>
            <button type='submit'>Send</button>
        </p>
    </form>

    <hr/>
    <h2>Logs</h2>
    <pre><?=var_export($logs);?></pre>
</main>
