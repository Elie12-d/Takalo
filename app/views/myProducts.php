<section class="grid-blog-post-area blog_style2 pt-120 pb-130">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center">
                    <h3 class="title wow fadeInUp" data-wow-delay=".2s">Listes de mes produits</h3>
                    <p class="wow fadeInUp" data-wow-delay=".4s">Vous pouvez les modifier en cliquant sur <br> le bouton modifier </p>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
        <div class="row">
            <?php foreach ($objects as $object) { ?>
                <div class="col-lg-4">
                    <div class="blog-card mt-30 mb-30 wow fadeInUp" data-wow-delay=".2s">
                        <div class="blog-image">
                            <img src="<?= BASE_URL ?>/assets/images/blog/1.jpg" alt="post">
                        </div>
                        <div class="post-meta py-3">
                            <ul class="list-unstyled">
                                <li><a href=""><i class="flaticon-user mx-2 ml-0"></i><?= $object['username'] ?></a></li>
                                <li><a href=""><i class="flaticon-calendar mx-2"></i><?= $object['published_at'] ?></a></li>
                            </ul>
                        </div>
                        <div class="blog-content">
                            <h5 class="blog-title"><a href="blog-details.html"><?= $object['name'] ?></a></h5>
                            <p><?= $object['description'] ?></p>
                            <a class="btn main-btn btn-inline" href="blog-details.html">Modifier</a>
                        </div>
                    </div> <!-- blog card -->
                </div>
            <?php } ?>
        </div> <!-- row -->
    </div> <!-- container -->
</section>