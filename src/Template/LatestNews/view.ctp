<div class="container my-5">
    <div class="mx-auto text-secondary">
        <h1 class="font-weight-bold text-dark text-center"><?= h($post->post_title) ?></h1>
    </div>

    <?php if (!empty($post->image_url)) : ?>
        <img src="<?= h($post->image_url) ?>" alt="<?= h($post->post_title) ?>" class="blogImg img-fluid w-100 my-3">
    <?php else : ?>
        <img src="https://via.placeholder.com/800x400" alt="Placeholder Image" class="img-fluid">
    <?php endif; ?>

    <div class="mx-auto text-secondary">
        <?= $post->post_content ?>
    </div>

    <a href="/latest-news" class="btn btn-primary mt-4">Back to Latest News</a>
</div>
