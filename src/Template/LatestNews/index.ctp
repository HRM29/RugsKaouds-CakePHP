<div class="container">
    <h1 class="text-center my-4">Latest News</h1>

    <div class="row">
        <?php foreach ($posts as $post): ?>
            <div class="col-md-4 p-3">
                <a href="/latest-news/<?= h($post->post_name) ?>">
                    <div class="position-relative" style="height: 280px; background-image: url(<?= h($post->image_url) ?>); background-position: center; background-size: cover;">
                        <div class="position-absolute p-3 d-flex flex-column justify-content-end" style="background: linear-gradient(to bottom, transparent, rgba(0,0,0,1)); top:0; bottom:0; left:0; right:0;">
                            <h3 class="h6 text-white" style="line-height: 1.6;">
                                <?= h($post->post_title) ?>
                            </h3>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
