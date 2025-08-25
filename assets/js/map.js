document.addEventListener('DOMContentLoaded', function() {
    // Initialize the map
    const map = L.map('map').setView(campusCenter, 16);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Create map markers object to store all markers
    const markers = {};
    
    // Create marker clusters for organization
    const markerCluster = L.layerGroup().addTo(map);
    
    // Custom marker icons by category
    const markerIcons = {
        academic: L.divIcon({
            html: '<i class="fas fa-university text-blue-600 text-2xl"></i>',
            className: 'custom-marker',
            iconSize: [24, 24],
            iconAnchor: [12, 24],
        }),
        administrative: L.divIcon({
            html: '<i class="fas fa-building text-purple-600 text-2xl"></i>',
            className: 'custom-marker',
            iconSize: [24, 24],
            iconAnchor: [12, 24],
        }),
        hostel: L.divIcon({
            html: '<i class="fas fa-home text-green-600 text-2xl"></i>',
            className: 'custom-marker',
            iconSize: [24, 24],
            iconAnchor: [12, 24],
        }),
        facility: L.divIcon({
            html: '<i class="fas fa-landmark text-amber-600 text-2xl"></i>',
            className: 'custom-marker',
            iconSize: [24, 24],
            iconAnchor: [12, 24],
        }),
    };
    
    // Add all campus locations to the map
    campusLocations.forEach(location => {
        // Create marker with custom icon based on category
        const icon = markerIcons[location.category] || L.divIcon({
            html: '<i class="fas fa-map-marker-alt text-red-600 text-2xl"></i>',
            className: 'custom-marker',
            iconSize: [24, 24],
            iconAnchor: [12, 24],
        });
        
        const marker = L.marker([location.lat, location.lng], { icon }).addTo(markerCluster);
        
        // Add popup
        marker.bindPopup(`
            <strong>${location.name}</strong><br>
            ${location.description}<br>
            <button class="view-details bg-green-600 text-white px-2 py-1 rounded text-xs mt-2" data-id="${location.id}">View Details</button>
        `);
        
        // Store marker reference
        markers[location.id] = marker;
        
        // Add click event to marker
        marker.on('click', function() {
            showLocationDetails(location);
        });
    });
    
    // Function to show location details
    function showLocationDetails(location) {
        const detailsPanel = document.getElementById('location-details');
        const detailTitle = document.getElementById('detail-title');
        const detailDescription = document.getElementById('detail-description');
        const getDirectionsBtn = document.getElementById('get-directions-to');
        
        // Set details
        detailTitle.textContent = location.name;
        detailDescription.textContent = location.description;
        
        // Configure directions button
        getDirectionsBtn.setAttribute('data-lat', location.lat);
        getDirectionsBtn.setAttribute('data-lng', location.lng);
        getDirectionsBtn.setAttribute('data-name', location.name);
        
        // Show the panel
        detailsPanel.classList.remove('hidden');
        
        // Center map on location
        map.setView([location.lat, location.lng], 17);
        
        // Open popup
        markers[location.id].openPopup();
    }
    
    // Handle location card clicks
    const locationCards = document.querySelectorAll('.location-card');
    locationCards.forEach(card => {
        card.addEventListener('click', function() {
            const locationId = parseInt(this.getAttribute('data-id'));
            const location = campusLocations.find(loc => loc.id === locationId);
            
            if (location) {
                showLocationDetails(location);
            }
        });
    });
    
    // Close details panel
    document.getElementById('close-details').addEventListener('click', function() {
        document.getElementById('location-details').classList.add('hidden');
    });
    
    // Search functionality
    const searchInput = document.getElementById('search-location');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        filterLocations(searchTerm);
    });
    
    // Function to filter locations by search term
    function filterLocations(searchTerm) {
        const locationCards = document.querySelectorAll('.location-card');
        
        locationCards.forEach(card => {
            const locationName = card.querySelector('h4').textContent.toLowerCase();
            const locationDesc = card.querySelector('p').textContent.toLowerCase();
            
            if (locationName.includes(searchTerm) || locationDesc.includes(searchTerm)) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }
    
    // Category filter functionality
    const categoryFilters = document.querySelectorAll('.category-filter');
    categoryFilters.forEach(filter => {
        filter.addEventListener('change', function() {
            filterLocationsByCategory();
        });
    });
    
    // Function to filter locations by category
    function filterLocationsByCategory() {
        const allLocationsCheckbox = document.querySelector('.category-filter[value="all"]');
        const categoryGroups = document.querySelectorAll('.category-group');
        
        if (allLocationsCheckbox.checked) {
            // Show all categories
            categoryGroups.forEach(group => {
                group.classList.remove('hidden');
            });
            return;
        }
        
        // Get selected categories
        const selectedCategories = [];
        categoryFilters.forEach(filter => {
            if (filter.checked && filter.value !== 'all') {
                selectedCategories.push(filter.value);
            }
        });
        
        // Show/hide category groups
        categoryGroups.forEach(group => {
            const category = group.getAttribute('data-category');
            if (selectedCategories.includes(category)) {
                group.classList.remove('hidden');
            } else {
                group.classList.add('hidden');
            }
        });
    }
    
    // Get user's current location
    document.getElementById('my-location').addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    
                    // Add marker for user's location
                    const userMarker = L.marker([userLat, userLng], {
                        icon: L.divIcon({
                            html: '<i class="fas fa-user-circle text-blue-600 text-2xl"></i>',
                            className: 'custom-marker',
                            iconSize: [24, 24],
                            iconAnchor: [12, 24],
                        })
                    }).addTo(map);
                    
                    userMarker.bindPopup("You are here").openPopup();
                    
                    // Center map on user location
                    map.setView([userLat, userLng], 17);
                },
                function(error) {
                    alert("Error getting your location: " + error.message);
                }
            );
        } else {
            alert("Geolocation is not supported by your browser");
        }
    });
    
    // Handle "Get Directions" button
    document.getElementById('get-directions-to').addEventListener('click', function() {
        const destLat = this.getAttribute('data-lat');
        const destLng = this.getAttribute('data-lng');
        const destName = this.getAttribute('data-name');
        
        // Check if browser supports geolocation
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    
                    // Open Google Maps with directions
                    const mapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${userLat},${userLng}&destination=${destLat},${destLng}&travelmode=walking`;
                    window.open(mapsUrl, '_blank');
                },
                function(error) {
                    // If user denies location permission, just open the destination
                    const mapsUrl = `https://www.google.com/maps/search/?api=1&query=${destLat},${destLng}`;
                    window.open(mapsUrl, '_blank');
                    alert("Couldn't access your location for directions: " + error.message);
                }
            );
        } else {
            // Fallback for browsers without geolocation
            const mapsUrl = `https://www.google.com/maps/search/?api=1&query=${destLat},${destLng}`;
            window.open(mapsUrl, '_blank');
            alert("Geolocation is not supported by your browser");
        }
    });
    
    // Handle general "Get Directions" button
    document.getElementById('get-directions').addEventListener('click', function() {
        const directionsPanel = document.createElement('div');
        directionsPanel.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        directionsPanel.innerHTML = `
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full">
                <h3 class="text-xl font-semibold mb-4">Get Directions</h3>
                <p class="mb-4">Select your starting point and destination:</p>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Starting Point</label>
                    <select id="direction-start" class="w-full p-2 border rounded">
                        <option value="my-location">My Current Location</option>
                        ${campusLocations.map(loc => `<option value="${loc.id}">${loc.name}</option>`).join('')}
                    </select>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">Destination</label>
                    <select id="direction-end" class="w-full p-2 border rounded">
                        ${campusLocations.map(loc => `<option value="${loc.id}">${loc.name}</option>`).join('')}
                    </select>
                </div>
                
                <div class="flex justify-end space-x-2">
                    <button id="cancel-directions" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button id="get-route" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Get Route</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(directionsPanel);
        
        // Handle Close button
        document.getElementById('cancel-directions').addEventListener('click', function() {
            document.body.removeChild(directionsPanel);
        });
        
        // Handle Get Route button
        document.getElementById('get-route').addEventListener('click', function() {
            const startValue = document.getElementById('direction-start').value;
            const endValue = document.getElementById('direction-end').value;
            
            const destination = campusLocations.find(loc => loc.id === parseInt(endValue));
            
            if (startValue === 'my-location') {
                // Starting from user's current location
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const userLat = position.coords.latitude;
                            const userLng = position.coords.longitude;
                            
                            // Open Google Maps with directions
                            const mapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${userLat},${userLng}&destination=${destination.lat},${destination.lng}&travelmode=walking`;
                            window.open(mapsUrl, '_blank');
                            document.body.removeChild(directionsPanel);
                        },
                        function(error) {
                            alert("Error getting your location: " + error.message);
                        }
                    );
                } else {
                    alert("Geolocation is not supported by your browser");
                }
            } else {
                // Starting from a campus location
                const start = campusLocations.find(loc => loc.id === parseInt(startValue));
                
                // Open Google Maps with directions
                const mapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${start.lat},${start.lng}&destination=${destination.lat},${destination.lng}&travelmode=walking`;
                window.open(mapsUrl, '_blank');
                document.body.removeChild(directionsPanel);
            }
        });
    });
});