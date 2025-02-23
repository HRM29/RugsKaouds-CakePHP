<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email;
use Cake\Core\Configure;
use Cake\View\Helper\SessionHelper;
use Cake\Controller\Component\PaginatorComponent;
use Cake\Network\Request;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Routing\Router;
use Cake\Http\Exception\BadRequestException;
use Cake\Event\EventInterface;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class MediaUploadController extends AppController
{

	/**
	 * Initialization hook method.
	 *
	 * Use this method to add common initialization code like loading components.
	 *
	 * @return void
	 */
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
		$this->getEventManager()->off($this->Csrf);

	}



	/* for clear search */
	public function clearSearch($action = null)
	{
		$this->autoRender = false;
		$url = $_SERVER['HTTP_REFERER'];
		$newUrl = explode('?', $url);
		$this->redirect($newUrl[0]);
	}


	/**
	 * @List
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param integer $id
	 * @return void
	 */


	public function index()
	{
		$title = 'Media Upload';
		if ($this->request->is(['post', 'put'])) {
			$postdata = $this->request->getData();
			$params = array();
			if (!empty($this->request->getData()['title'])) {
				$params['file_name_filter'] = base64_encode($this->request->getData()['title']);
			}

			if (!empty($this->request->getData()['media_type'])) {
				$params['filter'] = base64_encode($this->request->getData()['media_type']);
			}
			return $this->redirect([
				'controller' => 'MediaUpload',
				'action' => 'index',
				'?' => $params
			]);
		} else {
			$uploadPath = WWW_ROOT . 'uploads' . DS . 'media-library' . DS;
			$folder = new Folder($uploadPath);

			// Get filter parameters from query
			$filter = $this->request->getQuery('filter', '');  // Extension filter
			if (!empty($filter)) {
				$filter = base64_decode($filter);
			}
			$fileNameFilter = $this->request->getQuery('file_name_filter', ''); // Filename filter
			if (!empty($fileNameFilter)) {
				$fileNameFilter = base64_decode($fileNameFilter);
			}
			// Define allowed file extensions
			$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];

			// Handle file type filter (extension)
			if (!empty($filter) && in_array($filter, $allowedExtensions)) {
				$pattern = '.*\.' . $filter;
			} else {
				$pattern = '.*\.(jpg|jpeg|png|gif|pdf)';
			}

			// Get all files based on the extension filter
			$files = $folder->find($pattern, true);
			rsort($files);  // Sort files by newest first

			// Apply filename filter if present
			if (!empty($fileNameFilter)) {
				$files = array_filter($files, function ($file) use ($fileNameFilter) {
					return stripos($file, $fileNameFilter) !== false;
				});
			}

			// Paginate manually
			$limit = 10; // Number of files per page
			$page = $this->request->getQuery('page', 1); // Get current page from URL
			$totalFiles = count($files);
			$totalPages = ceil($totalFiles / $limit);

			// Slice the array for pagination
			$offset = ($page - 1) * $limit;
			$paginatedFiles = array_slice($files, $offset, $limit);

			// Prepare media files array
			$mediaFiles = [];
			foreach ($paginatedFiles as $file) {
				$mediaFiles[] = [
					'name' => $file,
					'url' => Router::url('/', true) . 'media/view/media-file/' . $file
				];
			}

			// Pass data to the view
			$this->set(compact('mediaFiles', 'page', 'totalPages', 'totalFiles', 'filter', 'fileNameFilter'));
		}
	}


	/**
	 * @add
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param integer $id
	 * @return void
	 */

	public function add()
	{
		if ($this->request->is('post')) {
			$file = $this->request->getData('media-file');

			if (!empty($file['name'])) {
				$uploadPath = WWW_ROOT . 'uploads' . DS . 'media-library' . DS;

				$folder = new Folder($uploadPath, true, 0755);
				// Generate a custom filename (unique identifier)
				$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
				// Get current date and time
				$date = date('Ymd'); // Format: YYYYMMDD
				$time = date('His'); // Format: HHMMSS

				// Sanitize filename: Replace special characters and spaces with hyphens
				$sanitizedFilename = preg_replace('/[^a-zA-Z0-9]/', '-', pathinfo($file['name'], PATHINFO_FILENAME));
				$sanitizedFilename = strtolower($sanitizedFilename); // Convert to lowercase

				// Generate custom file name
				$customName = "{$date}-{$sanitizedFilename}-{$time}.{$ext}";
				$filePath = $uploadPath . $customName;

				if (move_uploaded_file($file['tmp_name'], $filePath)) {
					// Generate custom URL
					$mediaUrl = $this->request->getAttribute('webroot') . 'media/view/media-file/' . $customName;
					$this->set(compact('mediaUrl'));
					$this->Flash->success(__('File uploaded successfully.'));
				} else {
					$this->Flash->error(__('File upload failed.'));
				}
			} else {
				$this->Flash->error(__('Please select a file.'));
			}
		}
	}

	public function download($fileName)
	{
		// Set the path to the file (adjust the folder location as necessary)
		$uploadPath = WWW_ROOT . 'uploads' . DS . 'media-library' . DS;
		$filePath = $uploadPath . $fileName;

		// Check if the file exists
		if (!file_exists($filePath)) {
			throw new NotFoundException(__('File not found'));
		}

		// Get the file's extension
		$fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
		$fileNameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME);

		// Set response headers for file download
		$this->response = $this->response->withType($fileExtension)
			->withHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"')
			->withHeader('Content-Length', filesize($filePath));

		// Read and output the file
		$file = new File($filePath);
		$this->response->getBody()->write($file->read());

		// Stop the CakePHP view rendering
		return $this->response->withDownload($fileName);
	}

	public function delete($fileName)
	{
		$uploadPath = WWW_ROOT . 'uploads' . DS . 'media-library' . DS;
		$filePath = $uploadPath . $fileName;

		// Check if the file exists
		if (!file_exists($filePath)) {
			throw new NotFoundException(__('File not found'));
		}

		// Delete the file
		if (unlink($filePath)) {
			$this->Flash->success(__('The file has been deleted.'));
		} else {
			$this->Flash->error(__('Unable to delete the file.'));
		}

		// Redirect to the media index page after deletion
		return $this->redirect(['action' => 'index']);
	}
	public function viewMediaLib($mediaslug, $filename)
	{
		$folder_slug = [
			'media-file' => 'media-library',
			'footer-file' => 'header_footer'
		];
		$filePath = WWW_ROOT . 'uploads' . DS . $folder_slug[$mediaslug] . DS . $filename;
		if (file_exists($filePath)) {
			$this->response = $this->response->withFile($filePath);
			return $this->response;
		} else {
			$this->Flash->error(__('File not found.'));
			return $this->redirect(['action' => 'list']);
		}
	}

	public function uploadEditorFile()
	{
		$this->autoRender = false; // Disable CakePHP's default view rendering

		if ($this->request->is('post')) {
			$postdata = $this->request->getData();
			echo "<pre>postdata: ";print_r($postdata);echo "</pre>";

			$file = $this->request->getData('upload');

			if ($file && $file['error'] == 0) {
				$uploadPath = WWW_ROOT . 'uploads' . DS;
				$fileName = time() . '_' . $file['name']; // Unique file name
				$fullPath = $uploadPath . $fileName;

				if (move_uploaded_file($file['tmp_name'], $fullPath)) {
					$response = [
						"uploaded" => 1,
						"fileName" => $fileName,
						"url" => "/uploads/" . $fileName // URL for CKEditor
					];
				} else {
					$response = ["uploaded" => 0, "error" => ["message" => "Failed to upload file."]];
				}
			} else {
				$response = ["uploaded" => 0, "error" => ["message" => "No file uploaded."]];
			}

			echo json_encode($response);
		} else {
			throw new BadRequestException("Invalid request.");
		}
	}
}
