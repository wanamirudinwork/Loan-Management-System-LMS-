<!-- Title Page -->
  <section class="bg-title-page p-t-40 p-b-50 flex-col-c-m m-t-80" style="background-color: #222;">
    <h2 class="l-text2 t-center">
      <?php echo $page['title']; ?>
    </h2>
  </section>

  <!-- content page -->
  <section class="bgwhite p-t-66 p-b-60">
    <div class="container">
      <?php if($page['type'] == 'contact-us'){ ?>
      <div class="row">
        <div class="col-md-6 p-b-30">
          <div class="p-r-20 p-r-0-lg">
            <!-- <div class="contact-map size21" id="google_map" data-map-x="40.614439" data-map-y="-73.926781" data-pin="images/icons/icon-position-map.png" data-scrollwhell="0" data-draggable="1"></div> -->
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.084356675091!2d101.60470641425836!3d3.072136897762827!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4c8776586d9b%3A0x5e19a549d4f26f25!2sSunway+Pyramid!5e0!3m2!1sen!2smy!4v1532399903800" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
          </div>
        </div>

        <div class="col-md-6 p-b-30 text-center">
          <form class="leave-comment">
            <h4 class="m-text26 p-b-36 p-t-15">
              Send us your enquiry / feedback
            </h4>

            <div class="of-hidden size15 m-b-10 m-l-20">            
              <select class="form-control" name="enquiry" required>
                <option value="General Enquiry">General Enquiry</option>
                <option value="Product  Enquiry">Product  Enquiry</option>
                <option value="Feedback">Feedback</option>
                <option value="Others">Others</option>
              </select>
            </div>

            <div class="offset-sm-3 bo4 of-hidden size15 m-b-20 m-l-20">
              <input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="firstname" placeholder="First Name" required>
            </div>

            <div class="bo4 of-hidden size15 m-b-20 m-l-20">
              <input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="lastname" placeholder="Last Name" required>
            </div>

            <div class="bo4 of-hidden size15 m-b-20 m-l-20">
              <input class="sizefull s-text7 p-l-22 p-r-22" type="email" name="email" placeholder="Email Address" required>
            </div>

            <div class="bo4 of-hidden size15 m-b-20 m-l-20">
              <input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="contact" placeholder="Contact Number" required>
            </div>

            <textarea class="dis-block s-text7 size20 bo4 p-l-22 p-r-22 p-t-13 m-b-20 m-l-20" name="message" placeholder="Message"></textarea>

            <div class="w-size25">
              <!-- Button -->
              <button class="flex-c-m size2 bg1 bo-rad-23 hov1 m-text3 trans-0-4 m-l-240" type="submit">
                Send
              </button>
            </div>
          </form>
        </div>
        <div class="col-md-6">
                        <?php echo $page['content']; ?>
                    </div>
                </div>
                <?php }else{ ?>
                <?php echo $page['content']; ?>
                <?php } ?>
      </div>
    </div>
  </section>