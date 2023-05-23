<?php include '../utils/func.php'?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
    <!--plugins-->
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />
    <script src="assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="assets/css/icons.css" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="assets/css/dark-theme.css" />
    <link rel="stylesheet" href="assets/css/semi-dark.css" />
    <link rel="stylesheet" href="assets/css/header-colors.css" />
    <title>Dashtrans - Bootstrap5 Admin Template</title>
    <script>var init = <?=file_get_contents('../init.json')?></script>
</head>

<body class="bg-theme bg-theme2">
<!--wrapper-->
<div class="wrapper toggled">
    <!--start header -->
    <header>

    </header>
    <!--end header -->

    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">

            <div class="row">
                <div class="col col-lg-9 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="row row-cols-auto g-3">
                                <div class="col">
                                    <button onclick="startListen()" type="button" class="btn btn-outline-info px-5 radius-30">▶</button>
                                </div>
                                <div class="col-12">
                                    <label for="inputAddress" class="form-label js_pre_container">Address</label>
                                    <textarea class="form-control js_container" id="inputAddress" placeholder="Address..." rows="3"></textarea>
                                </div>
                            </div>
                            <!--end row-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class="bx bx-home font-18 me-1"></i>
                                </div>
                                <div class="tab-title">Карта</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class="bx bx-user-pin font-18 me-1"></i>
                                </div>
                                <div class="tab-title">Амбиенс</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " data-bs-toggle="tab" href="#primarycontact" role="tab" aria-selected="true">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class="bx bx-microphone font-18 me-1"></i>
                                </div>
                                <div class="tab-title">Картинки</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " data-bs-toggle="tab" href="#primaryinit" role="tab" aria-selected="true">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class="bx bx-microphone font-18 me-1"></i>
                                </div>
                                <div class="tab-title">Инициатива</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " data-bs-toggle="tab" href="#primarygen" role="tab" aria-selected="true">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class="bx bx-microphone font-18 me-1"></i>
                                </div>
                                <div class="tab-title">Генераторы</div>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="tab-content py-3">
                    <div class="tab-pane fade active show" id="primaryhome" role="tabpanel">

                        <div class="row" style=" position: absolute;width: 90%">
                            <?php  $files = glob("../img/*.*");?>
                            <?php
                            $map = json_decode(file_get_contents('../map.json'),1);
                            foreach ($files as $num=>$filename) {
                                $temp = explode('/',$filename);
                                $id = md5(end($temp));
                                $checked = empty($map[$id])?'false':$map[$id];
                                ?>
                                <div class="input-group input-group-sm mb-3" style="width: 20%;z-index:100">
                                    <div class="input-group-text">
                                        <input <?php if($checked=='true'){?> checked<?php }?> class="form-check-input js_map_chunk" type="checkbox" value="<?=$id?>" aria-label="Checkbox for following text input">
                                    </div>
                                    <input type="text" class="form-control" aria-label="Text input with checkbox" value="<?php $arr = explode('_',$filename); echo end($arr)?>">
                                </div>
                            <?php } ?>

                        </div>
                        <div class="" style="position: relative;">
                            <?php
                            foreach ($files as $num=>$filename) {
                                $temp = explode('/',$filename);
                                $id = md5(end($temp));
                                $checked = empty($map[$id])?'false':$map[$id];
                                ?>
                                <img id="<?=$id?>"
                                     style="
                                             width: 100%;
                                             position:absolute;
                                             z-index: <?=count($files)-$num?>;
                                             opacity: <?=($checked=='true')?'1':'0.3'?>;
                                             " src="<?=$filename?>" class="d-block w-80 in_block" alt="...">
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
                        <div class="card-body">
                            <?php
                            $videos = json_decode(file_get_contents('../videos.json'));
                            foreach ($videos as $video=>$key){?>
                                <div class="form-check js_video">
                                    <input class="form-check-input" type="radio" name="selectVideo" >
                                    <input class="form-control" name="key" value="<?=$key?>" style="width: 88%; display: inline-block">
                                    <input class="form-control" name="video" value="<?=$video?>" style="width: 10%; display: inline-block">
                                </div>
                            <?php }?>
                            <div class="form-check js_video empty">
                                <input class="form-check-input" type="radio" name="selectVideo">
                                <input class="form-control" name="key" value="" style="width: 88%; display: inline-block">
                                <input class="form-control"  name="video" value="" style="width: 10%; display: inline-block">
                            </div>
                            <template id="new_video">
                                <div class="form-check js_video empty">
                                    <input class="form-check-input" type="radio" name="selectVideo">
                                    <input class="form-control" name="key" value="" style="width: 88%; display: inline-block">
                                    <input class="form-control"  name="video" value="" style="width: 10%; display: inline-block">
                                </div>
                            </template>
                            <div class="col">
                                <button type="button" class="btn btn-light js_save_videos">
                                    Save
                                </button>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="primarycontact" role="tabpanel">
                        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2">
                            <div class="col">
                                <h6 class="mb-0 text-uppercase">With controls</h6>
                                <hr/>
                                <div class="card">
                                    <div class="card-body">
                                        <div id="carouselExampleControls" class="carousel slide" data-bs-interval="false" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <?php  $files = glob("../demo/*.*");
                                                $active = 1;
                                                foreach ($files as $num=>$filename) {
                                                    ?>
                                                    <div class="carousel-item <?php if($active){$active=0;?>active<?php }?>">
                                                        <img src="<?=$filename?>" class="d-block w-100" alt="...">
                                                    </div>
                                                <?php }?>
                                            </div>
                                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">	<span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="mb-0 text-uppercase">With captions</h6>
                                <hr/>
                                <div class="card">
                                    <div class="card-body">
                                        <div id="carouselExampleCaptions" class="carousel slide" data-bs-interval="false" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <?php
                                                $images = json_decode(file_get_contents('../images.json'),1);
                                                $active = 1;
                                                foreach ($images as $name=>$image) {
                                                    ?>
                                                    <div class="carousel-item <?php if($active){$active=0;?>active<?php }?>">
                                                        <img src="<?=$image?>" class="d-block w-100" alt="...">
                                                        <div class="carousel-caption d-none d-md-block">
                                                            <h5><button class="js-show-demo" data-src="<?=$image?>"><i class="lni lni-display-alt"></i></button></h5>
                                                            <p><?=$name?></p>
                                                        </div>
                                                    </div>
                                                <?php }?>

                                            </div>
                                            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-bs-slide="prev">	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-bs-slide="next">	<span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="primaryinit" role="tabpanel">
                        <?php $init=json_decode(file_get_contents('../init.json'),1);?>
                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                            <div class="col">
                                <div class="card radius-10 bg-primary bg-gradient">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-white">Раунд</p>
                                                <h4 class="my-1 text-white js-init-round"><?=$init['round']?></h4>
                                            </div>
                                            <div class="text-white ms-auto font-35"><i class="bx bx-cart-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10 bg-danger bg-gradient">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-white">Ходит</p>
                                                <h4 class="my-1 text-white js-init-current"><?=getCurrentPlayer($init)?></h4>
                                            </div>
                                            <div class="text-white ms-auto font-35"><i class="bx bx-dollar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10 bg-warning bg-gradient">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-dark">Следующий ход</p>
                                                <h4 class="text-dark my-1 js-init-next"><?=getNextPlayer($init)?></h4>
                                            </div>
                                            <div class="text-dark ms-auto font-35"><i class="bx bx-user-pin"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10 bg-success bg-gradient">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-white">Резерв</p>
                                                <h4 class="my-1 text-white">пригодится</h4>
                                            </div>
                                            <div class="text-white ms-auto font-35"><i class="bx bx-comment-detail"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="input-group">
                                    <span class="input-group-text">Sur</span>
                                    <span class="input-group-text">Pl</span>
                                    <input type="text" value="Init" aria-label="First" class="form-control" style="max-width: 61px;" disabled readonly>
                                    <input type="text" value="Имя" aria-label="Last" class="form-control" disabled readonly>
                                </div>
                                <?php foreach ($init['all'] as $player){?>
                                    <div class="input-group js-init-row
                                     <?php if (getCurrentPlayer($init)==$player['name']){?>
                                            current
                                    <?php }?>
                                    <?php if (getNextPlayer($init)==$player['name']){?>
                                               next
                                    <?php }?>
                                       " >
                                        <div class="input-group-text">
                                            <input <?=(!empty($player['surprise']) && $player['surprise']=='true')?'checked':''?> class="form-check-input js-row-surprise" type="checkbox" value="" aria-label="Checkbox for following text input">
                                        </div>
                                        <div class="input-group-text">
                                            <input <?=($player['player']=='true')?'checked':''?> class="form-check-input js-row-player" type="checkbox" value="" aria-label="Checkbox for following text input">
                                        </div>
                                        <input type="text" aria-label="First" class="form-control  js-row-init" value="<?=$player['init']?>" style="max-width: 61px;">
                                        <input type="text" aria-label="Last" class="form-control js-row-name" value="<?=$player['name']?>">
                                        <button type="button" class="btn btn-light">ICON</button>
                                        <button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">	<span class="visually-hidden">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" style="margin: 0px; display: none">
                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="#">Separated link</a></li>
                                        </ul>
                                        <button type="button" class="btn btn-light js-remove-line"><i class="lni lni-trash"></i></i></button>
                                    </div>
                                <?php } ?>
                                <button type="button" class="btn btn-light" id="new_line"><i class="lni lni-circle-plus"></i></button>
                                <button type="button" class="btn btn-light" id="save_config"><i class="lni lni-save"></i></button>
                                <hr>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-light" id="init_reset"><i class="bx bx-rotate-right me-0"></i></button>
                                    <button type="button" class="btn btn-light" style="transform: rotate(180deg);"><i class="bx bx-up-arrow"></i></button>
                                    <button type="button" class="btn btn-light js-lets-play"><i class="bx bx-right-arrow"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="primarygen" role="tabpanel">
            
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!--end page wrapper -->
    <!--start overlay-->
    <div class="overlay toggle-icon"></div>
    <!--end overlay-->
    <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->
</div>
<!--end wrapper-->
<!--start switcher-->
<div class="switcher-wrapper">
    <div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
    </div>
    <div class="switcher-body">
        <div class="d-flex align-items-center">
            <h5 class="mb-0 text-uppercase">Theme Customizer</h5>
            <button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
        </div>
        <hr/>
        <p class="mb-0">Gaussian Texture</p>
        <hr>

        <ul class="switcher">
            <li id="theme1"></li>
            <li id="theme2"></li>
            <li id="theme3"></li>
            <li id="theme4"></li>
            <li id="theme5"></li>
            <li id="theme6"></li>
        </ul>
        <hr>
        <p class="mb-0">Gradient Background</p>
        <hr>

        <ul class="switcher">
            <li id="theme7"></li>
            <li id="theme8"></li>
            <li id="theme9"></li>
            <li id="theme10"></li>
            <li id="theme11"></li>
            <li id="theme12"></li>
        </ul>
    </div>
</div>
<!--end switcher-->
<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<!--app JS-->
<script src="assets/js/app.js"></script>
</body>

</html>
