<?php
include 'config.php';
$b2c_blogs = ($_POST['data']!='')?$_POST['data']:[];
$blog = (sizeof($b2c_blogs)!=0) ? $b2c_blogs : [];
?>
<!-- Contact Section Start -->
<section class="ts-contact-section">
    <div class="container">
        <div class="ts-blog-content ts-all-blog-content">
            <div class="row">
                <?php
                for($blog_count=0;$blog_count<sizeof($blog);$blog_count++){
                    //Image
                    $url = $blog[$blog_count]['image'];
                    $pos = strstr($url,'uploads');
                    if ($pos != false)   {
                        $newUrl = preg_replace('/(\/+)/','/',$url); 
                        $newUrl1 = BASE_URL.str_replace('../', '', $newUrl);
                    }
                    else{
                        $newUrl1 =  $url; 
                    }
                    $title = $blog[$blog_count]['title'];
                    $description = substr($blog[$blog_count]['description'], 0, 1000);
                    if($description != ''){
                        ?>
                        <div class="col col-12 col-md-12 col-lg-12">
                            <div class="ts-blog-card">
                                <div class="ts-blog-card-img">
                                    <a href="single-blog.php?blog_id=<?=$blog[$blog_count]['entry_id']?>" target="_blank" class="ts-blog-card-img-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M500.3 443.7l-119.7-119.7c27.22-40.41 40.65-90.9 33.46-144.7c-12.23-91.55-87.28-166-178.9-177.6c-136.2-17.24-250.7 97.28-233.4 233.4c11.6 91.64 86.07 166.7 177.6 178.9c53.81 7.191 104.3-6.235 144.7-33.46l119.7 119.7c15.62 15.62 40.95 15.62 56.57 .0003C515.9 484.7 515.9 459.3 500.3 443.7zM288 232H231.1V288c0 13.26-10.74 24-23.1 24C194.7 312 184 301.3 184 288V232H127.1C114.7 232 104 221.3 104 208s10.74-24 23.1-24H184V128c0-13.26 10.74-24 23.1-24S231.1 114.7 231.1 128v56h56C301.3 184 312 194.7 312 208S301.3 232 288 232z" fill="#ffffff"/></svg>
                                    </a>
                                    <img src="<?= $newUrl1 ?>" alt="north-goa-1" class="img-fluid">
                                </div>
                                <div class="ts-blog-card-body">
                                    <!-- <div class="ts-blog-info">
                                        <p class="ts-blog-time">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <a href="#">12 Jan 2022</a>
                                        </p>
                                        <p class="ts-blog-time">
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a href="#">Tags Works, Personal</a>
                                        </p>
                                        <p class="ts-blog-time ml-auto">
                                            <i class="fa fa-comments-o" aria-hidden="true"></i>
                                            <a href="#">33</a>
                                        </p>
                                    </div> -->
                                    <a href="single-blog.php?blog_id=<?=$blog[$blog_count]['entry_id']?>" target="_blank" class="ts-blog-card-title"><?= $title ?></a>
                                    <!--<p class="ts-blog-card-description">-->
                                    <div class="custom_texteditor"><?= $description ?></div>
                                    <!--</p>-->
                                </div>
                                <div class="ts-blog-card-footer">
                                    <a href="single-blog.php?blog_id=<?=$blog[$blog_count]['entry_id']?>" target="_blank" class="ts-blog-card-link"> READ MORE</a>
                                </div>
                            </div>
                        </div>
                        <?php 
                    }
                } ?>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->