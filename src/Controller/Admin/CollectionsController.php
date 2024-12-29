<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Utility\Text;

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
    }

    public function beforeFilter(Event $event)
    {
        $this->viewBuilder()->setLayout('admin');
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
        $categoryOption = parent::returnCollectionCategory();
        $this->set(compact('categories', 'categoryOption', 'savesearch', 'title'));
    }

    public function add()
    {
        $title        =    'Add Collection';
        $collectionsTable = TableRegistry::getTableLocator()->get('Collections');
        $collectionsImagesTable = TableRegistry::getTableLocator()->get('collection_images');

        $collection        =    $collectionsTable->newEntity();
        $collCategoryList    =    parent::returnCollectionCategory();

        if ($this->request->is('post')) {
            $postData = $this->request->getData();
            $mappedData = [
                'collection_type' => $postData['collection-type'],
                'title' => $postData['title'],
                'status' => $postData['status']
            ];
            if ($postData['collection-type'] == 'page') {
                $mappedData['page_url'] = $postData['page_link'];
                $mappedData['meta_title'] = $postData['meta_title'];
                $mappedData['meta_description'] = $postData['meta_description'];
                $mappedData['meta_keywords'] = $postData['meta_keywords'];
            }

            $collectionsTable->patchEntity($collection, $mappedData);

            $saveImage = false;
            if ($postData['collection-type'] == 'page') {
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
                if ($postData['collection-type'] == 'category') {
                    $collection->parent_id = 0;
                } else if ($postData['collection-type'] == 'page') {
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
        $collCategoryList    =    parent::returnCollectionCategory();
        if ($this->request->is(['patch', 'put', 'post'])) {
            $postData = $this->request->getData();
            $mappedData = [
                'collection_type' => $postData['collection-type'],
                'title' => $postData['title'],
                'status' => $postData['status'],
                'parent_id' => 0
            ];
            if ($postData['collection-type'] == 'page') {
                $mappedData['meta_title'] = $postData['meta_title'];
                $mappedData['meta_description'] = $postData['meta_description'];
                $mappedData['meta_keywords'] = $postData['meta_keywords'];
                $mappedData['parent_id'] = $postData['collection-category'];
            }

            $collectionsTable->patchEntity($collection, $mappedData);
            $saveImage = false;
            if ($postData['collection-type'] == 'page') {
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
        $this->set(compact('collection', 'collCategoryList', 'title'));
    }

    public function view($id = null)
    {
        $title        =    'View Collection';
        $collectionsTable = TableRegistry::getTableLocator()->get('Collections');
        $collectionData    =    $collectionsTable->get($id);
        $this->set('collection', $collectionData);
        $this->set(compact('title'));
    }

    public function delete($id = null)
    {
        $collectionsTable    =    TableRegistry::getTableLocator()->get('Collections');
        $aCollection        =    $collectionsTable->get($id);
        if ($collectionsTable->delete($aCollection)) {
            $this->Flash->set('The collection has been deleted.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
        } else {
            $this->Flash->set('The collection could not be deleted. Please, try again.', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
        }
        return $this->redirect(['action' => 'index']);
    }

    public function deleteAll()
    {
        $this->autoRender    =    false;
        $collectionsTable        =    TableRegistry::getTableLocator()->get('Collections');
        if ($this->request->is(['post', 'put'])) {
            $newRecord    =    $this->request->getData()['user_chk'];
            foreach ($newRecord as $ids) {
                if ($ids > 0) {
                    $catData    =    $collectionsTable->get($ids);
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
}
