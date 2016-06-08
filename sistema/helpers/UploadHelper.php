<?php
	class UploadHelper {
		protected $path = UPLOADS, $file, $fileName, $fileTmpName;
		
		public function setPath($path) {
			$this->path = $path;
		}
		
		public function setFile($file) {
			$this->file = $file;
			$this->setFileName();
			$this->setFileTmpName();
		}
		
		public function setFileName($file) {
			$this->fileName = $this->file['name'];
		}
		
		public function setFileTmpName($file) {
			$this->fileTmpName = $this->file['tmp_name'];
		}
		
		public function upload() {
			if(move_uploaded_file($this->fileTmpName, PATH . $this->path . $this->fileName)) {
				return TRUE;
			}
			else {
				return FALSE;
			}
		}
	}
?>