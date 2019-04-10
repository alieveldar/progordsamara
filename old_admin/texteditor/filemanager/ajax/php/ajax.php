<?php
header('Expires: Sun, 13 Sep 2009 00:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache') ;

define('DEV', false); if (DEV) { 	error_reporting(E_ALL); 	ini_set('display_errors', 'on'); 	ini_set('display_startup_errors', 'on'); } else { 	error_reporting(0); 	ini_set('display_errors', 'off'); 	ini_set('display_startup_errors', 'off'); }

//if (!isset($_SESSION['admin'])) {exit;}

define('DIR_SEP', '/');
mb_internal_encoding('utf-8');
date_default_timezone_set('Europe/Moscow');
$cfg['url']	= 'userfiles/images';
$cfg['root']	= $_SERVER['DOCUMENT_ROOT'] . DIR_SEP . $cfg['url'];
$cfg['quickdir'] = '';	
$cfg['lang']	= 'ru';
$cfg['thumb']['width'] 	= 100;
$cfg['thumb']['height']	= 70;
$cfg['thumb']['quality']	= 50;
$cfg['thumb']['cut']		= true;
$cfg['thumb']['auto']	= true;
$cfg['thumb']['dir']		= 'preview';
$cfg['thumb']['date']	= "j.m.Y, H:i";
$cfg['hide']['file']	= array('.htaccess');
$cfg['hide']['folder']	= array('.', '..', $cfg['thumb']['dir'], '.svn', '.cvs');
$cfg['chmod']['file']		= 0777;
$cfg['chmod']['folder']	= 0777;

$cfg['deny'] = array(
	'file'		=> array('php','php3','php4','php5','phtml','asp','aspx','ascx','jsp','cfm','cfc','pl','bat','exe','dll','reg','cgi'),
	'flash'	=> array(),
	'image'	=> array(),
	'media'	=> array(),
	'folder'	=> array($cfg['url'] . DIR_SEP . 'file', $cfg['url'] . DIR_SEP . 'flash', $cfg['url'] . DIR_SEP . 'image-'.date("m-Y"), $cfg['url'] . DIR_SEP . 'media')
);

$cfg['allow'] = array(
	'file'		=> array('doc', 'fla', 'flv', 'gif', 'gz', 'gzip', 'jpeg', 'jpg', 'mp3', 'rar', 'wmv', 'xls', 'zip'),
	'flash'		=> array('swf', 'flv', 'mp4'),
	'image'	=> array('jpg', 'jpeg', 'gif', 'png', 'bmp'),
	'media'	=> array('avi', 'fla', 'flv', 'gif', 'jpeg', 'jpg', 'mp3', 'mp4',  'mpeg')
);

$cfg['nameRegAllow'] = '/^[a-z0-9-_#~\$%()\[\]&=]+/i';
$cfg['url']	= trim($cfg['url'], '/\\');
$cfg['root']	= rtrim($cfg['root'], '/\\') . DIR_SEP;
$dir = isset($_POST['dir'])? urldecode($_POST['dir']) : '';
$dir = trim($dir, '/\\') . DIR_SEP;
$rpath = str_replace('\\', DIR_SEP, realpath($cfg['root'] . $dir) . DIR_SEP);
if (false === strpos($rpath, str_replace('\\', DIR_SEP, $dir))) {$dir = '';}
$mode = isset($_GET['mode'])? $_GET['mode'] : 'getDirs';
$cfg['type']	= isset($_POST['type'])? $_POST['type'] : (isset($_GET['type']) && 'QuickUpload' == $mode? $_GET['type'] : 'file');
$cfg['sort']	= isset($_POST['sort'])? $_POST['sort'] : 'name';
$cfg['type'] = strtolower($cfg['type']);
$reply = array(	'dirs'		=> array(), 	'files'		=> array() );

require_once 'lib.php';

switch($mode) {
	case 'cfg':
		$rootDir = listDirs('');
		$children = array();
		for ($i=-1, $iCount=count($rootDir); ++$i<$iCount;) {
			$children[] = (object) $rootDir[$i];
		}

		$reply['config'] = array(
			'lang'		=> $cfg['lang'],
			'type'		=> $cfg['type'],
			'url'		=> '/' . $cfg['url'] . '/',
			'thumb'	=> $cfg['thumb']['dir'],
			'thumbWidth'	=> $cfg['thumb']['width'],
			'thumbHeight'	=> $cfg['thumb']['height'],
			'maxUpload' => ini_get('upload_max_filesize'),
			'allow'		=> implode('|', $cfg['allow'][$cfg['type']]),
			'children'	=> $children
		);
		break;

	case 'renameFile':
		$file = trim(urldecode($_POST['oldname']), '/\\.');
		$name = urldecode($_POST['newname']);

		if ($file != $name && preg_match($cfg['nameRegAllow'], $name) && file_exists($cfg['root']) . $dir . $file) {
			if (file_exists($_thumb = $cfg['root'] . $cfg['thumb']['dir'] . DIR_SEP . $dir . DIR_SEP . $file)) {
				unlink($_thumb);
			}
			if (file_exists($cfg['root'] . $dir . $name)) {
				$name = getFreeFileName($name, $cfg['root'] . $dir);
			}
			if (false !== strpos($name, '.')) {
				$ext = substr($name, strrpos($name, '.') + 1);
				if (in_array($ext, $cfg['allow']['image'])) {
					rename($cfg['root'] . $dir . $file, $cfg['root'] . $dir . $name);
				}
			}
		}

		$reply['files'] = listFiles($dir);
		break;

	case 'createFolder':
		$path = trim(urldecode($_POST['oldname']), '/\\.');
		$name = urldecode($_POST['newname']);

		$reply['isSuccess'] = false;
		if (preg_match($cfg['nameRegAllow'], $name)) {
			if (!file_exists($cfg['root'] . $path . DIR_SEP . $name)) {
				$reply['isSuccess'] = mkdir($cfg['root'] . $path . DIR_SEP . $name, $cfg['chmod']['folder']);
			} else {
				$reply['isSuccess'] = 'exist';
			}
		}
		break;

	case 'renameFolder':
		$folder	= urldecode($_POST['oldname']);
		$name	= urldecode($_POST['newname']);
		$folder	= trim($folder, '/\\.');

		$reply['isSuccess'] = false;
		if (!empty($folder) && $cfg['url'] != $folder && $folder != $name && !in_array($cfg['url'] . DIR_SEP . $folder, $cfg['deny']['folder']) && preg_match($cfg['nameRegAllow'], $name) && is_dir($cfg['root']) . $folder) {
			$reply['isSuccess'] = rename($cfg['root'] . $folder, $cfg['root'] . substr($folder, 0, strrpos($folder, '/')) . DIR_SEP . $name);
		}
		break;

	case 'deleteFolder':
		$reply['isDelete'] = false;
		$folder = trim($dir, '/\\');

		if (!empty($folder) && $cfg['url'] != $folder && !in_array($cfg['url'] . DIR_SEP . $folder, $cfg['deny']['folder'])) {
			deleteDir($cfg['root'] . $cfg['thumb']['dir'] . DIR_SEP. $folder);
			$reply['isDelete'] = deleteDir($cfg['root'] . $folder);
		}
		break;

	case 'uploads':
		$reply['downloaded'] = array();
		$width	= isset($_POST['resizeWidth'])? intval($_POST['resizeWidth']) : 0;
		$height	= isset($_POST['resizeHeight'])? intval($_POST['resizeHeight']): 0;

		$key = 'uploadFiles';
		if (!empty($dir) && '/' != $dir && !empty($_FILES[$key])) {
			for ($i=-1, $iCount=count($_FILES[$key]['name']); ++$i<$iCount;) {
				$ext = substr($_FILES[$key]['name'][$i], strrpos($_FILES[$key]['name'][$i], '.') + 1);
				if (!in_array($ext, $cfg['deny'][$cfg['type']]) && in_array($ext, $cfg['allow'][$cfg['type']])) {
					$freeName = getFreeFileName($_FILES[$key]['name'][$i], $cfg['root'] . $dir);
					if (in_array($ext, $cfg['allow']['image'])) {
						if ($width || $height) {
							create_thumbnail($_FILES[$key]['tmp_name'][$i], $cfg['root'] . $dir . $freeName, $width, $height, 100, false, true);
							chmod($cfg['root'] . $dir . $freeName, $cfg['chmod']['file']);
						} else {
							if (move_uploaded_file($_FILES[$key]['tmp_name'][$i], $cfg['root'] . $dir . $freeName)) {
								chmod($cfg['root'] . $dir . $freeName, $cfg['chmod']['file']);
								if ($cfg['thumb']['auto']) {
									create_thumbnail($cfg['root'] . $dir . $freeName, $cfg['root'] . $cfg['thumb']['dir'] . DIR_SEP . $dir . DIR_SEP. $freeName);
									chmod($cfg['root'] . $cfg['thumb']['dir'] . DIR_SEP . $dir . DIR_SEP. $freeName, $cfg['chmod']['file']);
								}
								$reply['downloaded'][] = array(true, $freeName);
							} else {
								$reply['downloaded'][] = array(false, $freeName);
							}
						}
					} else {
						if (move_uploaded_file($_FILES[$key]['tmp_name'][$i], $cfg['root'] . $dir . $freeName)) {
							chmod($cfg['root'] . $dir . $freeName, $cfg['chmod']['file']);
							$reply['downloaded'][] = array(true, $freeName);
						} else {
							$reply['downloaded'][] = array(false, $freeName);
						}
					}
				} else {
					$reply['downloaded'][] = array(false, $_FILES[$key]['name'][$i]);
				}
			}
		}
		break;

	case 'QuickUpload':
		switch ($cfg['type']) {
			case 'file':
			case 'flash':
			case 'image':
			case 'media':
				$dir = $cfg['type']."-".date("m-Y");
				break;
			default:
				exit;		//	exit	for not supported type
				break;
		}
		if (!is_dir($toDir = $cfg['root'] . $dir . DIR_SEP . $cfg['quickdir'])) {
			mkdirs($toDir, $cfg['chmod']['folder']);
		}

		if (0 == ($_FILES['upload']['error'])) {
			$fileName = getFreeFileName($_FILES['upload']['name'], $toDir);
			$ext = substr($fileName, strrpos($fileName, '.') + 1);
			$ext = strtolower($ext);
			if (!in_array($ext, $cfg['deny'][$cfg['type']]) && in_array($ext, $cfg['allow'][$cfg['type']]) && move_uploaded_file($_FILES['upload']['tmp_name'], $toDir . DIR_SEP . $fileName)) {
				$funcNum = isset($_GET['CKEditorFuncNum'])? intval($_GET['CKEditorFuncNum']) : 2;
				$result = "<script type=\"text/javascript\">window.parent.CKEDITOR.tools.callFunction(" . $funcNum . ", '/". $cfg['url'] . '/' . $dir . '/' . (empty($cfg['quickdir'])? '' : trim($cfg['quickdir'], '/\\') . '/') . $fileName."', '');</script>";
			}
		}

		exit($result);
		break;

	case 'deleteFiles':
		$files = urldecode($_POST['files']);
		$files = explode('::', $files);
		for ($i=-1, $iCount=count($files); ++$i<$iCount;) {
			unlink($cfg['root'] . $dir . $files[$i]);
			file_exists($_thumb = $cfg['root'] . $cfg['thumb']['dir']  . DIR_SEP. $dir . DIR_SEP . $files[$i])? unlink($_thumb): null;
		}

		$reply['files'] = listFiles($dir);
		break;

	case 'getFiles':
		$reply['files'] = listFiles($dir);
		break;

	case 'getDirs':
		$reply['dirs'] = listDirs($dir);
		break;

	default:
		exit;
		break;
}

if (isset($_GET['noJson'])) {echo'<pre>';print_r($reply);echo'</pre>';exit;}
exit( json_encode( $reply ) );