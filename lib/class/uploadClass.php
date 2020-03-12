<?
	// # 파일 업로드 클래스
    class upload
    {
        var $file;        // ' 업로드 파일
        var $upload_path;    // ' 파일을 저장할 경로
        var $file_size;        // ' 파일 크기
        var $file_name;        // ' 파일의 이름
        var $file_front_name;    // ' 확장명을 제외한 이름
        var $file_ext_name;    // ' 파일의 확장자
        
        
        // # 클래스 초기화
        // ' $up_file         : 업로드 파일
        // ' $up_file_name    : 업로드 파일의 이름
        // ' $up_file_size    : 업로드 파일의 크기
        // ' $up_save_path    : 업로드할 경로
        function init($up_file, $up_file_name, $up_file_size, $up_save_path)
        {
            $this->file         = $up_file;
            $this->upload_path  = $up_save_path;
            $this->file_name    = $up_file_name;
            $this->file_size    = $up_file_size;

            // ' 파일의 확장자와 이름을 구분한다.
            $this->file_front_name  = $this->cutFileName("name");    // ' 확장자를 제외한 이름
            $this->file_ext_name    = $this->cutFileName("ext");     // ' 파일의 확장자
        }
        

        // # 파일 이름 구분 함수
        // ' $mode="ext"    : 확장자명을 반환해 준다.
        // ' $mode="name"    : 확장자를 제외한 이름을 반환해준다.
        function cutFileName($mode)
        {
            $len = strlen($this->file_name);
            $dot = strpos($this->file_name,".");

            if($mode == "ext")
            {
                return substr($this->file_name,$dot+1,$len);
            }
            else if($mode == "name")
            {
                return substr($this->file_name,0,$dot);
            }
        }

        
        // # 파일의 크기를 제한하는 함수
        // ' $limit_size : 제한할 크기(1024*2000 = 2MB)
        function limitSize($limit_size)
        {
            if($this->file_size > $limit_size)
            {
                return false;
            }
            else
            {
                return true;
            }
        }


        // # 확장자 제한 함수
        // ' $exmode="normal"  ;  : 프로그램 파일 업로드 금지때
        // ' $exmode="img" ;   : 이미지만 업로드 시킬때 
        function limitExt($exmode)
        {
			$fileArray = array('php','php4','asp','exe','html','xhtml','inc','js','shtml','cgi','jsp','xml');
			$imgArray = array('gif','png','jpg','bmp','mp4');

            if($exmode == "normal")
            {
               // if($this->file_ext_name == "php" || $this->file_ext_name == "php4" || $this->file_ext_name == "shtml" || $this->file_ext_name == "cgi"){$this->file_ext_name == "php" || $this->file_ext_name == "php4" || $this->file_ext_name == "exe" || $this->file_ext_name == "asp" ||  $this->file_ext_name == "shtml" || $this->file_ext_name == "cgi" || $this->file_ext_name == "jsp"$this->file_ext_name == "gif" || $this->file_ext_name == "jpg" || $this->file_ext_name == "png"
				   
                if( in_array( strtolower($this->file_ext_name) , $fileArray) ){
					// echo "<script>alert('금지된 파일형식입니다.');</script>" ; return false;
                    return false;
                }
                else{
                    return true;
                }
            }
            else if($exmode == "img")
            {
                if( in_array( strtolower($this->file_ext_name) , $imgArray) ){
                    return true;
                }
                else{
					return false; 
                }
            } 
            else if ($exmode == "xls" or $exmode == "xlsx")
            {
               
                    if($this->file_ext_name == "xls" || $this->file_ext_name == "xlsx")
                    {
                        return true;
                    }
                    else
                    {
                        return false; 
                    }
            }
        }


        // # 파일 중복 체크후 새로운 이름 반환 함수
        // ' $smode = "d" : "날짜형으로 파일이름 반환
        // ' $smode = "c" : "파일이름_숫자"형으로 파일이름 반환        
        function getSaveName($smode)
        {
            if($smode == "d")
            {
                $date = getdate();
				$time_name = $date['year'].$date['mon'].$date['mday'].$date['hours'].$date['minutes'].$date['seconds'];
                $str_name = $time_name.".".$this->file_ext_name;
				
				$i = 0;
				while(file_exists($this->upload_path.$str_name))
                {
                    $str_name = $time_name.$i.".".$this->file_ext_name;
                    $i++;
                }

                return $str_name;
            }
            else if($smode == "c")
            {
                $i = 1;  
                $str_name =  $this->file_front_name.".".$this->file_ext_name;
                while(file_exists($this->upload_path.$str_name))
                {
					$str_name = $this->file_front_name."_".$i.".".$this->file_ext_name;
                    $i++;
                }

                return $str_name;
            }
        }

        // # 원본 파일 이름 반환 함수
        function getFileName()
        {
            return $this->file_name;
        }


        // # 파일 저장 함수
        // ' $save_file_name: 저장할 이름
        function fileSave($save_file_name)
        {
            // 한글 파일 깨짐 방지
            $save_file_name = iconv("UTF-8", "cp949", $save_file_name);

            // 파일 업로드
            copy("$this->file", $this->upload_path.$save_file_name);
            unlink("$this->file");//파일삭제
			//move_uploaded_file ($_FILES['upload']['tmp_name'], "./upload/{$_FILES['upload']['name']}")
        }
    }

?>