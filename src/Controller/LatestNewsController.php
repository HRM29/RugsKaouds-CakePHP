<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query;
use Cake\View\Helper\SessionHelper;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\Http\Client;
class LatestNewsController extends AppController
{
    public function initialize()
	{
		parent::initialize();
		$this->loadComponent('RequestHandler');
		$this->loadComponent('Flash');
		$this->viewBuilder()->setLayout('front');
	}

	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Auth->allow(['index','view']);

	}
    public function index()
    {
        $postsTable = TableRegistry::getTableLocator()->get('wp_posts');
        $postmetaTable = TableRegistry::getTableLocator()->get('wp_postmeta');
    

        $posts = $postsTable->find()
            ->select(['ID', 'post_title', 'post_name', 'post_date', 'post_content'])
            ->where(['post_status' => 'publish', 'post_type' => 'post'])
            ->order(['post_date' => 'DESC'])
            ->toArray();

        foreach ($posts as &$post) {
            $thumbnail = $postmetaTable->find()
                ->select(['meta_value'])
                ->where(['post_id' => $post->ID, 'meta_key' => '_thumbnail_id'])
                ->first();
    
            $post->image_url = 'https://via.placeholder.com/600x400'; // Default image
    
            if ($thumbnail) {
                $attachment = $postsTable->find()
                    ->select(['guid'])
                    ->where(['ID' => $thumbnail->meta_value, 'post_type' => 'attachment'])
                    ->first();
    
                if ($attachment) {
                    $post->image_url = $attachment->guid;
                }
            }
        }
    
        $this->set(compact('posts'));
    }

    
    public function view($slug = null)
    {
        $postsTable = TableRegistry::getTableLocator()->get('wp_posts');
        $postmetaTable = TableRegistry::getTableLocator()->get('wp_postmeta');
    
        $post = $postsTable->find()
            ->select(['ID', 'post_title', 'post_content', 'post_date'])
            ->where(['post_name' => $slug, 'post_status' => 'publish', 'post_type' => 'post'])
            ->first();
    
        if (!$post) {
            return $this->redirect(['action' => 'index']);
        }

        $thumbnail = $postmetaTable->find()
            ->select(['meta_value'])
            ->where(['post_id' => $post->ID, 'meta_key' => '_thumbnail_id'])
            ->first();
    
        $post->image_url = 'https://via.placeholder.com/800x400';
    
        if ($thumbnail) {
            $attachment = $postsTable->find()
                ->select(['guid'])
                ->where(['ID' => $thumbnail->meta_value, 'post_type' => 'attachment'])
                ->first();
    
            if ($attachment) {
                $post->image_url = $attachment->guid;
            }
        }

        $metaTitle = $postmetaTable->find()
            ->select(['meta_value'])
            ->where(['post_id' => $post->ID, 'meta_key' => '_yoast_wpseo_title'])
            ->first();
        
        $metaDescription = $postmetaTable->find()
            ->select(['meta_value'])
            ->where(['post_id' => $post->ID, 'meta_key' => '_yoast_wpseo_metadesc'])
            ->first();
    
        $metaKeywords = $postmetaTable->find()
            ->select(['meta_value'])
            ->where(['post_id' => $post->ID, 'meta_key' => '_yoast_wpseo_focuskw'])
            ->first();
    
        $post->meta_title = $metaTitle ? $metaTitle->meta_value : $post->post_title;
        $post->meta_description = $metaDescription ? $metaDescription->meta_value : substr(strip_tags($post->post_content), 0, 160);
        $post->meta_keywords = $metaKeywords ? $metaKeywords->meta_value : '';
		$seoTitle = $metaTitle ? $metaTitle->meta_value : $post->post_title;;
		$seoDescription = $metaDescription ? $metaDescription->meta_value : substr(strip_tags($post->post_content), 0, 160);
		$seoKeyword = $metaKeywords ? $metaKeywords->meta_value : '';

		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
        $this->set(compact('post'));
    }

}
?>
