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

    function uploadfile($fileData,$folder,$thumb_required=true){
		
		$tmpFile = $fileData['tmp_name'];
		//pr($tmpFile);
		
        $fileName = rand()."_".str_replace(" ", "_",$fileData['name']);
        $filePath =  WWW_ROOT . 'uploads' . DS . $folder.DS.$fileName;
		 
		move_uploaded_file($tmpFile, $filePath);
		
		if($thumb_required){
			$filePathThumb =  WWW_ROOT . 'uploads' . DS . $folder . DS ."thumb".DS.$fileName;
			$this->createThumb($fileName,$filePathThumb,$tmpFile,200);
		}

        return $fileName;
    }
	
	function uploadPdfFile($fileData,$folder){

        $tmpFile = $fileData['tmp_name'];
        $fileName = rand()."_".str_replace(" ", "_",$fileData['name']);
        $filePath =  WWW_ROOT . 'uploads' . DS . $folder.DS.$fileName;
        move_uploaded_file($tmpFile, $filePath);
        return $fileName;
    }

	function createThumb($src, $dest,$tmpFile, $desired_width = false, $desired_height = false) {
		 
		/* If no dimenstion for thumbnail given, return false */    
		if (!$desired_height && !$desired_width)
			return false;
		
		$fparts = pathinfo($src);
		
		
		$ext = strtolower($fparts['extension']);
		
		/* if its not an image return false */
		if (!in_array($ext, array(
				'gif',
				'jpg',
				'png',
				'jpeg'
			)))
			return false;

		/* read the source image */
		if ($ext == 'gif')
			$resource = imagecreatefromgif($tmpFile);
		else if ($ext == 'png')
			$resource = imagecreatefrompng($tmpFile);
		else if ($ext == 'jpg' || $ext == 'jpeg')
			$resource = imagecreatefromjpeg($tmpFile);

		$width = imagesx($resource);
		$height = imagesy($resource);
		
		/* find the “desired height” or “desired width” of this thumbnail, relative
		 * to each other, if one of them is not given */
		if (!$desired_height)
			$desired_height = floor($height * ($desired_width / $width));
		
		if (!$desired_width)
			$desired_width = floor($width * ($desired_height / $height));

		/* create a new, “virtual” image */
		$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
		
		switch ($ext)
		{
		case "png":
			// integer representation of the color black (rgb: 0,0,0)
			$background = imagecolorallocate($virtual_image, 0, 0, 0);
			
			// removing the black from the placeholder
			imagecolortransparent($virtual_image, $background);

			// turning off alpha blending (to ensure alpha channel information 
			// is preserved, rather than removed (blending with the rest of the 
			// image in the form of black))
			imagealphablending($virtual_image, false);

			// turning on alpha channel information saving (to ensure the full range 
			// of transparency is preserved)
			imagesavealpha($virtual_image, true);

			break;
		case "gif":
			// integer representation of the color black (rgb: 0,0,0)
			$background = imagecolorallocate($virtual_image, 0, 0, 0);
			
			// removing the black from the placeholder
			imagecolortransparent($virtual_image, $background);

			break;
		}

		/* copy source image at a resized size */
		imagecopyresampled($virtual_image, $resource, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

		/* create the physical thumbnail image to its destination */
		/* Use correct function based on the desired image type from $dest thumbnail
		 * source */
		$fparts = pathinfo($dest);
		$ext = strtolower($fparts['extension']);
		/* if dest is not an image type, default to jpg */
		if (!in_array($ext, array(
				'gif',
				'jpg',
				'png',
				'jpeg'
			)))
			$ext = 'jpg';
		$dest = $fparts['dirname'] . '/' . $fparts['filename'] . '.' . $ext;

		if ($ext == 'gif')
			imagegif($virtual_image, $dest);
		else if ($ext == 'png')
			imagepng($virtual_image, $dest, 1);
		else if ($ext == 'jpg' || $ext == 'jpeg')
			imagejpeg($virtual_image, $dest, 100);

		return array(
			'width' => $width,
			'height' => $height,
			'new_width' => $desired_width,
			'new_height' => $desired_height,
			'dest' => $dest
		);
	}
    
	public function customerList(){
		$customerTable = TableRegistry::get('Users');
        $query = $customerTable->find('list', [
        'keyField' => 'id',
        'valueField' => 'full_name'])->where(['status' => 1,'role_id' => 2,])->order(['full_name' => 'ASC']);
        $customer = $query->all();
    
        return json_encode($customer);
        exit;
	}
	
	public function vehicleList(){
		$vehicle = [];
		$vehicleTable = TableRegistry::get('Vehicles');
        $query = $vehicleTable->find('list', [
        'keyField' => 'id',
        'valueField' => 'name'])->where(['status' => 1])->order(['name' => 'ASC']);
        $vehicle = $query->all();
    
        return json_encode($vehicle);
        exit;
	}
	
	public function additionalChargeList(){
		$additional_charge = [];
		$additional_chargesTable = TableRegistry::get('AdditionalCharges');
        $additional_charge = $additional_chargesTable->find('all')->where(['status' => 1])->order(['title' => 'ASC'])->toArray();
        return $additional_charge;
	}
	
	public function productList(){
		$products = [];
		$productTable = TableRegistry::get('Products');
        $query = $productTable->find('list', [
        'keyField' => 'id',
        'valueField' => 'title'])->where(['status' => 1])->order(['title' => 'ASC']);
        $products  = $query->all();
        return json_encode($products);
	}

	
	public function taxesList(){
		$taxes = [];
		$taxesTable = TableRegistry::get('Taxes');
        $taxes = $taxesTable->find('all')->where(['status' => 1])->order(['title' => 'ASC'])->toArray();
		return $taxes;
	}
}