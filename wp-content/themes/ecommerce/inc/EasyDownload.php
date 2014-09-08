<?php

/**
 * @description		  Object for Download of files [Object for Download of files]
 * @since			  May/2004
 * @otherInformation	  Other properties can be added header.  It makes!
 */
class EasyDownload {

  var $ContentType;
  var $ContentLength;
  var $ContentDisposition;
  var $ContentTransferEncoding;
  var $Path;
  var $FileName;
  var $FileNameDown;
  var $FileExtension;

  /**
   * Constructor
   * @access		public	
   */
  function EasyDownload() {
    $this->ContentType = "application/save";
    $this->ContentLength = "";
    $this->ContentDisposition = "";
    $this->ContentTransferEncoding = "";
    $this->Path = "";
    $this->FileName = "";
    $this->FileNameDown = "";
  }

  /**
   * It configures value Header 'ContentType'
   *
   * @access		public
   */
  function setContentType($strValue) {
    $this->ContentType = $strValue;
  }

  /**
   * It configures value Header 'ContentLength' with the size of the informed file
   * @return		void
   * @access		private
   */
  function _setContentLength() {
    $this->ContentLength = filesize($this->Path . "/" . $this->FileName);
  }

  /**
   * It configures value Header 'ContentDisposition' 
   * @access		public
   */
  function setContentDisposition($strValue) {
    $this->ContentDisposition = $strValue;
  }

  /**
   * It configures value Header 'ContentTransferEncoding' 
   * @access		public
   */
  function setContentTransferEncoding($strValue) {
    $this->ContentTransferEncoding = $strValue;
  }

  /**
   * It configures the physical place where the file if finds in the server
   * @access		public
   */
  function setPath($strValue) {
    $this->Path = $strValue;
  }

  /**
   * It configures the real name of the archive in the server
   * @access		public
   */
  function setFileName($strValue) {
    $this->FileName = $strValue;
  }

  function setFileExtension($strValue) {
    $this->FileExtension = $strValue;
  }

  /**
   * Init Download
   * @access		public
   */
  function send() {

    switch ($this->FileExtension) {
      case "pdf":
        $this->ContentType = "application/pdf";
        break;
      case "exe":
        $this->ContentType = "application/octet-stream";
        break;
      case "rar":
      case "zip":
        $this->ContentType = "application/zip";
        break;
      case "txt":
        $this->ContentType = "text/plain";
        break;
      case "doc":
        $this->ContentType = "application/msword";
        break;
      case "xls":
        $this->ContentType = "application/vnd.ms-excel";
        break;
      case "ppt":
        $this->ContentType = "application/vnd.ms-powerpoint";
        break;
      case "gif":
        $this->ContentType = "image/gif";
        break;
      case "png":
        $this->ContentType = "image/png";
        break;
      case "jpeg":
      case "jpg":
        $this->ContentType = "image/jpg";
        break;
      case "mp3":
        $this->ContentType = "audio/mpeg";
        break;
      default:
        $this->ContentType = "application/force-download";
    }
    $this->_setContentLength();
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false); // required for certain browsers
    header("Content-Type: $this->ContentType");
    //quotes to allow spaces in filenames
    header("Content-Disposition: attachment; filename=\"" . $this->FileName . "\";");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . $this->ContentLength);
    readfile($this->Path . '/' . $this->FileName);
  }

}

?>