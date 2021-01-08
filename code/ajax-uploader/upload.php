<?php 
/* print_r($_POST);
print_r($_FILES);
die(); */



require_once('libs/secure_upload.php');
//require_once('ajax-uploader/libs/smush.php');

$options = array(
	'field' => 'uploads',
	'path' => 'upload'
);

$r = secure_upload($options);

// if ($r['success']) {
	// foreach ($r['success'] AS $k => $file) {
		// $o = smush_file($options['path'] . '/' . str_replace('..', '.', $file['filename']));
		
		// f::remove($options['path'] . '/' . str_replace('..', '.', $file['filename']));
		// if ($o && !$o['error']) {
			// $r['success'][$k]['filename'] = $file['filename'] . ' - optimized :' . $o['percent'] . '%';
		// } else {
		// $r['success'][$k]['filename'] = $file['filename'] . ' - ' . print_r($o,true);
		// }
	// }
// }


echo json_encode($r);
//die();
exit;
?>