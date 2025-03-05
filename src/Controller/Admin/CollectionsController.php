<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Utility\Text;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

//use Cake\ORM\Behavior\TreeBehavior;
/**
 * Groups Controller
 *
 * @property \App\Model\Table\GroupsTable $Groups
 */
class CollectionsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('Paginator');
        $collectionsImagesTable = TableRegistry::getTableLocator()->get('collection_images');
    }

    public function beforeFilter(Event $event)
    {
        $this->viewBuilder()->setLayout('admin');
        $this->Auth->allow(['startScan']);
        parent::beforeFilter($event);
    }

    public function clearSearch($action = null)
    {
        $this->autoRender    =    false;
        $url    =    $_SERVER['HTTP_REFERER'];
        $newUrl    =    explode('?', $url);
        $this->redirect($newUrl[0]);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $title        =    'Collections List';
        $collectionsTable = TableRegistry::getTableLocator()->get('Collections');
        $savesearch = array();

        if ($this->request->is(['post', 'put'])) {
            $params = array();
            if (!empty($this->request->getData()['title'])) {
                $params['title'] = base64_encode($this->request->getData()['title']);
            }
            if (!empty($this->request->getData()['parent_id'])) {
                $params['parent_id'] = base64_encode($this->request->getData()['parent_id']);
            }
            if (!empty($this->request->getData()['status_id'])) {
                $params['status_id'] = base64_encode($this->request->getData()['status_id']);
            }

            $order['id'] = 'DESC';
            return $this->redirect([
                'controller' => 'collections',
                'action' => 'index',
                '?' => $params
            ]);
        } else {
            $filters = array();
            $order = array('id' => 'DESC');
            $limit = Configure::read('pageRecord');

            if (isset($this->request->getQuery()['title'])) {
                $title = base64_decode($this->request->getQuery()['title']);
                $filters['title like '] = "%$title%";
                $savesearch['title'] = $title;
            }
            if (isset($this->request->getQuery()['parent_id'])) {
                $parent_id = base64_decode($this->request->getQuery()['parent_id']);
                $filters['parent_id'] = $parent_id;
                $savesearch['parent_id'] = $parent_id;
            }
            if (isset($this->request->getQuery()['status_id'])) {
                $status = base64_decode($this->request->getQuery()['status_id']);
                $filters['status'] = $status;
                $savesearch['status_id'] = $status;
            }

            $categories = $this->paginate($collectionsTable, [
                'limit' => $limit,
                'conditions' => [$filters],
                'order' => $order
            ]);
        }
        $collectionParentData    =    parent::returnCollectionCategory();
        $categoryOption = [];
        
        foreach($collectionParentData as $collectionParentKeys => $collectionParent){
            $categoryOption[$collectionParentKeys] = $collectionParent['title'];
        }
        $this->set(compact('categories', 'categoryOption', 'savesearch', 'title'));
    }

    public function add()
    {
        $title        =    'Add Collection';
        $collectionsTable = TableRegistry::getTableLocator()->get('Collections');
        $collectionsImagesTable = TableRegistry::getTableLocator()->get('collection_images');

        $collection        =    $collectionsTable->newEntity();
        $collectionParentData    =    parent::returnCollectionCategory();
        $collCategoryList = [];
        
        foreach($collectionParentData as $collectionParentKeys => $collectionParent){
            $collCategoryList[$collectionParentKeys] = $collectionParent['title'];
        }
        if ($this->request->is('post')) {
            $postData = $this->request->getData();
            $mappedData = [
                'collection_type' => $postData['collection-type'],
                'title' => $postData['title'],
                'status' => $postData['status']
            ];
            if ($postData['collection-type'] == '2') {
                $mappedData['page_url'] = $postData['page_link'];
                $mappedData['meta_title'] = $postData['meta_title'];
                $mappedData['meta_description'] = $postData['meta_description'];
                $mappedData['meta_keywords'] = $postData['meta_keywords'];
            }

            $collectionsTable->patchEntity($collection, $mappedData);

            $saveImage = false;
            if ($postData['collection-type'] == '2') {
                $imageData    =    isset($postData['image']) ? $postData['image'] : '';
                if (!empty($imageData)) {
                    $result = $this->My->verifyImage($imageData);
                    if (isset($result['error']) && !empty($imageData['name'])) {
                        $this->set(compact('collCategoryList', 'category', 'title'));
                        $this->Flash->set($result['error'], ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
                        return;
                    } else {
                        $saveImage = true;
                    }
                }
            }
            if (!$collection->getErrors()) {
                if ($postData['collection-type'] == '1') {
                    $collection->parent_id = 0;
                } else if ($postData['collection-type'] == '2') {
                    if (isset($postData['collection-category']) && !empty($postData['collection-category'])) {
                        $collection->parent_id = $postData['collection-category'];
                    } else {
                        $collection->parent_id = 0;
                    }
                }
                if ($saveCollection = $collectionsTable->save($collection)) {
                    if ($saveImage) {
                        $newImageCollection = $collectionsImagesTable->newEntity();
                        $newImageCollection->image_type = $imageData['type'];
                        $newImageCollection->associated_id = $saveCollection->id;
                        if (isset($imageData['name']) && $imageData['name'] != '') {
                            $img = $this->My->uploadfile($imageData, 'collection');
                            $newImageCollection->file_path = $img;
                            $collectionsImagesTable->save($newImageCollection);
                        }
                    }
                    $this->Flash->set('The Collection has been saved.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
                    $this->redirect(['controller' => 'collections', 'action' => 'index']);
                } else {
                    $this->Flash->set('The Collection could not be saved. Please, try again.', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
                }
            } else {
                $this->Flash->set($this->errorMessage($collection->getErrors()), ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
            }
        }
        $this->set(compact('collCategoryList', 'collection', 'title'));
    }

    public function edit($id = null)
    {
        $title            =    'Edit Collection';
        $collectionsTable = TableRegistry::getTableLocator()->get('Collections');
        $collectionsImagesTable = TableRegistry::getTableLocator()->get('collection_images');

        $collection        =    $collectionsTable->get($id);
        $collectionImages = parent::returnCollectionImages($id);

        $collectionParentData    =    parent::returnCollectionCategory();
        $collCategoryList = [];
        
        foreach($collectionParentData as $collectionParentKeys => $collectionParent){
            $collCategoryList[$collectionParentKeys] = $collectionParent['title'];
        }
        if ($this->request->is(['patch', 'put', 'post'])) {
            $postData = $this->request->getData();
            $mappedData = [
                'collection_type' => $postData['collection-type'],
                'title' => $postData['title'],
                'status' => $postData['status'],
                'parent_id' => 0
            ];
            if ($postData['collection-type'] == '2') {
                $mappedData['meta_title'] = $postData['meta_title'];
                $mappedData['meta_description'] = $postData['meta_description'];
                $mappedData['meta_keywords'] = $postData['meta_keywords'];
                $mappedData['parent_id'] = $postData['collection-category'];
            }

            $collectionsTable->patchEntity($collection, $mappedData);
            $saveImage = false;
            if ($postData['collection-type'] == '2') {
                $imageData    =    isset($postData['image']) ? $postData['image'] : '';
                if (!empty($imageData)) {
                    $result = $this->My->verifyImage($imageData);
                    if (isset($result['error']) && !empty($imageData['name'])) {
                        $this->set(compact('collCategoryList', 'category', 'title'));
                        $this->Flash->set($result['error'], ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
                        return;
                    } else {
                        $saveImage = true;
                    }
                }
            }
            if (!$collection->getErrors()) {
                if ($collectionsTable->save($collection)) {
                    if ($saveImage) {
                        $newImageCollection = $collectionsImagesTable->newEntity();
                        $newImageCollection->image_type = $imageData['type'];
                        $newImageCollection->associated_id = $collection->id;
                        if (isset($imageData['name']) && $imageData['name'] != '') {
                            $img = $this->My->uploadfile($imageData, 'collection');
                            $newImageCollection->file_path = $img;
                            $collectionsImagesTable->save($newImageCollection);
                        }
                    }
                    $this->Flash->set('Collection has been updated successfully.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->set('Failed to update collection.', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
                }
            } else {
                $this->Flash->set($this->errorMessage($collection->getErrors()), ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
            }
        }
        $this->set(compact('collection', 'collCategoryList', 'title', 'collectionImages'));
    }

    public function view($id = null)
    {
        $title        =    'View Collection';
        $collectionsTable = TableRegistry::getTableLocator()->get('Collections');
        $collectionData    =    $collectionsTable->get($id);
        $collectionImages = parent::returnCollectionImages($id);

        $this->set('collection', $collectionData);
        $this->set(compact('title','collectionImages'));
    }

    public function delete($id = null)
    {
        $collectionsTable = TableRegistry::getTableLocator()->get('Collections');
        $aCollection = $collectionsTable->get($id);
        $this->removeImageRecords($id);
        if ($collectionsTable->delete($aCollection)) {
            $this->Flash->set('The collection has been deleted.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
        } else {
            $this->Flash->set('The collection could not be deleted. Please, try again.', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
        }
        return $this->redirect(['action' => 'index']);
    }

    public function deleteAll()
    {
        $this->autoRender = false;
        $collectionsTable = TableRegistry::getTableLocator()->get('Collections');
        if ($this->request->is(['post', 'put'])) {
            $newRecord = $this->request->getData()['user_chk'];
            foreach ($newRecord as $ids) {
                if ($ids > 0) {
                    $catData = $collectionsTable->get($ids);
                    $this->removeImageRecords($ids);
                    if ($collectionsTable->delete($catData)) {
                        $this->Flash->set('The collection has been deleted.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
                    } else {
                        $this->Flash->set('The collection could not be deleted. Please, try again.', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
                    }
                }
            }
            return $this->redirect(['action' => 'index']);
        }
    }

    public function returnPageUrl()
    {
        $this->request->allowMethod(['post', 'put']); // Only POST and PUT requests are allowed
        $this->autoRender =    false;
        $collectionTable =    TableRegistry::getTableLocator()->get('Collections');
        if ($this->request->is(['post', 'put'])) {
            $postData    =    $this->request->getData();
            $returnData = ['status' => false, 'message' => '', "value" => ''];
            if (!empty($postData['linkValue'])) {
                $pageURl = Text::slug($postData['linkValue']);
                $existingURl_Count = $collectionTable->find('all')
                    ->select(['id'])
                    ->where([
                        'Collections.page_url' => $pageURl
                    ])
                    ->count();
                if ($existingURl_Count > 0) {
                    $returnData["status"] = false;
                    $returnData["message"] = "URL Already exist.";
                } else {
                    $returnData["status"] = true;
                    $returnData["value"] = strtolower($pageURl);
                }
            }
            // // Encode the data to JSON
            $jsonData = json_encode($returnData);

            // // Return the response with proper JSON headers
            $this->response = $this->response->withType('json')
                ->withStringBody($jsonData);

            return $this->response;
        }
    }

    public function deleteImg($id = null)
    {
        $result =  0;
        $this->autoRender = false;
        $this->viewBuilder()->setLayout(false);
        $collectionsImagesTable = TableRegistry::getTableLocator()->get('collection_images');
        $customCall = false;

        if ($this->request->is('post')) {
            $fieldName = $this->request->getData('FieldName');
            $id        = $this->request->getData('id');
        } else {
            if (!is_null($id)) {
                $id = $id;
                $fieldName = 'file_path';
                $customCall = true;
            } else {
                return;
            }
        }

        $collectionImage = $collectionsImagesTable->get($id);
        $removeImage = $collectionImage[$fieldName];
        if ($collectionsImagesTable->delete($collectionImage)) {

            $original = WWW_ROOT . 'uploads' . DS . 'collection' . DS . $removeImage;
            if (file_exists($original)) {
                unlink($original);
            }

            $original_thumb = WWW_ROOT . 'uploads' . DS . 'collection/thumb' . DS . $removeImage;
            if (file_exists($original_thumb)) {
                unlink($original_thumb);
            }
            $result =  1;
        }

        if ($customCall) {
            return $result;
        } else {
            echo $result;
        }
    }

    public function removeImageRecords($parentID)
    {
        $collectionsImagesTable = TableRegistry::getTableLocator()->get('collection_images');
        $imagesRecord_SQL = $collectionsImagesTable->find('all')->where(['associated_id' => $parentID]);
        if ($imagesRecord_SQL->count() > 0) {
            $imagesRecord = $imagesRecord_SQL->enableHydration(false)->toList();
            foreach ($imagesRecord as $imageData) {
                $this->deleteImg($imageData['id']);
            }
        }
    }
    
    public function scanAndSave($directoryPath, $parentId = 0, $collectionType = 1)
    {
        $collectionsImagesTable = TableRegistry::getTableLocator()->get('collection_images');
        $folder = new Folder($directoryPath);
        $contents = $folder->read(); // Returns ['directories', 'files']

        $folderName = basename($directoryPath);

        // Ignore folders starting with "."
        if ($this->isIgnored($folderName)) {
            return;
        }
        echo "<pre>contents: ";print_r($contents);echo "</pre>";
        
       
        // Check if folder already exists in collections table
        $existingFolder = $this->Collections->find()
            ->where(['title' => $folderName, 'parent_id' => $parentId])
            ->first();

        if (!$existingFolder) {
            // Insert as Category (1) or SubCategory (2) based on depth
            $folderEntity = $this->Collections->newEntity([
                'collection_type'   => $collectionType,
                'title'             => $folderName,
                'parent_id'         => $parentId,
                'meta_title'        => null,
                'meta_description'  => null,
                'meta_keywords'     => null,
                'sort'              => null,
                'status'            => 1,
                'page_url'          => strtolower(str_replace(' ', '-', $folderName)),
                'created'           => date('Y-m-d H:i:s')
            ]);
            $savedFolder = $this->Collections->save($folderEntity);
            $folderId = $savedFolder->id;
            echo "<pre>New Folder Added: ";print_r($folderName);echo "</pre>";
        } else {
            echo "<pre>Folder Already Exist: ";print_r($folderName);echo "</pre>";
            $folderId = $existingFolder->id;
        }
        echo "<pre>folderId: ";print_r($folderId);echo "</pre>";
        // Process subfolders as subcategories
        foreach ($contents[0] as $subfolder) {
            if (!$this->isIgnored($subfolder)) {
                $this->scanAndSave($directoryPath . DS . $subfolder, $folderId, 2);
            }
        }

        // Process image files
        foreach ($contents[1] as $file) {
            if ($this->isImage($file) && !$this->isIgnored($file)) {
                $filePath = $directoryPath . DS . $file;
                $basePath = '/home/kaouds/public_html/webroot/uploads/collection/';
                $relativePath = str_replace($basePath, '', $filePath);
                $relativePath = '/' . ltrim($relativePath, '/');
                // Check if image already exists
                $existingImage = $collectionsImagesTable->find()
                    ->where(['file_path' => $relativePath, 'associated_id' => $folderId])
                    ->first();
                if (!$existingImage) {
                    // Insert image
                    $basePath = '/home/kaouds/public_html/webroot/uploads/collection/';
                    $relativePath = str_replace($basePath, '', $filePath);
                    $relativePath = '/' . ltrim($relativePath, '/');

                    $imageEntity = $collectionsImagesTable->newEntity([
                        'file_path'     => $relativePath,
                        'image_type'    => pathinfo($file, PATHINFO_EXTENSION),
                        'associated_id' => $folderId,
                        'created_at'    => date('Y-m-d H:i:s')
                    ]);
                    $collectionsImagesTable->save($imageEntity);
                    echo "<pre>New Image Added: ";print_r($relativePath);echo "</pre>";
                } else {
                    echo "<pre>Image Already Exist: ";print_r($relativePath);echo "</pre>";
                }
            }
        }
    }

    private function isImage($filename)
    {
        $extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
        return in_array(strtolower(pathinfo($filename, PATHINFO_EXTENSION)), $extensions);
    }

    private function isIgnored($name)
    {
        return substr($name, 0, 1) === '.'; // Ignore if name starts with "."
    }

    public function startScan()
    {
        $rootPath = WWW_ROOT . 'uploads/collection/';
    
        $folder = new Folder($rootPath);
        $subfolders = $folder->read()[0]; // Get only directories
        echo "<pre>subfolders: ";print_r($subfolders);echo "</pre>";
        foreach ($subfolders as $subfolder) {
            if (!$this->isIgnored($subfolder)) {
                $this->scanAndSave($rootPath . DS . $subfolder, 0, 1);
            }
        }
    
        $this->Flash->success(__('Folders and images have been saved.'));
        return $this->redirect(['action' => 'index']);
    }
}
