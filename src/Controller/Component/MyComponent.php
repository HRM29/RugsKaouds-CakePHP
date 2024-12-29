<?php
namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Cake\Core\Configure;
use Cake\Network\Email\Email;
use Cake\Utility\Security;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;






class MyComponent extends Component
{


    function random_password( $length = 8 ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }

    /* function uploadfile($fileData,$folder,$thumb_required = true){
		
		$tmpFile = $fileData['tmp_name'];
		
        $fileName = rand()."_".str_replace(" ", "_",$fileData['name']);
        $filePath =  WWW_ROOT . 'uploads' . DS . $folder.DS.$fileName;
		 
		move_uploaded_file($tmpFile, $filePath);
		
		if($thumb_required){
			$filePathThumb =  WWW_ROOT . 'uploads' . DS . $folder . DS ."thumb".DS.$fileName;
			$this->createThumb($fileName,$filePathThumb,$tmpFile,200,200);
		}

        return $fileName;
    } */
	
	/* function uploadPdfFile($fileData,$folder){

        $tmpFile = $fileData['tmp_name'];
        $fileName = rand()."_".str_replace(" ", "_",$fileData['name']);
        $filePath =  WWW_ROOT . 'uploads' . DS . $folder.DS.$fileName;
        move_uploaded_file($tmpFile, $filePath);
        return $fileName;
    }
 */
	function uploadfile($fileData,$folder,$is_fix=null,$fix_type=null){
		
		
		$tmpFile = $fileData['tmp_name'];
        $fileName = rand()."_".str_replace(" ", "_",$fileData['name']);
        $filePath =  WWW_ROOT . 'uploads' . DS . $folder.DS.$fileName;
        $filePathThumb =  WWW_ROOT . 'uploads' . DS . $folder . DS ."thumb".DS;
	//	$array=$tmpFile->getImageResolution();
		if($is_fix==1){
			list($width, $height) = getimagesize($tmpFile);
			 
			if($fix_type=='banner'){
				/* if($width<1300){
					 
					return 1; exit;
				}
				else if($height<350){
					return 2; exit;
				} */
			} 
		}
		 
        $this->createThumbnail($fileName,200,200,$tmpFile,$filePathThumb);
		
        move_uploaded_file($tmpFile, $filePath);
		  
        return $fileName;
    }
    
    
    function uploadProductImg($fileData,$sku_no,$folder){
		
		$sku_no = preg_replace("/[^0-9]/", '', $sku_no);
		
		$imgFolder = $this->get_picture_folder($sku_no);
		
		if(!file_exists(WWW_ROOT . 'uploads' . DS . $folder.DS.$imgFolder)){
			mkdir(WWW_ROOT . 'uploads' . DS . $folder.DS.$imgFolder);
		}
		
		$tmpFile = $fileData['tmp_name'];
        $fileName = $fileData['name'];
        $filePath =  WWW_ROOT . 'uploads' . DS . $folder.DS.$imgFolder.DS.$fileName;
         
        move_uploaded_file($tmpFile, $filePath);
		  
        return $fileName;
    }
	
	
	function get_picture_folder($rug_code)
	{
		$rug_number = 1*($rug_code);
		$group = floor($rug_number /500);
		$start = $group * 500;
		$end = ($group + 1) * 500 - 1;
		$folder = $start ."-".$end."/";
		return $folder;
	}
	
	
	function uploadPdfFile($fileData,$folder){

        $tmpFile = $fileData['tmp_name'];
        $fileName = rand()."_".str_replace(" ", "_",$fileData['name']);
        $filePath =  WWW_ROOT . 'uploads' . DS . $folder.DS.$fileName;
        move_uploaded_file($tmpFile, $filePath);
        return $fileName;
    }

    function createThumbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir)
    {
        $path = $uploadDir;
        $mime = getimagesize($path);
		if(!empty($mime))
		{
			if($mime['mime']=='image/png'){ $src_img = imagecreatefrompng($path); }
			if($mime['mime']=='image/jpg'){ $src_img = imagecreatefromjpeg($path); }
			if($mime['mime']=='image/jpeg'){ $src_img = imagecreatefromjpeg($path); }
			if($mime['mime']=='image/pjpeg'){ $src_img = imagecreatefromjpeg($path); }

			$old_x          =   imageSX($src_img);
			$old_y          =   imageSY($src_img);

			if($old_x > $old_y)
			{
				$thumb_w    =   $new_width;
				$thumb_h    =   $old_y*($new_height/$old_x);
			}

			if($old_x < $old_y)
			{
				$thumb_w    =   $old_x*($new_width/$old_y);
				$thumb_h    =   $new_height;
			}

			if($old_x == $old_y)
			{
				$thumb_w    =   $new_width;
				$thumb_h    =   $new_height;
			}

			$dst_img        =   ImageCreateTrueColor($thumb_w,$thumb_h);

			imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);


			// New save location
			$new_thumb_loc = $moveToDir . $image_name;

			if($mime['mime']=='image/png'){ $result = imagepng($dst_img,$new_thumb_loc,8); }
			if($mime['mime']=='image/jpg'){ $result = imagejpeg($dst_img,$new_thumb_loc,80); }
			if($mime['mime']=='image/jpeg'){ $result = imagejpeg($dst_img,$new_thumb_loc,80); }
			if($mime['mime']=='image/pjpeg'){ $result = imagejpeg($dst_img,$new_thumb_loc,80); }

			imagedestroy($dst_img);
			imagedestroy($src_img);

			return $result;
		}
    } 
	public function customerList(){
	    $customer = [];
		$customerTable = TableRegistry::get('Users');
        $query = $customerTable->find('list', [
        'keyField' => 'id',
        'valueField' => 'first_name'])->where(['status' => 1,'role_id' => 3,])->order(['first_name' => 'ASC']);
        $customer = $query->all();
    
        return json_encode($customer);
        exit;
	}
	
	
	public function taxesList(){
		$taxes = [];
		$taxesTable = TableRegistry::get('Taxes');
        $taxes = $taxesTable->find('all')->where(['status' => 1])->order(['title' => 'ASC'])->toArray();
		return $taxes;
	}
	
	/**
    * @brands List 
    *
    * @throws MethodNotAllowedException
    * @throws NotFoundException
    * @param integer $id
    * @return void
    */
	
	public function BrandList(){
		$Table = TableRegistry::get('brands');
        $query = $Table->find('list', [
        'keyField' => 'id',
        'valueField' => 'title'])->where(['status' => 1])->order(['title' => 'ASC']);
        $brands = $query->all();
    
        return json_encode($brands);
        exit;
    }
	
	/**
    * @category List 
    *
    * @throws MethodNotAllowedException
    * @throws NotFoundException
    * @param integer $id
    * @return void
    */
	
	public function CategoryList(){
		$Table = TableRegistry::get('categories');
        $query = $Table->find('list', [
        'keyField' => 'id',
        'valueField' => 'title'])->where(['status' => 1])->order(['title' => 'ASC']);
        $category = $query->all();
    
        return json_encode($category);
        exit;
    }
	
	/**
    * @colours List 
    *
    * @throws MethodNotAllowedException
    * @throws NotFoundException
    * @param integer $id
    * @return void
    */
	
	public function ColorList(){
		$Table = TableRegistry::get('colors');
        $query = $Table->find('list', [
        'keyField' => 'id',
        'valueField' => 'name'])->where(['status' => 1])->order(['name' => 'ASC']);
        $colours = $query->all();
    
        return json_encode($colours);
        exit;
    }
	
	/**
    * @SizeList List 
    *
    * @throws MethodNotAllowedException
    * @throws NotFoundException
    * @param integer $id
    * @return void
    */
	
	public function FoundationsList(){
		$Table = TableRegistry::get('Foundations');
        $query = $Table->find('list', [
        'keyField' => 'id',
        'valueField' => 'title'])->where(['status' => 1])->order(['title' => 'ASC']);
        $foundations = $query->all();
    
        return json_encode($foundations);
        exit;
    }
	
	/**
    * @SizeList List 
    *
    * @throws MethodNotAllowedException
    * @throws NotFoundException
    * @param integer $id
    * @return void
    */
	
	public function Pile(){
		$Table = TableRegistry::get('Piles');
        $query = $Table->find('list', [
        'keyField' => 'id',
        'valueField' => 'title'])->where(['status' => 1])->order(['title' => 'ASC']);
        $piles = $query->all();
    
        return json_encode($piles);
        exit;
    }
	
	/**
    * @SizeList List 
    *
    * @throws MethodNotAllowedException
    * @throws NotFoundException
    * @param integer $id
    * @return void
    */
	
	public function SizeList(){
		$Table = TableRegistry::get('sizes');
        $query = $Table->find('list', [
        'keyField' => 'id',
        'valueField' => 'size'])->where(['status' => 1]);
        $sizes = $query->all();
    
        return json_encode($sizes);
        exit;
    }
	public function dimensionList(){
		$Table = TableRegistry::get('Dimensions');
        $query = $Table->find('list', [
        'keyField' => 'id',
        'valueField' => 'term'])->where(['status' => 1]);
        $sizes = $query->all();
    
        return json_encode($sizes);
        exit;
    }
	public function SubCategoryList($cat_id){
		if(!empty($cat_id)){
			$Table = TableRegistry::get('SubCategories');
			$query = $Table->find('list', [
			'keyField' => 'id',
			'valueField' => 'title'])->where(['status' => 1,'parent_id'=>$cat_id])->order(['title' => 'ASC']);
			$sub_category = $query->all();
		}
		return json_encode($sub_category);
		exit;
	}
	
	
	public function isLogin(){
		$session = $this->request->session();
		$loginuserId = $session->read('Auth.customer.id');
		$is_login    = $session->read('Auth.customer.is_login');
		
		if(empty($loginuserId) && $is_login != 1){
			$this->_registry->getController()->redirect('/users/login');
		}
	}
    public function verifyImage($image) {
        // Validate that the file is uploaded
        if (empty($image['name'])) {
            return ['error' => 'No file uploaded.'];
        }

        // Get file details
        $filePath = $image['tmp_name'];
        $fileName = $image['name'];
        $fileSize = $image['size'];
        $fileType = $image['type'];

        // Validate image type (can be customized for more formats)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($fileType, $allowedTypes)) {
            return ['error' => 'Invalid file type. Allowed types: JPEG, PNG, GIF.'];
        }

        // Validate image size (e.g., limit to 5MB)
        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($fileSize > $maxSize) {
            //return ['error' => 'File size exceeds the maximum limit of 5MB.'];
        }

        // Check if the file is a valid image using getimagesize()
        $imageSize = getimagesize($filePath);
        if ($imageSize === false) {
            return ['error' => 'Uploaded file is not a valid image.'];
        }

        // If all validations pass
        return ['success' => 'Image is valid.', 'image_info' => $imageSize];
    }
}