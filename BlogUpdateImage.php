<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/BlogInformation.php';

session_start();
if (!isset($_SESSION['admin'])) {
    session_destroy();
    header("HTTP/1.1 500 Unauthorized");
    exit;
} else if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
    if (getUserExpiresTime($_SESSION['userID']) < time()) {
        session_destroy();
        header("HTTP/1.1 500 Unauthorized");
        exit;
    }
}
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");



if (isset($_POST['blog_id'])) {
	if(!file_exists("images/blog/"))
	{
		mkdir("images/blog/");
	}
    $blogid = $_POST['blog_id'];
	$blog = getBlogEntryByID($blogid);
	if($blog->image != null)
	{
		unlink($blog->image);
		removeBlogImageUrl($blog);
	}
	$target_dir = "images/blog/" . getToken(16);
	$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $path_parts = pathinfo($_FILES["file"]["name"]);
    $extension = $extension = $path_parts['extension'];
    $target_file = $target_dir . "." . $extension;
    $uploadOk = 1;
    //echo $target_file;
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check == false) {
        $uploadOk = 0;
        $errorReason = "not an image.";
    }
    if (file_exists($target_file)) {
        unlink($target_file);
    }
    if ($_FILES["file"]["size"] > 5000000) {
        $uploadOk = 0;
        $errorReason = "image was too large.";
    }
    $allowableExtensions = array("jpeg", "jpg", "png", "PNG", "JPG", "JPEG");
    if (!in_array($extension, $allowableExtensions)) {
        $uploadOk = 0;
        $errorReason = "image has a bad extension.";
    }
    if ($uploadOk == 0) {
        header("HTTP/1.1 500 Failed to upload");
        exit;
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        } else {
            $uploadOK = 0;
            $errorReason = "Could Not Move image.";
        }
    }
    updateBlogImageUrl($blog, $target_file);
    header("HTTP/1.1 200 OK");
    exit;
} else {
    header("HTTP/1.1 500 Failed to upload");
    exit;
}
