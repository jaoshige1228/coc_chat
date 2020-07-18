<?php

namespace MyApp\Controller;

class ImageUploader extends \MyApp\Controller {
  private $_imageFileName;
  private $_imageType;

    public function upload() {
      if(isset($_POST['imageUpload']) && $_POST['imageUpload'] == 'go'){
        $name = $_SESSION['me']->name;
        $charName = $_SESSION['charName'];
        $charId = $_SESSION['charId'];
        try {
          // error check
          $this->_validateUpload();
    
          // type check
          $ext = $this->_validateImageType();
          // var_dump($ext);
          // exit;
    
          // save
          $savePath = $this->_save($ext,$name,$charName);
    
          // create thumbnail
          $this->_createThumbnail($savePath);

          // 画像を取得
          $image = $this->_getImages($name,$charName);

          // var_dump($image);
          
          // 画像をデータベースに格納
          $data = new \MyApp\Model\Char();
          $data->uploadIcon($image,$charId);
          
          return $image;
          
          header('Location: myChar.php');
        } catch (\Exception $e) {
          echo $e->getMessage();
          exit;
        }
        // redirect
        // exit;
      }
    }

  // 画像を取得
  private function _getImages($name,$charName) {
    $images = [];
    $files = [];
    $imageDir = opendir(THUMBNAIL_DIR);
    // var_dump(readdir($imageDir));
    while (false !== ($file = readdir($imageDir))) {
      if ($file === '.' || $file === '..') {
        continue;
      }
      $files[] = $file;
      $images[] = basename(THUMBNAIL_DIR) . '/' . $file;
    }
    array_multisort($files, SORT_DESC, $images);

    // 画像名にユーザー名とキャラ名が含まれているものを抽出し、配列に格納
    $myImages = [];
    foreach($images as $image){
      if(strpos($image,$name) !== false && strpos($image,$charName) !== false){
        $myImages[] = $image;
      }else{
        // echo '無念！';
      }
    }

    if(isset($myImages[0])){
      // 最新の画像だけを抽出
      $res = $myImages[0];
      foreach($myImages as $myImage){
        if($myImage == $res){
          continue;
        }else if(unlink($myImage) !== false){
          echo '削除！！！';
        }else{
          echo '失敗だ';
        }
      }
      return $res;
    }

  }

  private function _createThumbnail($savePath) {
    $imageSize = getimagesize($savePath);
    $width = $imageSize[0];
    $height = $imageSize[1];
    // if ($width > THUMBNAIL_WIDTH || $height > THUMBNAIL_HEIGHT) {
      $this->_createThumbnailMain($savePath, $width, $height);
    // }
  }

  private function _createThumbnailMain($savePath, $width, $height) {
    switch($this->_imageType) {
      case IMAGETYPE_GIF:
        $srcImage = imagecreatefromgif($savePath);
        break;
      case IMAGETYPE_JPEG:
        $srcImage = imagecreatefromjpeg($savePath);
        break;
      case IMAGETYPE_PNG:
        $srcImage = imagecreatefrompng($savePath);
        break;
    }
    // $thumbHeight = round($height * THUMBNAIL_WIDTH / $width);
    // $thumbImage = imagecreatetruecolor(THUMBNAIL_WIDTH, $thumbHeight);
    $thumbImage = imagecreatetruecolor(THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
    imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT, $width, $height);

    switch($this->_imageType) {
      case IMAGETYPE_GIF:
        imagegif($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        break;
      case IMAGETYPE_JPEG:
        imagejpeg($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        break;
      case IMAGETYPE_PNG:
        imagepng($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        break;
    }

  }

  private function _save($ext,$name,$charName) {
    $this->_imageFileName = sprintf(
      '%s_%s_%s_%s.%s',
      $name,
      $charName,
      time(),
      sha1(uniqid(mt_rand(), true)),
      $ext
    );
    $savePath = IMAGES_DIR . '/' . $this->_imageFileName;
    // テストはじめ


    // テスト終了
    $res = move_uploaded_file($_FILES['image']['tmp_name'], $savePath);
    if ($res === false) {
      throw new \Exception('Could not upload!');
    }
    return $savePath;
  }

  private function _validateImageType() {
    $this->_imageType = exif_imagetype($_FILES['image']['tmp_name']);
    switch($this->_imageType) {
      case IMAGETYPE_GIF:
        return 'gif';
      case IMAGETYPE_JPEG:
        return 'jpg';
      case IMAGETYPE_PNG:
        return 'png';
      default:
        throw new \Exception('PNG/JPEG/GIF only!');
    }
  }

  private function _validateUpload() {
    // var_dump($_FILES);
    // exit;

    if (!isset($_FILES['image']) || !isset($_FILES['image']['error'])) {
      throw new \Exception('Upload Error!');
    }

    switch($_FILES['image']['error']) {
      case UPLOAD_ERR_OK:
        return true;
      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE:
        throw new \Exception('File too large!');
      default:
        throw new \Exception('Err: ' . $_FILES['image']['error']);
    }

  }

}