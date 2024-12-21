<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email; 
use Cake\Core\Configure;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Controller\Component\PaginatorComponent;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\Utility\Security;
use Cake\Utility\Inflector;
use Cake\Utility\Text;

/**
 * Projects Controller
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 *
 * @method \App\Model\Entity\project[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{
	public function initialize()
	{
		parent::initialize(); 
		$this->viewBuilder()->setLayout('admin'); 
	}
		
	public function index()
	{	
			$title = "Products";
			$ProductsTable = TableRegistry::get('Products');
			if ($this->request->is(['post', 'put'])) {
				$params = array();
				if (!empty($this->request->getData()['status_id'])) {
					$params['status_id'] = base64_encode($this->request->getData()['status_id']);
				}
				if (!empty($this->request->getData()['sku'])) {
					$params['sku'] = base64_encode($this->request->getData()['sku']);
				}
				if (!empty($this->request->getData()['title'])) {
					$params['title'] = base64_encode($this->request->getData()['title']);
				} 
				$order['id'] = 'DESC';
				return $this->redirect([
					'controller' => 'Products', 'action' => 'index',
					'?' => $params
				]);
			} else {
				$filters = array();
			
				$order = array();
				 
				if (isset($this->request->getQuery()['title'])) {
					$title = base64_decode($this->request->getQuery()['title']);
					$filters['Products.title Like'] = '%' . $title . '%';
					$savesearch['title'] = $title;
				}
				
				if (isset($this->request->getQuery()['sku'])) {
					$sku = base64_decode($this->request->getQuery()['sku']);
					$filters['Products.sku_no'] =  $sku ;
					$savesearch['sku'] = $sku;
				}
			
				if (isset($this->request->getQuery()['status_id'])) {
					$status_id = base64_decode($this->request->getQuery()['status_id']);
					$filters['Products.status'] = $status_id;
					$savesearch['status_id'] = $status_id;
				} 
				$Products = $this->paginate($ProductsTable, [
					'limit' => Configure::read('pageRecord'),
					'conditions' => [$filters],
					'contain' => ['ProductImages'],
					'order' => $order
				]);
			}
			$total=$ProductsTable->find()->count();
			$publishedtotal=$ProductsTable->find()->where(['status'=>1])->count();
			$unpublishedtotal=$ProductsTable->find()->where(['status'=>2])->count();
		 
			 
		$this->set(compact('Products', 'savesearch','title','total','publishedtotal','unpublishedtotal'));
    }
		
	public function clearSearch($action=null){
		$this->autoRender = false;
		$url = $_SERVER['HTTP_REFERER'];
		$newUrl = explode('?',$url);	
		$this->redirect($newUrl[0]); 
    }

	/* public function view($id = null)
    {
		$title = 'Products';
		$Productstbl = TableRegistry::get('Products');
		$id = base64_decode($id);
        
		$result = $Productstbl->get($id,[
						'contain' => ['ProductImages']
					]);
					
        $this->set(compact('result','title'));
    } */

	public function view($id = null) {
		$title	=	'View Product';
		$Productstbl = TableRegistry::get('Products');
		$id = base64_decode($id);
		$result	=	$Productstbl->get($id, ['contain'=>['ProductImages']]);
		// pr($result);
		$this->set(compact('result','title'));
	}	
	 
	public function add(){
		$title = "Products";
		$Productstbl = TableRegistry::get('Products');
		$product=$Productstbl->newEntity();
        if ($this->request->is('post')) {
			
			$otherColorArr = $this->request->getData('other_colors') ? $this->request->getData('other_colors') : '';
			//$sizeArr  = $this->request->getData('size_id') ? $this->request->getData('size_id') : '';
			
			/* if(!empty($sizeArr)){
				$size_coma_sep  = implode(',', $sizeArr);
				$product->size  = $size_coma_sep;
			} */
			
			$imageData = $this->request->getData('image') ?$this->request->getData('image'):'';
			$sku_no = $this->request->getData('sku_no');
			
			
			$product->slug = Text::slug($this->request->getData('title').' '.$this->request->getData('sku'));
			
            $product = $Productstbl->patchEntity($product, $this->request->getData());
			
			/* if(!empty($otherColorArr)){
				$color_coma_sep = implode(',', $otherColorArr);
				$product->other_colors = $color_coma_sep;
			} */
			
			if (!$product->getErrors()) {
				if ($product_Id = $Productstbl->save($product)) {
					if(!empty($imageData)){
						$productimagesTable = TableRegistry::get('ProductImages');
						$product_Id =  $product_Id->id;
						foreach($imageData as $key => $imgData){
							$productimage = $productimagesTable->newEntity();
							if(isset($imgData['name']) && $imgData['name'] != ''){ 
								$img = $this->My->uploadProductImg($imgData,$sku_no, 'product');
								$productimage['image'] = $img;
							}
							$productimage['product_id'] = $product_Id;
							$productimagesTable->save($productimage);
						}
					}
					$this->Flash->set('The Product has been saved.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else { 
					$this->Flash->set('The Product could not be saved. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				} 
			}else{ 
                
				$this->Flash->set($this->errorMessage($product->getErrors()),['key' => 'positive','params'=>['class' => 'alert alert-danger']]);
				//$this->Flash->set('Product not added.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
        }
		
	
		
		$brand = json_decode($this->My->BrandList());
		$category = json_decode($this->My->CategoryList());
		$color = json_decode($this->My->ColorList());
		$size = json_decode($this->My->SizeList());
		$dimension = json_decode($this->My->dimensionList());
		$foundations = json_decode($this->My->FoundationsList());
		$pile = json_decode($this->My->Pile());
		  
        $this->set(compact('product','title','brand','category','color','size','dimension','foundations','pile'));
    }
	
	public function edit($id=null){
		$title = "Products";
		$Productstbl = TableRegistry::get('Products');
		$product = $Productstbl->get(base64_decode($id),[
						'contain' => ['ProductImages']
					]);
		
		
	
		/* if(!empty($product->other_colors)){
				$color_coma_sep = explode(',', $product->other_colors);
				$product->other_colors = $color_coma_sep;
		} */
				
		if($this->request->is(['patch', 'put', 'post']))
		{   
			$otherColorArr = $this->request->getData('other_colors') ? $this->request->getData('other_colors') : '';
			//$sizeArr  = $this->request->getData('size_id')  ? $this->request->getData('size_id')  : '';
			
			
			/* if(!empty($sizeArr)){
				$size_coma_sep = implode(',', $sizeArr);
				$product->size = $size_coma_sep;
			} */
			
			$imageData = $this->request->getData('image') ? $this->request->getData('image') : '';
			
			$sku_no = $this->request->getData('sku_no');
			
			$product = $Productstbl->patchEntity($product, $this->request->getData());
			/* if(!empty($otherColorArr)){
				$color_coma_sep = implode(',', $otherColorArr);
				$product->other_colors = $color_coma_sep;
			} */
			if (!$product->getErrors()) 
			{
				if ($product_Id = $Productstbl->save($product)) 
				{ 
					if(!empty($imageData)){
						$productimagesTable = TableRegistry::get('ProductImages');
						$product_Id =  $product_Id->id;
						foreach($imageData as $key => $imgData){
							$productimage = $productimagesTable->newEntity();
							if(isset($imgData['name']) && $imgData['name'] != ''){ 
									$img = $this->My->uploadProductImg($imgData,$sku_no, 'product');
									$productimage['image'] = $img;
									
									$productimage['product_id'] = $product_Id;
									$productimagesTable->save($productimage);
							}
							
						}
					}
					$this->Flash->set('The Product has been updated.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->set('The Product could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]); 
				}
			}
			else
			{
				$this->Flash->set($this->errorMessage($user->getErrors()),['key' => 'positive','params'=>['class' => 'alert alert-danger']]);
			}
		}
		 
		 
		 
		$brand = json_decode($this->My->BrandList());
		$category = json_decode($this->My->CategoryList());
		$color = json_decode($this->My->ColorList());
		$sizes = json_decode($this->My->SizeList());
		$dimension = json_decode($this->My->dimensionList());
		$foundations = json_decode($this->My->FoundationsList());
		$pile = json_decode($this->My->Pile());
		
		$subCategory = json_decode($this->My->SubCategoryList($product->category_id));
		
		$this->set(compact('product','title','brand','category','color','sizes','subCategory','foundations','pile','dimension'));
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
	
	public function delete($id = null) {
		$id = base64_decode($id);
        $products = $this->Products->get($id); 
        if ($this->Products->delete($products)) 
		{
			 
			$this->Flash->set('The Product has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
        } else {
			$this->Flash->set('The Product could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
        }
        return $this->redirect(['action' => 'index']);
    }
	
	public function deleteAll(){
		$this->autoRender = false;
		$tbl = TableRegistry::get('Products');
		  
		if ($this->request->is(['post', 'put'])) 
		{    
			$newRecord = $this->request->getData()['user_chk'];
			foreach($newRecord as $tempId)
			{
				if($tempId > 0){
					$data = $tbl->get($tempId);  
                    // $tbl->delete($data);
                     
				}
			} 
			$this->Flash->set('Records deleted successfully.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);                   
			$this->redirect(array('controller'=>'Products','action'=>'index')); 
             			
		}
    }

	public function subCategory(){
		
		$category = array();
		$this->autoRender = false;
        $responsetype = 'main';
		$error = 0;
        if(!defined($this->request->getData('cid'))){
            $id = $this->request->getData('cid'); 
		} 
		if($id){
			$Table = TableRegistry::get('sub_categories');
							
			$category = $Table->find('list', [
                                    'keyField' => 'title',
                                    'valueField' => 'id'])
                                ->where(['sub_categories.parent_id' => $id])
                                ->order(['sub_categories.title' => 'ASC'])->toArray();							
			
			//pr($category); die;
			echo json_encode($category); 
		}
		else{
			  return null;
			}
        exit;
		
		
	}


	/**
     * removeImage method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
	function removeImage(){
        $this->autoRender = false;
        $Table = TableRegistry::get('ProductImages');
        $Table1 = TableRegistry::get('Products');
        if ($this->request->is(['post', 'put'])) {
            $pageId = $this->request->getData('id');
			
            if (empty($pageId)) {
                throw new NotFoundException;
            }
            $data = $Table->get($pageId);
			
			$product_id = $data['product_id'];
			
			$productData = $Table1->find()->select(['id','sku_no'])->where(['id'=>$product_id])->first();
			
			if(!empty($productData)){
				$sku_no = $productData['sku_no'];
				
				$imgFolder = $this->get_picture_folder($sku_no);
				
				$original = WWW_ROOT . 'uploads' . DS . 'product' . DS . $imgFolder . DS . $data['image'];
				  
			}
			
            

            if (file_exists($original)) {
                unlink($original);
            }
             
			
			$Table->delete($data);
            $Table->updateAll(['image' => ''], ['id' => $pageId]);
            exit;
        }
    } 
    
    
    
	/*public function uploadcsv() {
		$result	= [];
		$title  = '';
		$successMessage = '';
		$savedCount = 0;
		$savedList = [];
		$notSavedList = [];
		$productTbl 		= TableRegistry::get('Products');
		$productImgTbl 		= TableRegistry::get('ProductImages');
		$categoriesTbl 		= TableRegistry::get('Categories');
		$colorsTbl 			= TableRegistry::get('Colors');
		$foundationsTbl 	= TableRegistry::get('Foundations');
		$pilesTbl 			= TableRegistry::get('Piles');
		$dimensionsTbl 		= TableRegistry::get('Dimensions');

		if($this->request->is(['post','put','file'])) {
			$avatar	= $this->request->getData()['product_csv'];
			$name_ext = explode(".", $avatar['name']);
            $ext = end($name_ext);
            if (strtolower($ext) == 'csv') {
                $file = $avatar['tmp_name'];
                $handle = fopen($file, "r");
                $i = 0;
                while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $i++;
                    if ($i == 1) {
                        continue;
                    }
                    $sku_number 	= $row[0];
                    $color 			= $row[5];
                    $foundation 	= $row[20];
                    $pile 			= $row[21];
                    $category 		= $row[10];
                    $dimension  	= $row[4];

                    $title 				= $row[18];
                    $rug_type 			= $row[12];
                    $dimension_1_feet 	= ($row[13] > 0)?$row[13]:'0';
                    $dimension_1_inches = ($row[14] > 0)?$row[14]:'0';
                    $dimension_2_feet 	= ($row[15] > 0)?$row[15]:'0';
                    $dimension_2_inches = ($row[16] > 0)?$row[16]:'0';
                    $selling_price 		= $row[7];
                    $border_color 		= $row[23];
					
					 
                    $size_type = 0;
                    if($row[3]=='Rectangle'){
                    	$size_type = 1;
                    }else if($row[3]=='Round'){
                    	$size_type = 2;
                    }else if($row[3]=='Runner'){
                    	$size_type = 3;
                    }else if($row[3]=='Square'){
                    	$size_type = 4;
                    }
                     else if($row[3]=='Octagon'){
                     	$size_type = 6;
                     }else if($row[3]=='Oval'){
                     	$size_type = 7;
                     }else if($row[3]=='Odd & Special Sizes'){
                     	$size_type = 5;
                     }
					$sku_esixt 		= $productTbl->find()->select(['id','sku_no'])->where(['sku_no'=>$sku_number])->first();
                    $color_ids 		= $colorsTbl->find()->select(['id'])->where(['name'=>$color])->first();
                    if(empty($color_ids)){ 
						$entity	=	$colorsTbl->newEntity(); 
						$slug = Text::slug($color);
						$entity->name		=	$color;
						$entity->slug		=	$slug;
						$entity->status		=	1; 
						$res = $colorsTbl->save($entity);
						if($res){
							$color_ids['id'] = $res->id;
						}
					}   
					
                    $foundation_ids = $foundationsTbl->find()->select(['id'])->where(['title'=>$foundation])->first();
					
					
					if(empty($foundation_ids)){ 
						$entity1	=	$foundationsTbl->newEntity();  
						$entity1->title		=	$foundation; 
						$entity1->status		=	1; 
						$res1 = $foundationsTbl->save($entity1);
						if($res1){
							$foundation_ids['id'] = $res1->id;
						}
					} 
					
					
                    $pile_ids 		= $pilesTbl->find()->select(['id'])->where(['title'=>$pile])->first();
					
					if(empty($pile_ids)){ 
						$entity2	=	$pilesTbl->newEntity();  
						$entity2->title		=	$pile; 
						$entity2->description		=	$pile; 
						$entity2->status		=	1; 
						$res2 = $pilesTbl->save($entity2);
						if($res2){
							$pile_ids['id'] = $res2->id;
						}
					} 
					
					
                    $category_ids 	= $categoriesTbl->find()->select(['id'])->where(['title'=>$category])->first();
					
					if(empty($category_ids)){ 
						
						$entity3	=	$categoriesTbl->newEntity();  
						$entity3->title		 =	$category; 
						$entity3->meta_title =	$category; 
						$entity3->meta_tags =	$category; 
						$entity3->meta_keywords =	$category;  
						$entity3->term = Text::slug($category);
						$entity3->parent_cat =	0; 
						$entity3->status	 =	1; 
						$res3 = $categoriesTbl->save($entity3);
						if($res3){
							$category_ids['id'] = $res3->id;
						}
					} 
					
                    $dimension_ids 	= $dimensionsTbl->find()->select(['id'])->where([TRIM('title')=>$dimension, 'type'=>$size_type])->first();
					
					if(empty($dimension_ids)){ 
						$entity4	=	$dimensionsTbl->newEntity();  
						$entity4->title		=	$dimension; 
						$entity4->term = Text::slug($dimension);
						$entity4->slug = Text::slug($dimension);
						$entity4->status		=	1; 
						$entity4->is_large_runner =	0; 
						$entity4->parent_id		=	0; 
						$entity4->type		=	$size_type; 
						$res4 = $dimensionsTbl->save($entity4);
						if($res4){
							$dimension_ids['id'] = $res4->id;
						}
					} 
                   

                    $total_square_ft 	= ($row[13] + number_format(($row[14]*0.083),2) ) * ($row[15] + number_format(($row[16]*0.083),2) );
                    $images 			= [$row[26],$row[27],$row[28],$row[29],$row[30]];

                    if (empty($sku_esixt) && $sku_number && !empty($color_ids) && !empty($foundation_ids) && !empty($pile_ids) && !empty($category_ids) && !empty($dimension_ids) && !empty($title) && !empty($rug_type) && ($dimension_1_feet != '') && ($dimension_1_inches != '') && ($dimension_2_feet != '') && ($dimension_2_inches != '') && !empty($selling_price) && !empty($border_color)) {
                        $productNew = $productTbl->newEntity();
                        $saveData = [
                            'size' => $row[4],
                            'sku_no' => $sku_number,
                            'title' => $title,
                            'rug_type' => $rug_type,
                            'age' => $row[24],
                            'dimension_1_feet' => $dimension_1_feet,
                            'dimension_1_inches' => $dimension_1_inches,
                            'dimension_2_feet' => $dimension_2_feet,
                            'dimension_2_inches' => $dimension_2_inches,
                            'selling_price' => $selling_price,
                            'everyday_price' =>  $row[6],
                            'rug_pad' => 0,
                            'total_square_ft' => number_format($total_square_ft,2),
                            'shipping_price' => 0,
                            'color_id' => $color_ids['id'],
                            'border_color' => $border_color,
                            'other_colors' => $row[5],
                            'foundation_id' => $foundation_ids['id'],
                            'pile_id' => $pile_ids['id'],
                            'dimension_id' => $dimension_ids['id'],
                            'category_id' => $category_ids['id'],
                            'sub_category' => '',
                            'style' => $row[2],
                            'available_shape' => $row[3],
                            'available_sizes' => $row[17],
                            'overstock_style' => $row[2],
                            'overstock_origin' => strtoupper($row[19]),
                            'status' => 1,
                            'is_future' => 0,
                            'sold_status' => 0,
                            'short_orders' => NULL,
		                    'pattern'=>$row[8],
		                    'field_color_exact'=>$row[22],
		                    'vendor_rn'=>$row[1],
		                    'rug_design'=>$row[9],
		                    'material'=>$row[11],
		                    'location'=>$row[25]
                        ];

                        $product = $productTbl->patchEntity($productNew, $saveData);
	            		if (!$product->getErrors()) {
	                        if ($saveResult = $productTbl->save($product)) {
	                            foreach($images as $value){
	                            	if(!empty($value)){
		                                $productImgNew = $productImgTbl->newEntity();
		                                $productImgSave['product_id'] = $saveResult->id;
		                                $productImgSave['image'] = $value;
		                                $productImgTbl->patchEntity($productImgNew, $productImgSave);
		                                $productImgTbl->save($productImgNew);
	                            	}
	                            }
	                            $savedCount++;
	                            // $row['row_number'] = $i;
	                            $savedList[] = $i;
	                        } else {
	                            $row['error'] = "Data not saved";
	                            // $row['row_number'] = $i;
	                            $notSavedList[] = $i;
	                        }
	                    }else{
	                    	$error2 = $this->errorMessage($product->getErrors());
	                    	$row['error'] = $error2;
	                        $row['row_number'] = $i;
	                        $notSavedList[] = $row;
	                	}
                    } else {
                        $error = "";
                        if(!empty($sku_esixt)){
                        	$error = ($error) ? $error . ", SKU number already exist" : "SKU number already exist";
                        }
                        if (empty($sku_number)) {
                            $error = ($error) ? $error . ", SKU number missing" : "SKU number missing";
                        }
                        if (empty($color_ids)) {
                            $error = ($error) ? $error . ", Color not matched" : "Color not matched";
                        }
                        if (empty($foundation_ids)) {
                            $error = ($error) ? $error . ", Foundation not matched" : "Foundation not matched";
                        }
                        if (empty($pile_ids)) {
                            $error = ($error) ? $error . ", Pile not matched" : "Pile not matched";
                        }
                        if (empty($category_ids)) {
                            $error = ($error) ? $error . ", Category not matched" : "Category not matched";
                        }
                        if (empty($dimension_ids)) {
                            $error = ($error) ? $error . ", Dimension not matched" : "Dimension not matched";
                        }
                        if (empty($title)) {
                            $error = ($error) ? $error . ", Title is missing" : "Title is missing";
                        }
                        if (empty($rug_type)) {
                            $error = ($error) ? $error . ", Rug Type is missing" : "Rug Type is missing";
                        }
                        if (empty($dimension_1_feet)) {
                            $error = ($error) ? $error . ", Width Feet is missing" : "Width Feet is missing";
                        }
                        if (empty($dimension_1_inches)) {
                            $error = ($error) ? $error . ", Width Inches is missing" : "Width Inches is missing";
                        }
                        if (empty($dimension_2_feet)) {
                            $error = ($error) ? $error . ", Length Feet is missing" : "Length Feet is missing";
                        }
                        if (empty($dimension_2_inches)) {
                            $error = ($error) ? $error . ", Length Inches is missing" : "Length Inches is missing";
                        }
                        if (empty($selling_price)) {
                            $error = ($error) ? $error . ", Selling price is missing" : "Selling price is missing";
                        }
                        if (empty($border_color)) {
                            $error = ($error) ? $error . ", Border color is missing" : "Border color is missing";
                        }

                        $row1['error'] = $error;
                        $row1['row_number'] = $i;
                        $notSavedList[] = $row1;
                    }
                 //    echo "<pre>";
                	// print_r($notSavedList);die;
                }

                // echo "<pre>";
                // print_r($notSavedList);die;

                fclose($handle);

                $notSavedCount = ($notSavedList) ? count($notSavedList) : 0;
                if ($notSavedCount) {
                    if ($savedCount > 0) {
                        $message = "Some rows are saved, Please check not saved rows";
                    } else {
                        $message = "Nothing saved, Please try again";
                    }
                } else {
                    $message = "All rows are saved";
                }

                $successMessage = ['status' => 1, 'message' => $message, 'saved_count' => $savedCount, 'saved_list' => $savedList, 'notsaved_count' => $notSavedCount, 'not_saved_list' => $notSavedList];
            } else {
                $successMessage = ['status' => 0, 'message' => "Import only CSV file"];
            }
			
		}
		else{ 
				
		}
		$this->set(compact('result','title','successMessage'));
	}
    */
    
    
	public function uploadcsv() {
		set_time_limit(0); 
		ini_set('memory_limit','640M');
		ini_set('max_execution_time', 3000); 
		 
		$result	= [];
		$title  = '';
		$successMessage = '';
		$savedCount = 0;
		$savedList = [];
		$notSavedList = [];
		$productTbl 		= TableRegistry::get('Products');
		$productImgTbl 		= TableRegistry::get('ProductImages');
		$categoriesTbl 		= TableRegistry::get('Categories');
		$colorsTbl 			= TableRegistry::get('Colors');
		$foundationsTbl 	= TableRegistry::get('Foundations');
		$pilesTbl 			= TableRegistry::get('Piles');
		$dimensionsTbl 		= TableRegistry::get('Dimensions');

		if($this->request->is(['post','put','file'])) {
			$avatar	= $this->request->getData()['product_csv'];
			$name_ext = explode(".", $avatar['name']);
            $ext = end($name_ext);
            if (strtolower($ext) == 'csv') {
                $file = $avatar['tmp_name'];
                $handle = fopen($file, "r");
                $i = 0;
                while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $i++;
                    if ($i == 1) {
                        continue;
                    }
					 
                    
                    $sku_number 			= $row[0];
                    $color 			= $row[5];
                    $foundation 	= $row[20];
                    $pile 			= $row[21];
                    $category 		= $row[10];
                    $dimension  	= $row[4];

                    $title 				= $row[18];
                    $rug_type 			= $row[12];
                    $dimension_1_feet 	= ($row[13] > 0)?$row[13]:'0';
                    $dimension_1_inches = ($row[14] > 0)?$row[14]:'0';
                    $dimension_2_feet 	= ($row[15] > 0)?$row[15]:'0';
                    $dimension_2_inches = ($row[16] > 0)?$row[16]:'0';
                    $selling_price 		= $row[7];
                    $border_color 		= $row[23];
					
					 
                    $size_type = 0;
                    if($row[3]=='Rectangle'){
                    	$size_type = 1;
                    }else if($row[3]=='Round'){
                    	$size_type = 2;
                    }else if($row[3]=='Runner'){
                    	$size_type = 3;
                    }else if($row[3]=='Square'){
                    	$size_type = 4;
                    }
					else if($row[3]=='Octagon'){
                     	$size_type = 6;
					}else if($row[3]=='Oval'){
                     	$size_type = 7;
					}else if($row[3]=='Odd & Special Sizes'){
                     	$size_type = 5;
					}
					
					$sku_esixt 		= $productTbl->find()->select(['id','sku_no'])->where(['sku_no'=>$sku_number])->first();
					 
					$crud_operation = $row[31]; 
						
					if(strtolower($crud_operation) == 'delete'){
						 
						if(!empty($sku_esixt)){
							if($sku_esixt->id && $sku_esixt->id > 0){ 
								$data = $productTbl->get($sku_esixt->id);  
								if($productTbl->delete($data)){
									$productImgTbl->deleteAll(['product_id' => $sku_esixt->id]);
								}  
							}
						}
					}else{
						$color_ids 		= $colorsTbl->find()->select(['id'])->where(['name'=>$color])->first();
						if(empty($color_ids)){ 
							$entity	=	$colorsTbl->newEntity(); 
							$slug = Text::slug($color);
							$entity->name		=	$color;
							$entity->slug		=	$slug;
							$entity->status		=	1; 
							$res = $colorsTbl->save($entity);
							if($res){
								$color_ids['id'] = $res->id;
							}
						}   
						
						$foundation_ids = $foundationsTbl->find()->select(['id'])->where(['title'=>$foundation])->first();
						
						
						if(empty($foundation_ids)){ 
							$entity1	=	$foundationsTbl->newEntity();  
							$entity1->title		=	$foundation; 
							$entity1->status		=	1; 
							$res1 = $foundationsTbl->save($entity1);
							if($res1){
								$foundation_ids['id'] = $res1->id;
							}
						} 
						
						
						$pile_ids 		= $pilesTbl->find()->select(['id'])->where(['title'=>$pile])->first();
						
						if(empty($pile_ids)){ 
							$entity2	=	$pilesTbl->newEntity();  
							$entity2->title		=	$pile; 
							$entity2->description		=	$pile; 
							$entity2->status		=	1; 
							$res2 = $pilesTbl->save($entity2);
							if($res2){
								$pile_ids['id'] = $res2->id;
							}
						} 
						
						
						$category_ids 	= $categoriesTbl->find()->select(['id'])->where(['title'=>$category])->first();
						
						if(empty($category_ids)){ 
							
							$entity3	=	$categoriesTbl->newEntity();  
							$entity3->title		 =	$category; 
							$entity3->meta_title =	$category; 
							$entity3->meta_tags =	$category; 
							$entity3->meta_keywords =	$category;  
							$entity3->term = Text::slug($category);
							$entity3->parent_cat =	0; 
							$entity3->status	 =	1; 
							$res3 = $categoriesTbl->save($entity3);
							if($res3){
								$category_ids['id'] = $res3->id;
							}
						} 
						
						$dimension_ids 	= $dimensionsTbl->find()->select(['id'])->where([TRIM('title')=>$dimension, 'type'=>$size_type])->first();
						
						if(empty($dimension_ids)){ 
							$entity4	=	$dimensionsTbl->newEntity();  
							$entity4->title		=	$dimension; 
							$entity4->term = Text::slug($dimension);
							$entity4->slug = Text::slug($dimension);
							$entity4->status		=	1; 
							$entity4->is_large_runner =	0; 
							$entity4->parent_id		=	0; 
							$entity4->type		=	$size_type; 
							$res4 = $dimensionsTbl->save($entity4);
							if($res4){
								$dimension_ids['id'] = $res4->id;
							}
						} 
					   

						$total_square_ft 	= ($row[13] + number_format(($row[14]*0.083),2) ) * ($row[15] + number_format(($row[16]*0.083),2) );
						$images 			= [$row[26],$row[27],$row[28],$row[29],$row[30],$row[31]];

						if ($sku_number && !empty($color_ids) && !empty($foundation_ids) && !empty($pile_ids) && !empty($category_ids) && !empty($dimension_ids) && !empty($title) && !empty($rug_type) && ($dimension_1_feet != '') && ($dimension_1_inches != '') && ($dimension_2_feet != '') && ($dimension_2_inches != '') && !empty($selling_price) && !empty($border_color)) {
						
							$isupdateProcess = false;
							if(strtolower($crud_operation) == 'add' && empty($sku_esixt)){ 
								$productNew = $productTbl->newEntity();
							}else{
								if(!empty($sku_esixt) && $sku_esixt->id && $sku_esixt->id > 0){
									$isupdateProcess = true;
									$productNew = $productTbl->get($sku_esixt->id);   
								}else{
									$productNew = $productTbl->newEntity();
								} 
							}
						  
							$saveData = [
								'size' => $row[4],
								'sku_no' => $sku_number,
								'title' => $title,
								'rug_type' => $rug_type,
								'age' => $row[24],
								'dimension_1_feet' => $dimension_1_feet,
								'dimension_1_inches' => $dimension_1_inches,
								'dimension_2_feet' => $dimension_2_feet,
								'dimension_2_inches' => $dimension_2_inches,
								'selling_price' => $selling_price,
								'everyday_price' =>  $row[6],
								'rug_pad' => 0,
								'total_square_ft' => number_format($total_square_ft,2),
								'shipping_price' => 0,
								'color_id' => $color_ids['id'],
								'border_color' => $border_color,
								'other_colors' => $row[5],
								'foundation_id' => $foundation_ids['id'],
								'pile_id' => $pile_ids['id'],
								'dimension_id' => $dimension_ids['id'],
								'category_id' => $category_ids['id'],
								'sub_category' => '',
								'style' => $row[2],
								'available_shape' => $row[3],
								'available_sizes' => $row[17],
								'overstock_style' => $row[2],
								'overstock_origin' => strtoupper($row[19]),
								'status' => 1,
								'is_future' => 0,
								'sold_status' => 0,
								'short_orders' => NULL,
								'pattern'=>$row[8],
								'field_color_exact'=>$row[22],
								'vendor_rn'=>$row[1],
								'rug_design'=>$row[9],
								'material'=>$row[11],
								'location'=>$row[25]
							];

							$product = $productTbl->patchEntity($productNew, $saveData);
							if (!$product->getErrors()) {
								if ($saveResult = $productTbl->save($product)) {
									if($isupdateProcess){
										$productImgTbl->deleteAll(['product_id' => $saveResult->id]);
									}
									foreach($images as $value){
										if(!empty($value)){ 
											$productImgNew = $productImgTbl->newEntity();
											$productImgSave['product_id'] = $saveResult->id;
											$productImgSave['image'] = $value;
											$productImgTbl->patchEntity($productImgNew, $productImgSave);
											$productImgTbl->save($productImgNew);
										}
									}
									$savedCount++;
									// $row['row_number'] = $i;
									$savedList[] = $i;
								} else {
									$row['error'] = "Data not saved";
									// $row['row_number'] = $i;
									$notSavedList[] = $i;
								}
							}else{
								$error2 = $this->errorMessage($product->getErrors());
								$row['error'] = $error2;
								$row['row_number'] = $i;
								$notSavedList[] = $row;
							}
							 
						} else {
							$error = "";
							/* if(!empty($sku_esixt)){
								$error = ($error) ? $error . ", SKU number already exist" : "SKU number already exist";
							} */
							if (empty($sku_number)) {
								$error = ($error) ? $error . ", SKU number missing" : "SKU number missing";
							}
							if (empty($color_ids)) {
								$error = ($error) ? $error . ", Color not matched" : "Color not matched";
							}
							if (empty($foundation_ids)) {
								$error = ($error) ? $error . ", Foundation not matched" : "Foundation not matched";
							}
							if (empty($pile_ids)) {
								$error = ($error) ? $error . ", Pile not matched" : "Pile not matched";
							}
							if (empty($category_ids)) {
								$error = ($error) ? $error . ", Category not matched" : "Category not matched";
							}
							if (empty($dimension_ids)) {
								$error = ($error) ? $error . ", Dimension not matched" : "Dimension not matched";
							}
							if (empty($title)) {
								$error = ($error) ? $error . ", Title is missing" : "Title is missing";
							}
							if (empty($rug_type)) {
								$error = ($error) ? $error . ", Rug Type is missing" : "Rug Type is missing";
							}
							if (empty($dimension_1_feet)) {
								$error = ($error) ? $error . ", Width Feet is missing" : "Width Feet is missing";
							}
							if (empty($dimension_1_inches)) {
								$error = ($error) ? $error . ", Width Inches is missing" : "Width Inches is missing";
							}
							if (empty($dimension_2_feet)) {
								$error = ($error) ? $error . ", Length Feet is missing" : "Length Feet is missing";
							}
							if (empty($dimension_2_inches)) {
								$error = ($error) ? $error . ", Length Inches is missing" : "Length Inches is missing";
							}
							if (empty($selling_price)) {
								$error = ($error) ? $error . ", Selling price is missing" : "Selling price is missing";
							}
							if (empty($border_color)) {
								$error = ($error) ? $error . ", Border color is missing" : "Border color is missing";
							}

							$row1['error'] = $error;
							$row1['row_number'] = $i;
							$notSavedList[] = $row1;
						}
					} 
					 
                 //    echo "<pre>";
                	// print_r($notSavedList);die;
                }

                // echo "<pre>";
                // print_r($notSavedList);die;

                fclose($handle);

                $notSavedCount = ($notSavedList) ? count($notSavedList) : 0;
                if ($notSavedCount) {
                    if ($savedCount > 0) {
                        $message = "Some rows are saved, Please check not saved rows";
                    } else {
                        $message = "Nothing saved, Please try again";
                    }
                } else {
                    $message = "All rows are saved";
                }

                $successMessage = ['status' => 1, 'message' => $message, 'saved_count' => $savedCount, 'saved_list' => $savedList, 'notsaved_count' => $notSavedCount, 'not_saved_list' => $notSavedList];
            } else {
                $successMessage = ['status' => 0, 'message' => "Import only CSV file"];
            }
			
		}
		else{ 
				
		}
		$this->set(compact('result','title','successMessage'));
	}

 
	public function updateurlall(){
		$this->autoRender = false;
		$tbl = TableRegistry::get('Products');
		if ($this->request->is(['post', 'put'])) 
		{    
			$newRecord = $this->request->getData()['user_chk'];
			// echo "<pre>";print_r($newRecord);exit;
			foreach($newRecord as $tempId)
			{
				
				$url = base64_encode ($tempId);	
				if($tempId != '0'){
							$tablename = TableRegistry::get("Products");
							$query = $tablename->query();
										$result = $query->update()
												->set(['url' => $url ])
												->where(['sku_no' => $tempId])
												->execute();
				}
			} 
			
			$this->Flash->set('Records deleted successfully.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);                   
			$this->redirect(array('controller'=>'Products','action'=>'index')); 
             			
		}
		
    } 
 
}