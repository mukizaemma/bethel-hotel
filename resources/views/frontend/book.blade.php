<div class="public-livewire-page">


<style>
    #myModalPromotion{
        display: none;
    }
    
    @media (min-width: 0px) {
    /*.modal-dialog,*/ #image-lightbox .modal-dialog /*, #image-lightbox .vue-lightbox img*/{
        //width: 100% !important;
        max-width: 100% !important;
    }
    
    #myModalPromotion #image-lightbox .modal-dialog, #myModalPromotion .vue-lightbox img{
        //max-content: none !important;
        max-width: 100% !important;
        //width: 100% !important;
        
    }
    
    #promotion-app img{
        width: 100% !important;
    }
    
    #promotion-app .vue-card.slide{
        display: grid;
        grid-template-columns: 1fr 1fr;
    }
    
    #promotion-app .vue-offers-card {
        //width: 20% !important;
    }
    
    #promotion-app #image-lightbox .vue-lightbox img{
        width: 100% !important;
    }
    
    #myModalPromotion .modal-dialog.modal-lg {
    width: 100% !important;
    }
    
    
    
    
    
    }
    
    #myModalPromotion #myModal{
        
        display: flex !important;
        padding-left: 0px;
        justify-content: center;
        /* align-content: center; */
        align-items: center;
    }
    
    #myModalPromotion #myModal #image-lightbox{
        width: 100%;
    }
    
    
    
    @media (min-width: 768px) {
    .col-md-4, 
    .col-md-8
    {
        max-width: 100% !important;
    }
    }
    
    
    #promotion-app{
        width: 100%;
    }
    
    #myModalPromotion .content-body{
        width: 80%;
        margin-left: auto;
        margin-right: auto;
    }
    
    
    
    
    .row > .col-md-9{
        flex: 1 !important;
        max-width: 100% !important;
    }
    .vue-card-unit-title{
        border: none !important;
    }
    
    .row{
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    //lightbox
    //problem with centering, other pages still
    .vue-content-body > .row{
        //width: 95% !important;
    }
    
    
    .container.bv-example-row.room-list.vue-content-body{
        display: flex;
        justify-content: center;
    }
    
    .col-md-4.col-sm-12.col-xs-12{
        padding-left: 0px !important;
    }
    
    .card-img-top:hover{
        transform: none !important;
    }
    
    .promotion-panel{
        position: fixed;
        left: 0px;
        bottom: 0px;
        padding-bottom: 0px;
        //padding-left: 30px;
        padding-left: 0px;
        width: 200px !important;
    }
    
    .promotion-panel.open{
        left: 0px;
    }
    
    .promotion-on-panel{
        //position: fixed;
        position: absolute;
        bottom: 0px;
        left: 225px;
        
        
    }
    
    .vue-offers-card-body{
        background-color: white;
    }
    
    .container.bv-example-row.room-list.vue-content-body{
        display: block;
    }
    
    
    /* own */
    
    
    .view_images{
        display: none !important;
    }
    
    .vue-card-unit{
        
        box-shadow: 0 15px 75px 0 rgba(0,0,0,.07) !important;
        
    }
    
    .vue-card-unit-title{
        background-image: none !important;
        background-color: white !important;
        /*
        padding-left: 5px !important;
        padding-top: 5px !important;
        padding-right: 5px !important;
        */
    }
    
    #booking-widget > .container,
    #booking-widget > .container > .row {
        width: 100% ;
        max-width: 100%;
    }
    
    .vue-card-unit > div > .row{
        display: grid !important;grid-template-columns: 1fr 1fr;
    }
    
    /*change for media max 500px so that image is aboeve*/
    
    
    
    /* own */
    
    .modal-backdrop.show {
      display: none !important;
    }
    #myModal {
      background: #0009;
    }
    .fade {
      opacity: 1;
    }
    .breadcrumb { background: none }
    
    #booking-widget .vue-btnbb {
      padding: 0;
    }
    
    /*** Side card */
    .vue-offers-card .card-img-top:hover {
      transform: scale(4) translate(-5rem,-3rem);
      transition: transform .4s ease;
    }
    #booking-widget .vue-right-side {
      margin: unset;
    }
    #booking-widget #vue-dropdown-home.dropdown-menu {
        width: fit-content;
    }
    svg,
    #booking-widget h1.room-title,
    #booking-widget h2 {
      margin-bottom: 0em;
      color: #086634;
    }
    
    #booking-widget .notify-container .fa, 
    #booking-widget .notify-container h4.notify-title, 
    #booking-widget .notify-text span.timerspan,
    #modalbookingForm .modal-header { 
      color: #086634 !important;
    }
    
    #booking-widget .vue-date-box label,
    #booking-widget .content-body,
    #booking-widget .vue-content-body, 
    #booking-widget p, #booking-widget span {
      font-family: "Barlow", sans-serif !important;
      font-weight: 700;
    }
    
    #booking-widget .reserveport-form-wrap h3,
    #booking-widget h1.room-title,
    #booking-widget h2, .modal-title, 
    #booking-widget .vue-side_top_card h3 {
      font-family: "Gilda Display", serif;
    }
    
    #booking-widget a, #booking-widget .show-cp:hover,
    #booking-widget .vue-show-details:hover,
    #booking-widget .vue-show-tc:hover,
    #vue-havepromo.vue-horizontal,
    #booking-widget h1.room-title:hover {
      color: #014B23;
    }
    
    #booking-widget h2 {
      font-size: 2.5rem;
    }
    
    label.checkmark {
      position: relative;
    }
    
    #booking-widget .vue-date-box[data-v-07c68727] {
      box-shadow: 0 0 12px 5px rgba(0, 0, 0, .1);
      transition: all 0.3s ease-in-out;
    }
    
    #booking-widget .icon {
      position: relative;
      width: 100%;
    }
    
    #booking-widget label {
      font-weight: normal;
    }
    
    #vue-toggle_residency .vue-btn, 
    #booking-widget button,
    #booking-widget .btn-orange-solid,
    #vue-toggle_residency .vue-btn.active,
    #booking-widget .btn-solid,
    #booking-widget .sub-total .btn.btn-solid,
    #booking-widget .vue-btn-proceed {
      border: 1px solid #014B23!important;
      color: #014B23 !important;
      background: none !important;
      transition: all 0.3 ease;
      text-transform: uppercase;
      font-weight: 600;
      border-radius: 3px;
    }
    
    .mx-calendar-content .cell.active,
    #booking-widget .btn-orange-solid:hover,
    #vue-toggle_residency .vue-btn.active:hover,
    #booking-widget .btn-solid:hover,
    #booking-widget .sub-total .btn.btn-solid:hover,
    #booking-widget .vue-btn-proceed:hover, 
    button#submitFormBtn:hover,
    #vue-btn-managebooking:hover {
      background-color: #014B23 !important;
      color: white !important;
    }
    
    #booking-widget .hotel .notify-container, #booking-widget .reserveport-iframe-wrap .notify-container,
    #booking-widget #alert-msg.ui-pnotify.ui-pnotify-inline {
      background: #13172B !important;
    }
    
    #modalbookingForm {
      padding-top: 4rem;
    }
    #booking-widget .responsive {
      max-width: unset;
    }
    
    .owl-carousel .owl-item img, #booking-widget .room-full-slider img {
      max-height: 400px;
      object-fit: cover;
      margin: auto;
    }
    
    #bedimg, booking-widget .pull-right img {
      filter: brightness(0) saturate(100%) invert(25%) sepia(0%) saturate(0%) hue-rotate(254deg) brightness(98%) contrast(89%);
    }
    
    #booking-widget .room-title-details.row,
    #booking-widget .room-title-details .pull-right, figure {
      display: flex;
    }
    
    #booking-widget .room-title-details .pull-right .btn-solid {
      margin-left: auto;
      left: 0;
      bottom: 0;
    }
    
    #booking-widget .room-view .room .room-details {
      position: relative;
    }
    
    #image-lightbox {
      display: flex;
      justify-content: center;
    }
    
    #image-lightbox .row {
      margin-left: 0 !important;
    }
    
    #booking-widget #vue-smallScreen input, #booking-widget #vue-smallScreen .vue-small_large_select {
      text-transform: uppercase;
      font-size: 1em;
    }
    
    #booking-widget .close, #myModalPromotion .close {
    padding: 4px 6px;
    background: white;
    border: 1px solid #014b23;
    opacity: 1;
    margin-top: 6px !important;
    background-color: #21603d !important;
    color: white !important;
    z-index: 100000;
    }
    
    
    
    #modalbookingForm button.close {
      border: none;
    }
    
    
    
    #image-lightbox .modal-dialog, #image-lightbox .vue-lightbox img {
      width: max-content;
      max-width: 800px;
    }
    
    @media only screen and (max-width: 600px) {
      #image-lightbox .modal-dialog {
        position: relative;
        transform: translate(0%, 0%) !important;
        left: 0;
        max-width: none;
      }
      .vue-mobile .col-md-6.col-xs-6 {
        width: 50%;
      }
    
      #image-lightbox .row {
        margin-right: 0;
      }
    
      #image-lightbox .vue-lightbox img {
        width: 100%;
      }
    
      .room-full-slider {
          width: 576px;
      }
    }
    
    </style>

    

<section class="page-header bg--cover" style="background-image: url(images/slider-1.jpg)">
    <div class="container">
      <div class="page-header__content text-center">
        <h2>Booking Page</h2>

      </div>
    </div>
</section>

<section class="room padding-top padding-bottom">
    <!--<div class="container">-->
      <div class="room__wrapper">
        <booking-widget id="1751"></booking-widget>
      </div>
    <!--</div>container-->
  </section>


  <!--rendered in case there is a discount -->
<div id="myModalPromotion">
    <div id="myModal" tabindex="-1" role="dialog" class="modal fade show" style="display: block; padding-left: 0px;" aria-modal="true"><div id="image-lightbox"><div role="document" class="modal-dialog modal-lg"><div class="modal_content"><div class="content-body"><button type="button" data-dismiss="modal" class="close" onclick="closeMyModalPromotion()">×</button> <div class="row"><div id="promotion-app" class="vue-lightbox" style="background-color: green">
    <!--<img src="https://join.reserveport.com/api/uploads/79V1Zt8f5ihrxwKC6x777/view" alt="">--></div> </div></div></div></div></div></div>
    </div>

<div onclick="openMyModalPromotion()" class="promotion-panel">
    
<div ><img  src="/images/promotion-label.png"/></div>

</div>
</div>
