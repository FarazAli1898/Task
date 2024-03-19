<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Store Management</h2>
        <div class="row">
            <!-- Form Section -->
            <div class="col-md-6">
                <div id="storeForm">
                    <input type="hidden" id="storeId" value="">
                    
                    <div class="form-group">
                        <label for="storeName">Store Name:</label>
                        <input type="text" class="form-control" id="storeName" placeholder="Enter store name">
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" id="address" placeholder="Enter address">
                    </div>
                    
                    <div class="form-group">
                        <label for="contactPerson">Contact Person:</label>
                        <input type="text" class="form-control" id="contactPerson" placeholder="Enter contact person">
                    </div>
                    
                    <div class="form-group">
                        <label for="country">Country:</label>
                        <div class="d-flex align-items-center">
                            <select class="form-control" id="country" onchange="updateCities()">
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-primary ml-2" onclick="addNewCountry()"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="city">City:</label>
                        <div class="d-flex align-items-center">
                            <select class="form-control" id="city" onchange="updateLandmarks()">
                                <option value="">Select City</option>
                            </select>
                            <button type="button" class="btn btn-primary ml-2" onclick="addNewCity()"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="landmark">Landmark:</label>
                        <div class="d-flex align-items-center">
                            <select class="form-control" id="landmark">
                                <option value="">Select Landmark</option>
                            </select>
                            <button type="button" class="btn btn-primary ml-2" onclick="addNewLandmark()"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <button type="button" id="submitButton" class="btn btn-primary" onclick="submitStore()">Submit</button>
                </div>
            </div>
            <!-- Stores List Section -->
            <div class="col-md-6">
                <h3>Stores</h3>
                <ul class="list-group" id="storeList">
                    @foreach ($stores as $store)
                        <li class="list-group-item" id="store-{{ $store->id }}">
                            {{ $store->name }} - {{ $store->address }}
                            <button onclick="editStore({{ $store->id }})" class="btn btn-sm btn-info float-right">Edit</button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    function addNewCountry() {
        var newCountryName = prompt('Enter new country name:');
        if (newCountryName) {
            $.ajax({
                url: '/api/countries',
                type: 'POST',
                data: {
                    name: newCountryName,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#country').append('<option value="' + response.country.id + '">' + response.country.name + '</option>');
                    $('#country').val(response.country.id).trigger('change');
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    alert('Failed to add new country. Please try again.');
                }
            });
        }
    }

    function addNewCity() {
        var newCityName = prompt('Enter new city name:');
        var countryId = $('#country').val(); 
        if (newCityName && countryId) {
            $.ajax({
                url: '/api/cities',
                type: 'POST',
                data: {
                    name: newCityName,
                    country_id: countryId, 
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#city').append('<option value="' + response.city.id + '">' + response.city.name + '</option>');
                    $('#city').val(response.city.id).trigger('change');
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    alert('Failed to add new city. Please try again.');
                }
            });
        } else {
            alert('Please enter both city name and select a country.');
        }
    }



    function addNewLandmark() {
        var newLandmarkName = prompt('Enter new landmark name:');
        var cityId = $('#city').val(); 
        var coordinates = prompt('Enter coordinates:'); 
        console.log(coordinates);
        if (newLandmarkName) {
            $.ajax({
                url: '/api/landmarks',
                type: 'POST',
                data: {
                    name: newLandmarkName,
                    city_id: $('#city').val(),
                    coordinates: coordinates,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#landmark').append('<option value="' + response.landmark.id + '">' + response.landmark.name + '</option>');
                    $('#landmark').val(response.landmark.id).trigger('change');
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    alert('Failed to add new landmark. Please try again.');
                }
            });
        }
    }


    function updateCities(selectedCityId = null) {
        var countryId = $('#country').val();
        $('#city').empty().append('<option value="">Select City</option>');
        $('#landmark').empty().append('<option value="">Select Landmark</option>');

        if (countryId) {
            $.get('/api/cities/' + countryId, function(cities) {
                cities.forEach(function(city) {
                    if ($('#city option[value="' + city.id + '"]').length === 0) { 
                        let isSelected = city.id === selectedCityId;
                        $('#city').append(new Option(city.name, city.id, isSelected, isSelected));
                    }
                });
                if (selectedCityId) {
                    $('#city').val(selectedCityId).trigger('change');
                }
            });
        }
    }

    function updateLandmarks(selectedLandmarkId = null) {
        var cityId = $('#city').val();
        $('#landmark').empty().append('<option value="">Select Landmark</option>');

        if (cityId) {
            $.get('/api/landmarks/' + cityId, function(landmarks) {
                landmarks.forEach(function(landmark) {
                    if ($('#landmark option[value="' + landmark.id + '"]').length === 0) { 
                        let isSelected = landmark.id === selectedLandmarkId;
                        $('#landmark').append(new Option(landmark.name, landmark.id, isSelected, isSelected));
                    }
                });
                if (selectedLandmarkId) {
                    $('#landmark').val(selectedLandmarkId);
                }
            });
        }
    }


    function editStore(storeId) {
        $.get('/api/stores/' + storeId, function(store) {
            $('#storeId').val(store.id);
            $('#storeName').val(store.name);
            $('#address').val(store.address);
            $('#contactPerson').val(store.contact_person);
            $('#country').val(store.city.country_id);
            updateCities(store.city.id);
        
            setTimeout(() => {
                if (store.landmark) {
                    $('#landmark').empty().append(new Option(store.landmark.name, store.landmark.id, true, true));
                }
            }, 500);

            $('#submitButton').text('Update');
            $('#submitButton').attr('onclick', 'updateStore()');
        });
    }

    function submitStore() {
        var id = $('#storeId').val();
        var data = {
            name: $('#storeName').val(),
            address: $('#address').val(),
            contact_person: $('#contactPerson').val(),
            city_id: $('#city').val(),
            landmark_id: $('#landmark').val(),
            _token: '{{ csrf_token() }}'
        };
        var url = id ? '/api/stores/' + id : '/api/stores';
        var type = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: type,
            data: data,
            success: function(result) {
                if(!id) {
                    $('#storeList').append('<li class="list-group-item">' + result.store.name + ' - ' + result.store.address + 
                    '<button onclick="editStore(' + result.store.id + ')" class="btn btn-sm btn-info float-right">Edit</button></li>');
                } else {
                    $('#store-' + id).html(result.store.name + ' - ' + result.store.address + 
                    '<button onclick="editStore(' + result.store.id + ')" class="btn btn-sm btn-info float-right">Edit</button>');
                }
                resetForm();
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    }

    function resetForm() {
        $('#storeId').val('');
        $('#storeForm').find('input[type=text], select').val('');
    }
</script>
</body>
</html>
