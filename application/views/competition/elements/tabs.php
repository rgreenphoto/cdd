<ul class="nav nav-pills" id="myTab">
  <li><a href="#reginfo" data-toggle="tab">Registration Info</a></li>
  <li class="active"><a href="#location" data-toggle="tab">Park/Location</a></li>
  <?php if(!empty($event->hotel_name)): ?>
  <li><a href="#hotel" data-toggle="tab">Hotel Info</a></li>
  <?php endif; ?>
</ul>

<div class="tab-content">
  <div class="tab-pane" id="reginfo">  
      <?php $this->load->view('competition/elements/registration'); ?>
  </div>
  <div class="tab-pane active" id="location">
      <?php //$this->load->view('competition/elements/location'); ?>
          <?php if(!empty($event->lat_long)): ?>
           <div id="map" style="height:250; min-width:250px;"></div>
           <?php endif; ?>
  </div>
    <?php if(!empty($event->hotel_name)): ?>
        <div class="tab-pane" id="hotel">
            <?php $this->load->view('competition/elements/hotel'); ?>
        </div>
    <?php endif; ?>
</div>
<script>
        function initialize() {
            console.log('init');
            var val = $('#id');
            console.log(val);
            var myLatlng = new google.maps.LatLng(<?php echo $event->lat_long; ?>);
            var mapOptions = {
                zoom: 8,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            var map = new google.maps.Map(document.getElementById('map'), mapOptions);

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: 'Hello World!'
            });
            var infowindow = new google.maps.InfoWindow({
                content: '<?php echo $event->location; ?>'
            });
            infowindow.open(map,marker);
        }
        google.maps.event.addDomListener(window, 'load', initialize);     
    $(document).ready(function() {         
        $('#myTab a').click(function(e) {
            target = $(this).attr('href');
            console.log(target);
//            var myMap = document.getElementById('map');
//            initialize();
//            switch(target) {
//                case '#location':
//                    lat_long = "<?php echo $event->lat_long; ?>";
//                    break;
//                case '#hotel':
//                    lat_long = "<?php echo $event->hotel_lat_long ?>";
//                    break;
//            }
//             $(target).gmap3({
//                action: 'init',
//                map: {
//                    options: {
//                        center: [lat_long],
//                        zoom: 14,
//                        scrollwheel: false
//                    }                
//                },
//                marker: {
//                    latLng: [lat_long],
//                    options: {
//                        icon: "http://maps.google.com/mapfiles/marker_green.png",
//                        animation: google.maps.Animation.DROP
//                    }
//                }
//
//            });            
        });    
    });
    
</script>