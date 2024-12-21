<div class="container portfolio-detail">
<h2>Project Comments</h2>
<?php
define('WP_USE_THEMES', false);
require('../wp/wp-blog-header.php');
?>

<?php
$args = array(
    'post__in' => array(152)
);

$posts = get_posts($args);
 
 
 print_r($posts[0]->post_content);
 
 
?>
</div>