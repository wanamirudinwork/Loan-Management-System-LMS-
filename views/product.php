<!-- Product Detail -->
    <div class="container bgwhite p-t-35 p-b-80 m-t-80">
        <div class="flex-w flex-sb">
            <div class="w-size13 p-t-30 respon5">
                <div class="wrap-slick3 flex-sb flex-w">
                    <div class="wrap-slick3-dots"></div>
                    <?php
                        $image = current($images);
                    ?>
                    <div class="slick3">
                        <div class="item-slick3" data-thumb="<?php echo imgCrop($image['src'], 470, 470); ?>">
                            <div class="wrap-pic-w">
                                <img src="<?php echo imgCrop($image['src'], 470, 470); ?>" alt="<?php echo $image['alt']; ?>">
                            </div>
                        </div>

                        <div class="item-slick3" data-thumb="<?php echo imgCrop($image['src'], 470, 470); ?>">
                            <div class="wrap-pic-w">
                                <img src="<?php echo imgCrop($image['src'], 470, 470); ?>" alt="<?php echo $image['alt']; ?>">
                            </div>
                        </div>

                        <div class="item-slick3" data-thumb="<?php echo imgCrop($image['src'], 470, 470); ?>">
                            <div class="wrap-pic-w">
                                <img src="<?php echo imgCrop($image['src'], 470, 470); ?>" alt="<?php echo $image['alt']; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-size14 p-t-30 respon5">
                <h4 class="product-detail-name m-text16 p-b-13">
                    <?php echo $product['title']; ?>
                </h4>

                <span class="m-text17">
                    <?php if($product['sale_price'] > 0){ ?>
                    <div class="price"><?php echo $cms->price($product['sale_price']); ?><div class="discount-off"><?php echo $product['discount']; ?>% OFF</div></div>
                    <div class="price-original">Original price: <?php echo $cms->price($product['price']); ?></div>
                    <?php }else{ ?>
                        <?php if($product['price'] >= 0){ ?><div class="price"><?php echo $cms->price($product['price']); ?></div><?php } ?>
                    <?php } ?>
                </span>

                <p class="s-text8 p-t-10">
                    <?php echo $product['description']; ?>
                </p>

                <!--  -->
                <div class="p-t-33 p-b-60">
                    <div class="flex-m flex-w p-b-10">
                        <div class="s-text15 w-size15 t-center">
                            Size
                        </div>

                        <div class="rs2-select2 rs3-select2 bo4 of-hidden w-size16">
                            <select class="selection-2" name="size">
                                <option>Choose an option</option>
                                <option>Size S</option>
                                <option>Size M</option>
                                <option>Size L</option>
                                <option>Size XL</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex-m flex-w">
                        <div class="s-text15 w-size15 t-center">
                            Color
                        </div>

                        <div class="rs2-select2 rs3-select2 bo4 of-hidden w-size16">
                            <select class="selection-2" name="color">
                                <option>Choose an option</option>
                                <?php foreach($colors as $i => $value){ $value['stock'] = !empty($value['stock']) ? $value['stock'] : 0; ?>
                                <option><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="flex-r-m flex-w p-t-10">
                        <div class="w-size16 flex-m flex-w">
                            <div class="flex-w bo5 of-hidden m-r-22 m-t-10 m-b-10">
                                <button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2">
                                    <i class="fs-12 fa fa-minus" aria-hidden="true"></i>
                                </button>

                                <input class="size8 m-text18 t-center num-product" type="number" name="num-product" value="1">

                                <button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2">
                                    <i class="fs-12 fa fa-plus" aria-hidden="true"></i>
                                </button>
                            </div>

                            <div class="btn-addcart-product-detail size9 trans-0-4 m-t-10 m-b-10">
                                <!-- Button -->
                                <?php echo $product['status'] == '1' ? '<button type="submit" class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">Add To Cart</button>' : '<button type="button" class="btn btn-danger" disabled>Sold Out!</button>'; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-b-45">
                    <span class="s-text8 m-r-35">SKU: MUG-01</span>
                    <span class="s-text8">Categories: Mug, Design</span>
                </div>

                <!--  -->
                <div class="wrap-dropdown-content bo6 p-t-15 p-b-14 active-dropdown-content">
                    <h5 class="js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">
                        Dimensions
                        <i class="down-mark fs-12 color1 fa fa-minus dis-none" aria-hidden="true"></i>
                        <i class="up-mark fs-12 color1 fa fa-plus" aria-hidden="true"></i>
                    </h5>

                    <div class="dropdown-content dis-none p-t-15 p-b-23">
                        <p class="s-text8">
                            <?php echo $product['size']; ?>
                        </p>
                    </div>
                </div>

                <div class="wrap-dropdown-content bo7 p-t-15 p-b-14">
                    <h5 class="js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">
                        Material
                        <i class="down-mark fs-12 color1 fa fa-minus dis-none" aria-hidden="true"></i>
                        <i class="up-mark fs-12 color1 fa fa-plus" aria-hidden="true"></i>
                    </h5>

                    <div class="dropdown-content dis-none p-t-15 p-b-23">
                        <p class="s-text8">
                            <?php echo $product['material']; ?>
                        </p>
                    </div>
                </div>

                <div class="wrap-dropdown-content bo7 p-t-15 p-b-14">
                    <h5 class="js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">
                        More Details
                        <i class="down-mark fs-12 color1 fa fa-minus dis-none" aria-hidden="true"></i>
                        <i class="up-mark fs-12 color1 fa fa-plus" aria-hidden="true"></i>
                    </h5>

                    <div class="dropdown-content dis-none p-t-15 p-b-23">
                        <p class="s-text8">
                            <?php echo $product['description2']; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>