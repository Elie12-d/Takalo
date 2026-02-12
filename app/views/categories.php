<!--====== POPULAR CATEGORIES PART START ======-->
<section id="popular-categories" class="popular-categories-area  pt-120 pb-130">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center">
                    <h3 class="title wow fadeInUp" data-wow-delay=".4s">Notre Categories</h3>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Clicque sur l'un des categories pour voir plus precisement <br> ce que vous chercher.</p>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
        <div class="row pt-25">
            <!-- Start ads grid -->
             <?php foreach ($categories as $categorie) { ?>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="ads-grid text-center wow fadeInUp" data-wow-delay=".2s">
                    <div class="thumb-area">
                        <div class="thumb">
                            <a href=""><img src="<?= BASE_URL ?>/assets/images/ads/popular/01.jpg" class="img-fluid"></a>
                        </div>
                        <span class="ads-counter counter">214 </span>
                    </div>
                    <div class="content pt-45">
                        <h4><a href="<?= BASE_URL ?>/products/lists?category=<?= $categorie['id'] ?>"><?= $categorie['name'] ?></a></h4>
                    </div>
                </div>
            </div>
            <?php } ?>
            <!-- End ads grid -->
        </div> <!-- row -->
    </div> <!-- container -->
</section>