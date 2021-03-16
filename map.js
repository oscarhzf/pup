function initMap() {
                                    const map = new google.maps.Map(document.getElementById("map"), {
                                      zoom: 3,
                                      center: { lat: 0, lng: -180 },
                                      mapTypeId: "terrain",
                                    });
                                    const flightPlanCoordinates = [
                                      { lat: 37.7722, lng: -122.2144 },
                                      { lat: 21.291, lng: -157.821 },
                                      { lat: -18.142, lng: 178.431 },
                                      { lat: -27.467, lng: 153.027 },
                                    ];
                                    const flightPath = new google.maps.Polyline({
                                      path: flightPlanCoordinates,
                                      geodesic: true,
                                      strokeColor: "#FF0000",
                                      strokeOpacity: 1.0,
                                      strokeWeight: 2,
                                    });
                                    flightPath.setMap(map);
                                  }

