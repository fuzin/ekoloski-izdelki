@extends('layouts.master')


@section('title')

    {{ "title"  }} | @parent

@stop

@section('meta')
    <meta name="title" content="{{ "title" }}"/>
    <meta name="description" content="{{ "title" }}"/>
@stop

@section('content')
<div id="app">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">

                <div id="list">

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-search"></i>
                            </span>
                            <input class="form-control" type="text">
                        </div>
                    </div>

                    <div class="bs-component">

                        <div class="list-group">

                            <list-item
                                    v-for="item in items"
                                    v-bind:item="item"
                                    v-bind:key="item.id">

                            </list-item>


                        </div>

                    </div>



                </div>


            </div>
            <div class="col-md-8">
                <div id="map" style="min-height: 500px; width: 100%"></div>
            </div>
        </div>
    </div>


@stop

@section('scripts')
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key= AIzaSyBgfF2N2CYEbRfUYf4-YuIxx8g00ehWBWk"></script>

    <script>

        var map;
        var lastOpenedInfowindow = null;
        var list; // vue app

        function randomGeo(center, radius) {

            var y0 = center.latitude;
            var x0 = center.longitude;
            var rd = radius / 111300;

            var u = Math.random();
            var v = Math.random();

            var w = rd * Math.sqrt(u);
            var t = 2 * Math.PI * v;
            var x = w * Math.cos(t);
            var y = w * Math.sin(t);


            return {
                'latitude': y + y0,
                'longitude': x + x0
            };
        }


        // image should be taken from same domain else is not shown
        // var image = '/static/images/pin-small.png';

        /**
         * Get location from browser location.
         */
        function geoFindMe() {

            if (!navigator.geolocation) {
                console.log("Geolocation is not supported by your browser");
                return;
            }

            function success(position) {
                getItems({
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude
                });
            }

            function error() {
                console.log("Unable to retrieve your location");
            }

            navigator.geolocation.getCurrentPosition(success, error);
        }


        /**
         * @param data
         */
        function getItems(data) {


            var userLocation = {
                latitude: 11.11,
                longitude: 12.11
            }


            /*
             //Clear previous results
             var radioGroup = $(".radioGroupDealers");
             radioGroup.empty();

             // Get all dealers (if parameter not set only ecommerce dealers will be returned)
             data.all = 1;

             var prefix = $("html").data('prefix');

             $.ajax({
             type: "GET",
             url: '/' + prefix + '/dealer-list',
             data: data,
             success: function (resp) {

             if (!resp.success) {
             $('#searchDealer').addClass('error');
             } else {
             $('#searchDealer').removeClass('error');

             // deleteMarkers();

             // save to global var
             dealers = resp.data.dealers;

             if (dealers.length > 0) {
             var i;
             for (i = 0; i < dealers.length; i++) {
             radioGroup.append(dealers[i].html);
             dealers[i] = addMarker(dealers[i]);
             }
             }

             // center map to center

             showMarkers();
             setBounds();

             $(".dealersSearchPaginator").show();

             }
             }
             });
             */
        }

        /**
         * Find from search input google results
         * @param array
         * @param type
         */
        function findInGoogleResult(array, type) {
            return _.find(array, function (element) {
                return _.indexOf(element.types, type) != -1;
            });
        }

        //
        // add marker to object item
        //
        function addMarker(item) {

            var position = {
                lat: parseFloat(item.geopoint.latitude),
                lng: parseFloat(item.geopoint.longitude)
            };

            var marker = new google.maps.Marker({
                position: position,
                animation: google.maps.Animation.DROP,
                icon: image,
                map: null
            });

            marker['infowindow'] = new google.maps.InfoWindow({
                content: item.bubble
            });

            google.maps.event.addListener(marker, 'click', function () {
                closeLastOpenedInfowindow();
                this['infowindow'].open(map, this);
                lastOpenedInfowindow = this['infowindow'];

                var n = 0;
                // show right page : TODO: refactor paginator

            });

            item['marker'] = marker;

            return dealer;
            // markers.push(marker);
        }

        // Sets the map on all markers in the array.
        function setMapOnAll(map) {
            for (var i = 0; i < items.length; i++) {
                items[i]['marker'].setMap(map);
            }
        }

        // Removes the markers from the map, but keeps them in the array.
        function clearMarkers() {
            setMapOnAll(null);
        }

        // Shows any markers currently in the array.
        function showMarkers() {
            setMapOnAll(map);
        }

        // Deletes all markers in the array by removing references to them.
        function deleteMarkers() {
            clearMarkers();
        }


        function closeLastOpenedInfowindow() {
            if (lastOpenedInfowindow)
                lastOpenedInfowindow.close();
        }

        // Set bounds of map so that all markers are visible.
        function setBounds() {
            var bounds = new google.maps.LatLngBounds();

            for (var i = 0; i < items.length; i++) {
                bounds.extend(items[i]['marker'].getPosition());
            }

            map.fitBounds(bounds);
        }


        var KC = {
            lat: 50.232934,
            lng: 11.333616
        };

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: KC,
            styles: [{
                "featureType": "landscape.natural",
                "elementType": "geometry.fill",
                "stylers": [{"visibility": "on"}, {"color": "#e0efef"}]
            }, {
                "featureType": "poi",
                "elementType": "geometry.fill",
                "stylers": [{"visibility": "on"}, {"hue": "#1900ff"}, {"color": "#c0e8e8"}]
            }, {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [{"lightness": 100}, {"visibility": "simplified"}]
            }, {
                "featureType": "road",
                "elementType": "labels",
                "stylers": [{"visibility": "off"}]
            }, {
                "featureType": "transit.line",
                "elementType": "geometry",
                "stylers": [{"visibility": "on"}, {"lightness": 700}]
            }, {"featureType": "water", "elementType": "all", "stylers": [{"color": "#7dcdcd"}]}]
        });


        Vue.component('list-item', {
            props: ['item'],
            template: '<a href="#" class="list-group-item">' +
                        '<h4 class="list-group-item-heading">@{{ item.title }}</h4>' +
                            '<p class="list-group-item-text">@{{ item.text }}</p></a>'
        })


        var data = {
            items: [
                { id: 0, text: 'Vegetables', title: 'Some Title' },
                { id: 1, text: 'Apple', title: 'Some Title' },
                { id: 1, text: 'Apple', title: 'Some Title' },
                { id: 1, text: 'Apple', title: 'Some Title' },
                { id: 1, text: 'Apple', title: 'Some Title' },
                { id: 1, text: 'Apple', title: 'Some Title' },
                { id: 1, text: 'Apple', title: 'Some Title' },
                { id: 1, text: 'Apple', title: 'Some Title' },
                { id: 1, text: 'Apple', title: 'Some Title' },
                { id: 1, text: 'Apple', title: 'Some Title' },
                { id: 2, text: 'Vine', title: 'Some Title' }
            ]
        };

        list = new Vue({
            el: '#list',
            data: data
        });


        data.items = [
            { id: 0, text: 'Vegetables', title: 'Some Title' }
        ]


        data.items.push(
            { id: 0, text: 'Vegetables', title: 'Some Title' }
        )





        // list.data([
        //    { id: 0, text: 'Vegetables', title: 'Some Title' }
        // ]);


        // use browser coordinates

        // geoFindMe();

        /////////////////////////////////////////////////////////////////////////////////////
        // $(document).ready(function () {

        // initial center on KC 50.232934, 11.333616
        // var KC = {
        //    lat: 50.232934,
        //     lng: 11.333616
        // };


        /*
         getItems({
         latitude: 50.232934,
         longitude: 11.333616
         });
         */

        // use search input
        /*
         $("#searchDealer")
         .geocomplete({
         country: $("input#country").val()
         })
         .bind("geocode:result", function (event, result) {

         var query = {
         latitude: result.geometry.location.lat(),
         longitude: result.geometry.location.lng()
         };

         map.panTo({
         lat: query.latitude,
         lng: query.longitude
         });

         getItems(query);

         })
         .bind("geocode:error", function (event, status) {
         console.log("ERROR: " + status);
         })
         .bind("geocode:multiple", function (event, results) {
         console.log("Multiple: " + results.length + " results found");
         });

         */

        // click on element in list
        /*
         $("body").on("click", ".formItem", function () {


         var id = $(this).data('id');

         for(var n = 0; n < dealers.length; n++) {

         if(dealers[n].id == id) {

         closeLastOpenedInfowindow();
         dealers[n]['marker']['infowindow'].open(map, dealers[n]['marker']);
         lastOpenedInfowindow = dealers[n]['marker']['infowindow'];
         map.panTo(dealers[n]['marker'].getPosition());

         break;
         }
         }

         // set active to clicked radio-item
         $('div.form-group').find('.formItem').each(function() {
         if($(this).hasClass("active"))
         $(this).removeClass("active");
         });

         $(this).addClass('active');

         });

         */

        /*
         $("a.dealersPage").click(function(e) {

         var page = $.trim($(this).html());

         $("a.dealersPage").each(function() {
         if($(this).hasClass("active"))
         $(this).removeClass("active");
         });

         var endDealer = page * 5;
         var startDealer = endDealer - 5;

         $('div.radioGroupDealers .formItem').each(function (e) {
         var n = $(this).data('n');

         if(n > startDealer && n <= endDealer)
         $(this).show();
         else
         $(this).hide();

         });

         $(this).addClass("active");
         e.preventDefault(); // seems not to work

         });
         */


        // });


    </script>


@stop
