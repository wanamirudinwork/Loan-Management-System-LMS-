<!-- Content page -->
<section class="bgwhite p-t-55 p-b-65 m-t-80">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
                <div class="leftbar p-r-20 p-r-0-sm">
                    <!--  -->
                    <h4 class="m-text14 p-b-7">
                        Categories
                    </h4>

                    <ul class="p-b-54">
                        <li class="p-t-4">
                            <a href="#" class="s-text13 active1">
                                All
                            </a>
                        </li>

                        <li class="p-t-4">
                            <a href="#" class="s-text13">
                                Women
                            </a>
                        </li>

                        <li class="p-t-4">
                            <a href="#" class="s-text13">
                                Men
                            </a>
                        </li>

                        <li class="p-t-4">
                            <a href="#" class="s-text13">
                                Kids
                            </a>
                        </li>

                        <li class="p-t-4">
                            <a href="#" class="s-text13">
                                Accesories
                            </a>
                        </li>
                    </ul>

                    <div class="search-product pos-relative bo4 of-hidden">
                        <input class="s-text7 size6 p-l-23 p-r-50" type="text" name="search-product" placeholder="Search Products...">

                        <button class="flex-c-m size5 ab-r-m color2 color0-hov trans-0-4">
                            <i class="fs-12 fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-8 col-lg-9 p-b-50">
                <!--  -->
                <div class="flex-sb-m flex-w p-b-35">
                    <div class="flex-w">
                        <div class="rs2-select2 bo4 of-hidden w-size12 m-t-5 m-b-5 m-r-10">
                            <select class="selection-2" name="sorting">
                                <option>Default Sorting</option>
                                <option>Popularity</option>
                                <option>Price: low to high</option>
                                <option>Price: high to low</option>
                            </select>
                        </div>

                        <div class="rs2-select2 bo4 of-hidden w-size12 m-t-5 m-b-5 m-r-10">
                            <select class="selection-2" name="sorting">
                                <option>Price</option>
                                <option>$0.00 - $50.00</option>
                                <option>$50.00 - $100.00</option>
                                <option>$100.00 - $150.00</option>
                                <option>$150.00 - $200.00</option>
                                <option>$200.00+</option>

                            </select>
                        </div>
                    </div>

                    <span class="s-text8 p-t-5 p-b-5">
                        Showing 1–12 of 16 results
                    </span>
                </div>

                <!-- Product -->
                <?php if($products){  ?>
                <div class="row">
                    <?php
                        foreach($products as $product){
                            echo $cms->productBox($product);
                        }
                    ?>
                </div>
                <?php }else{ ?>
                <div class="c margintb"><i>There is no product in this category.</i></div>
                <?php } ?>

                <!-- Pagination -->
                <div class="pagination flex-m flex-w p-t-26">
                    <a href="#" class="item-pagination flex-c-m trans-0-4 active-pagination">1</a>
                    <a href="#" class="item-pagination flex-c-m trans-0-4">2</a>
                </div>
            </div>
        </div>
    </div>
</section>