<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\Controller\Controller;
use Cake\Controller\Component\CookieComponent;
use Cake\Controller\Component\PaginatorComponent;
use Cake\Network\Email;
use Cake\Utility\Security;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Datasource\ConnectionManager;
class GeneralHelper extends Helper {

    /**
     * @getUserById
     * get User Details by Id
     */
    public function getUserById($user_id = null) {
		
        $usersTable = TableRegistry::get('Users');
        $users_data = $usersTable->get($user_id);
		
        return $users_data;
    }
    
 
     
	
	/**
     * @getRoleById
     * get User Role by Id
     */
    public function getUserName($id=null) {
        $users = TableRegistry::get('users');
        $usersData = $users->find('all')->where([
			'id' => $id,
        ])->first();
		 
		if(!empty($usersData)){
			return $usersData->full_name;
		}else{
			return null;
		}
		
    }

	 
 
    /**
     * @getStatus
     * get status by Id
     */
    public function getStatus($status = null){ 
          switch($status) {
              
               case 0:
                    return '<span class="label label-danger ">Deleted</span>';
                    break;
               
               case 2:
                    return '<span class="label label-warning">Inactive</span>';
                    break;
               
               case 1:
                    return '<span class="label label-success">Active</span>';
                    break;
               
               default:
                    return null;
          }
         
     }
	 
	 /**
     * @gettype_status
     * get status by Id
     */
    public function getChargeType($status = null){
          switch($status) {
               
               case 1:
                    return '<span class="label label-warning ">Fixed</span>';
                    break;
               
               case 2:
                    return '<span class="label label-success">Percentage</span>';
                    break;
               
               default:
                    return null;
          }
         
     }
	
	 

	/**
      *@get page title
      * get page title
     */
    public function getpagetitle($id)
     {
	  $cmsPages = TableRegistry::get('cmsPages');
	  $data = $cmsPages->get($id, ['fields' => ['title']]);
	  $title =  $data->title;
          return $title;
	}
	
	/**
      *@get Users
      * get Users
     */
	 
	public function getUsers($id=null){
		$usersTable = TableRegistry::get('Users');
		if(!empty($id) && $id !=0){
			$users = $usersTable->get($id);
			$users = $users->first_name.' '.$users->last_name;
		}else{
			$users = '--';
		}
		return $users;
	}
	
	/**
      *@get Countries
      * get Countries
     */	
	 
	public function getCountry($id=null){
		$country = '--';
		$Table = TableRegistry::get('Countries');
		if(!empty($id) && $id !=0){
			$country = $Table->get($id);
			$country = $country->country_name;
		}
		return $country;
	}
	
	/**
      *@get States
      * get States
     */
	 
	public function getStates($id=null){
		$result = '--';
		$Table = TableRegistry::get('States');
		if(!empty($id) && $id !=0){
			$state = $Table->get($id);
		    if(!empty($state)){
		        $result = $state->region_name;
		    }
			
		}
		return $result;
	}
	
	//getCategory 
	
	 
	public function getCategory($id=null){
		$category = '--';
		$Table = TableRegistry::get('categories');
		if(!empty($id) && $id !=0){
			$cate = $Table->get($id);
			$category = $cate->title;
		}
		return $category;
	}
	
	//getSubCategory 
	 
	public function getSubCategory($id=null){
		$subcategory = '--';
		$Table = TableRegistry::get('sub_categories');
		if(!empty($id) && $id !=0){
			$sub_cate = $Table->get($id);
			$subcategory = $sub_cate->title;
		}
		return $subcategory;
	}
	
	//getBrand 
	public function getBrand($id=null){
		$brands = '--';
		$Table = TableRegistry::get('brands');
		if(!empty($id) && $id !=0){
			$brand = $Table->get($id);
			$brands = $brand->title;
		}
		return $brands;
	}
	
	public function getSize($size){
		$val = '';
		if(!empty($size)){
			$sizeArr = explode(",",$size);
			
			if(!empty($sizeArr)){
				$Table = TableRegistry::get('Sizes');
				foreach($sizeArr as $key => $sizeVal){
					$sizeVal = $Table->get($sizeVal);
					//pr();
					$val .= '<span class="label label-success">'.$sizeVal->size.'</span> ';
				}
			}
		}
		return $val;
	}
	
	public function getColours($colour){
		$val = '';
		if(!empty($colour)){
			$colourArr = explode(",",$colour);
			
			if(!empty($colourArr)){
				$Table = TableRegistry::get('Colours');
				foreach($colourArr as $key => $colourVal){
					$colourVal = $Table->get($colourVal);
					$val .= '<span class="label label-success">'.$colourVal->name.'</span> ';
				}
			}
		}
		return $val;
	}
	
	/**
     * @getStatus
     * get status by Id
     */
    public function getWay($status = null){ 
			
          switch($status) {
              
				case 1:
                    return '<span class="label label-success">Admin</span>';
                    break;
					
                case 2:
                    return '<span class="label label-warning">Customer</span>';
                    break;
                default:
                    return null;
          }
         
    }
		
 }
