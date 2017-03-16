<?php $location = get_field('g_map', 'option');
if (!empty($location)) { ?>
    <div id="map" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"
         data-marker="<?php the_field('marker', 'option'); ?>"></div>
<?php } ?>
<script>
    var map;
    var styles = [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#6d6d6d"}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#c8e08b"},{"visibility":"on"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#d6e5a7"},{"lightness":"19"},{"saturation":"29"}]},{"featureType":"landscape.natural.landcover","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"landscape.natural.landcover","elementType":"geometry","stylers":[{"color":"#d6e5a7"},{"visibility":"on"}]},{"featureType":"landscape.natural.landcover","elementType":"geometry.fill","stylers":[{"color":"#d6e5a7"},{"visibility":"on"}]},{"featureType":"landscape.natural.terrain","elementType":"geometry.fill","stylers":[{"saturation":"-4"},{"lightness":"69"},{"gamma":"1.22"},{"color":"#f7ffb6"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"color":"#c0e8e4"},{"visibility":"on"}]},{"featureType":"poi.attraction","elementType":"geometry.fill","stylers":[{"color":"#89b7b0"}]},{"featureType":"poi.attraction","elementType":"labels.text.fill","stylers":[{"color":"#6b6b6b"}]},{"featureType":"poi.medical","elementType":"geometry.fill","stylers":[{"color":"#5eddc5"},{"visibility":"on"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#9ac87b"},{"saturation":"13"}]},{"featureType":"poi.place_of_worship","elementType":"geometry.fill","stylers":[{"color":"#00ffc4"},{"visibility":"on"}]},{"featureType":"poi.sports_complex","elementType":"geometry.fill","stylers":[{"color":"#33cee8"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#6bb1c2"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#67a4b2"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#82b6c2"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"color":"#93eb96"},{"saturation":"-33"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":700}]},{"featureType":"transit.station.airport","elementType":"geometry.fill","stylers":[{"color":"#a4fff2"}]},{"featureType":"transit.station.bus","elementType":"geometry.fill","stylers":[{"color":"#ff0000"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#7dcdcd"}]},{"featureType":"water","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"}]},{"featureType":"water","elementType":"labels.text","stylers":[{"visibility":"simplified"},{"color":"#454545"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#ffffff"},{"weight":"0.50"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"color":"#757575"}]}];
    function initMap() {
        $marker = $('#map');
        var latlng = new google.maps.LatLng($marker.attr('data-lat'), $marker.attr('data-lng'));

        var mouseScroll;
        if ($(window).width() > 960) {
            mouseScroll = true;
        } else {
            mouseScroll = false;
        }
        map = new google.maps.Map(document.getElementById('map'), {
            center: latlng,
            styles: styles,
            zoom: 13,
            scrollwheel: mouseScroll
        });

        var marker = new google.maps.Marker({
            position: latlng,
            icon: $marker.attr('data-marker'),
            map: map
        });

    }
</script>
<style>
    #map {
        height: 500px;
    }
</style>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtvdPQ8vmyust3oQPrnEBS5hS1RshvRCk&callback=initMap"
        async
        defer></script>
