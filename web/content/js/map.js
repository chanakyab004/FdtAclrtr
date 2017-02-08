var MapSet = function MapSet(domObj, defaultLat, defaultLong) { //send the company lat / longitude so when there are no events, it will point to the company lat / long
    var self = this;
    self.map = new google.maps.Map(domObj, {});
    self.infoWindow = new google.maps.InfoWindow({});
    self.geocoder = geocoder = new google.maps.Geocoder();
    self.address = [],
    self.markers = [],
    self.location = { lat: null, lng: null };
    //self._fblistener = null;

    // console.log("in mapset " + defaultLat, defaultLong);

    self.MapAddress = function (address, city, state, zip, useAddressFunction, callback) {
        self.geocoder.geocode({ 'address': address + ',' + city + ' ' + state + ' ' + zip, 'region': 'us' }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (self.address != null && self.address.length > 0) {
                    for (var i = 0; i < self.address.length; i++) {
                        self.address[i].setMap(null);
                    }
                    self.address = [];
                    //$('#latitude').val('');
                    //$('#longitude').val('');
                    //$('.locationData').hide();
                    self.location.lat = null;
                    self.location.lng = null;
                }
                var locationIcon, counter = 0, a;
                for (var i = 0; i < results.length; i++) {
                    for (var j = 0; j < results[i].types.length; j++) {
                        if (results[i].types[j] == "street_address" || results[i].types[j] == "premise" || results[i].types[j] == "subpremise") {
                            if (results[i].partial_match || results.length > 1) {
                                locationIcon = {
                                    url: 'images/icons/location_question.png',
                                    labelOrigin: new google.maps.Point(15, 15),
                                    scaledSize: new google.maps.Size(30, 30),
                                    anchor: new google.maps.Point(15, 15)
                                };
                            }
                            else {
                                locationIcon = {
                                    url: 'images/icons/location_star.png',
                                    labelOrigin: new google.maps.Point(15, 15),
                                    scaledSize: new google.maps.Size(30, 30),
                                    anchor: new google.maps.Point(15, 15)
                                };
                                self.location.lat = results[i].geometry.location.lat();
                                self.location.lng = results[i].geometry.location.lng();
                                //$('#latitude').val(results[i].geometry.location.lat());
                                //$('#longitude').val(results[i].geometry.location.lng());
                                //$('.locationData').show();
                            }
                            a = results[i].formatted_address.split(',');
                            self.address[counter] = new google.maps.Marker({
                                position: results[i].geometry.location,
                                map: self.map,
                                title: results[i].formatted_address,
                                icon: locationIcon,
                                iwc: ((results[i].partial_match || results.length > 1) ? '<b>Partial Match:</b><br>' : '') + results[i].formatted_address + (useAddressFunction == null ? '' : '<br><a href="javascript:' + useAddressFunction + '(\'' + a[0].trim().replace("'", "\\'") + '\',\'' + a[1].trim().replace("'", "\\'") + '\',\'' + a[2].trim().split(' ')[0].replace("'", "\\'") + '\',\'' + a[2].trim().split(' ')[1].replace("'", "\\'") + '\',' + results[i].geometry.location.lat() + ',' + results[i].geometry.location.lng() + ')">Use This Address</a>')
                            });
                            //address[counter].addListener('click', function () {
                            //    thisInfowindow[i].open(map, address[counter]);
                            //});
                            google.maps.event.addListener(self.address[counter], 'click', (function (mapSet, marker, i) {
                                return function () {
                                    mapSet.infoWindow.setContent(marker.iwc); //(title + '<br>' + location.address + '<br>' + location.city + ' ' + location.state + ' ' + location.zip);
                                    mapSet.infoWindow.open(mapSet.map, marker);
                                }
                            })(self, self.address[counter], i));
                            //self.address[counter].addListener('click', function (e) {
                            //    
                            //});

                            counter++;
                        }
                    }
                }
                self.FitBounds();
            }
            // else {
            //    alert("Geocode was not successful for the following reason: " + status);
            // }
            if ($.isFunction(callback)) callback(self);
        });
    };

    self.MapLocation = function (lat, lng, title) {
        if (self.address != null && self.address.length > 0) { //removed 'x'
            for (var i = 0; i < self.address.length; i++) {
                self.address[i].setMap(null);
            }
            self.address = [];
            self.location.lat = null;
            self.location.lng = null;
        }
        if ($.isNumeric(lat) && $.isNumeric(lng)) {
            self.location.lat = 1 * lat;
            self.location.lng = 1 * lng;
            // Create a map object and specify the DOM element for display.
            // Create a marker and set its position.
            var locationIcon = {
                url: 'images/icons/location_star.png',
                labelOrigin: new google.maps.Point(15, 15),
                scaledSize: new google.maps.Size(30, 30),
                anchor: new google.maps.Point(15, 15)
            };
            self.address[0] = new google.maps.Marker({
                map: self.map,
                position: self.location,
                title: title,
                icon: locationIcon
            });
            //bounds = new google.maps.LatLngBounds();
            //bounds.extend(marker.position);
            //map.fitBounds(bounds);
            //if (map.getZoom() > 16) map.setZoom(16);
            //var listener = google.maps.event.addListener(map, 'idle', function () {
            //    if (map.getZoom() > 16 && !map.initialZoom) {
            //        map.setZoom(16);
            //        map.initialZoom = true;
            //    }
            //    google.maps.event.removeListener(listener);
            //});
        }
        self.FitBounds();
    }

    self.ShowAddressMarkers = function () {
        if (self.address != null && self.address.length > 0) {
            for (var i = 0; i < self.address.length; i++)
                self.address[i].setMap(self.map);
            //map.fitBounds(bounds);
            self.FitBounds();
        }
    };

    self.RemoveAddressMarkers = function () {
        if (self.address != null && self.address.length > 0) {
            for (var i = 0; i < self.address.length; i++)
                self.address[i].setMap(null);
            //map.fitBounds(bounds);
            self.FitBounds();
        }
    };


    self.SetMapLocations = function(locations, start, end) {
        for (var i = 0; i < self.markers.length; i++) {
            self.markers[i].setMap(null);
        }
        self.markers = [];

        if (locations != null) {
            var j = 0, r, rid;
            for (var i = 0; i < locations.length; i++) {
                var location = locations[i];
                if (rid != location.resourceId) { r = 1; rid = location.resourceId; }
                var labelCharacter = '' + (r < 9 ? r : (r < 36 ? String.fromCharCode(55 + r) : ''));
                //if ($('.fc-toolbar').length > 0) { //TODO: Determine what this is
                if (typeof (location.start) == "string") location.start = moment(location.start);
                if (typeof (location.end) == "string") location.end = moment(location.end);

                if (location.start != null && location.end != null) {
                    location.end.local();
                    location.start.local();
                    if (location.eventType == 1 && location.start._d <= end && location.end._d >= start) {
                        var latitude = location.latitude;
                        var longitude = location.longitude;
                        image = {
                            url: '/images/markers/' + (location.calendarBgColor.length == 0 ? '000000' : location.calendarBgColor.replace('#', '')) + '.png',
                            labelOrigin: new google.maps.Point(15, 12),
                            scaledSize: new google.maps.Size(30, 30),
                            anchor: new google.maps.Point(15, 30)
                        };
                        self.markers[j] = new google.maps.Marker({
                            position: new google.maps.LatLng(latitude, longitude),
                            map: self.map,
                            label: {
                                text: labelCharacter,
                                color: 'black'
                            },
                            icon: image,
                            title: location.resourceFirstName + ' ' + location.resourceLastName + ': ' + location.title + ' (' + (location.scheduleType) + ')',
                            fxl_pincontent: '<b>' + location.resourceFirstName + ' ' + location.resourceLastName + '</b> (' + (location.scheduleType) + ')<br>' + location.title + '<br>' + location.address + '<br>' + location.city + ' ' + location.state + ' ' + location.zip
                        });

                        google.maps.event.addListener(self.markers[j], 'click', (function (mapset, marker, i) {
                            return function () {
                                mapset.infoWindow.setContent(marker.fxl_pincontent);
                                mapset.infoWindow.open(mapset.map, marker);
                            }
                        })(this, self.markers[j], j));
                        j++;
                        r++;
                    }
                    //} else {
                    //    if (eventType == null || location.eventType == eventType) {
                    //        var latitude = location.latitude;
                    //        var longitude = location.longitude;
                    //        image = {
                    //            url: '/images/markers/' + location.calendarBgColor.replace('#', '') + '.png',
                    //            labelOrigin: new google.maps.Point(15, 12),
                    //            scaledSize: new google.maps.Size(30, 30),
                    //        };
                    //        markers[j] = new google.maps.Marker({
                    //            position: new google.maps.LatLng(latitude, longitude),
                    //            map: self.map,
                    //            label: {
                    //                text: labelCharacter,
                    //                color: 'black'
                    //            },
                    //            icon: image,
                    //            title: location.resourceFirstName + ' ' + location.resourceLastName + ': ' + location.title,
                    //            fxl_pincontent: '<b>' + location.resourceFirstName + ' ' + location.resourceLastName + '</b><br>' + location.title + '<br>' + location.address + '<br>' + location.city + ' ' + location.state + ' ' + location.zip
                    //        });

                    //        google.maps.event.addListener(markers[j], 'click', (function (mapset, marker, i) {
                    //            return function () {
                    //                mapset.infoWindow.setContent(marker.fxl_pincontent);
                    //                mapset.infoWindow.open(mapset.map, marker);
                    //            }
                    //        })(this, self.markers[j], j));
                    //        j++;
                    //        r++;
                    //    }
                    //}
                }
            }
        }

        //self.MapAddress();

        self.FitBounds();
    }

    self.FitBounds = function () {
        var bounds = new google.maps.LatLngBounds();
        var isAddressSet = false;
        if (self.markers != null && $.isArray(self.markers) && self.markers.length > 0) {
            for (var i = 0; i < self.markers.length; i++) {
                bounds.extend(self.markers[i].position);
                isAddressSet = true;
            }
        }
        if (self.address != null && $.isArray(self.address) && self.address.length > 0) {
            for (var i = 0; i < self.address.length; i++) {
                bounds.extend(self.address[i].position);
                isAddressSet = true;
            }
        }
        if (isAddressSet) {
            self.map.fitBounds(bounds);
            if (self.map.getZoom() > 16) self.map.setZoom(16);
            google.maps.event.addListenerOnce(self.map, 'idle', self.fbf);
        }
        else {
            // var defaultLocation = new google.maps.LatLng(38.907596, -94.377571);
            //use defaultLat / defaultLong here 
            var defaultLocation = new google.maps.LatLng(defaultLat, defaultLong);
            //console.log("lat / long" + defaultLat + " " + defaultLong);
            bounds.extend(defaultLocation);
            self.map.fitBounds(bounds);
            self.map.setZoom(10);
            google.maps.event.addListenerOnce(self.map, 'idle', self.fbf);
        }
    };

    self.fbf = function () {
        if (self.markers.length == 0 && self.address.length == 0)
            self.map.setZoom(10);
        else if (self.map.getZoom() > 16)
            self.map.setZoom(16);
    };

    self.RemoveMapLocations = function () {
        if (self.markers != null && self.markers.length > 0) {
            for (var i = 0; i < self.markers.length; i++)
                self.markers[i].setMap(null);
        }
        self.markers = [];
    };

    self.Resize = function () {
        //console.log('Resize');
        google.maps.event.trigger(self.map,'resize');

    };
    

}