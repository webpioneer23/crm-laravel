<style>
    .pac-container {
        z-index: 10000 !important;
    }
</style>


<div class="row mb-3">
    <label class="form-check-label col-sm-2">Property Type *</label>
    <div class="col-sm-10">
        <select id="property_type" name="property_type" class="select2 form-select form-select-lg" data-allow-clear="true" required>
            <option value="Apartment">Apartment</option>
            <option value="Townhouse">Townhouse</option>
            <option value="Unit">Unit</option>
            <option value="Land">Land</option>
            <option value="House">House</option>
            <option value="Lifestyle">Lifestyle</option>
        </select>
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="basic-default-name">Address *</label>
    <div class="col-sm-10">
        <input type="text" id="google_address" name="google_address" class="form-control" required autocomplete="off" />
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="basic-default-name">Unit Number</label>
    <div class="col-sm-10">
        <input type="text" name="unit_number" id="unit_number" class="form-control" placeholder="Unit Number" />
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="basic-default-name">Street Address *</label>
    <div class="col-sm-10">
        <input type="text" name="street" id="street" class="form-control" placeholder="Street Address" required />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="basic-default-name">Building Name</label>
    <div class="col-sm-10">
        <input type="text" name="building" id="building" class="form-control" placeholder="Building Name" />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="basic-default-name">Suburb *</label>
    <div class="col-sm-10">
        <input type="text" name="suburb" class="form-control" id="suburb" placeholder="suburb" required />
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="basic-default-name">City *</label>
    <div class="col-sm-10">
        <input type="text" name="city" class="form-control" id="locality" placeholder="city" required />
    </div>
</div>

<div class="row justify-content-end">
    <div class="col-sm-10">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB87UDyoVRfBpSKjUqto7YrwseLKlSY1Q4&callback=initAutocomplete&libraries=places&v=weekly" defer></script>
<script>
    let autocomplete;
    let address1Field;
    let postalField;

    console.log("herere")

    function initAutocomplete() {
        console.log("address1Field")

        address1Field = document.querySelector("#google_address");
        postalField = document.querySelector("#postcode");
        // Create the autocomplete object, restricting the search predictions to
        // addresses in the US and Canada.
        autocomplete = new google.maps.places.Autocomplete(address1Field, {
            // componentRestrictions: {
            //   country: ["us", "ca"]
            // },
            fields: ["address_components", "geometry"],
            types: ["address"],
        });
        console.log({
            autocomplete
        })
        address1Field.focus();
        console.log({
            address1Field
        })
        // When the user selects an address from the drop-down, populate the
        // address fields in the form.
        autocomplete.addListener("place_changed", fillInAddress);
    }

    function fillInAddress() {

        // Get the place details from the autocomplete object.
        const place = autocomplete.getPlace();
        let address1 = "";
        let postcode = "";

        // Get each component of the address from the place details,
        // and then fill-in the corresponding field on the form.
        // place.address_components are google.maps.GeocoderAddressComponent objects
        // which are documented at http://goo.gle/3l5i5Mr
        console.log("component-->", place.address_components)
        for (const component of place.address_components) {
            // @ts-ignore remove once typings fixed
            const componentType = component.types[0];

            switch (componentType) {
                case "street_number": {
                    address1 = `${component.long_name} ${address1}`;
                    break;
                }

                case "route": {
                    address1 += component.long_name;
                    break;
                }

                // case "postal_code": {
                //   postcode = `${component.long_name}${postcode}`;
                //   break;
                // }

                // case "postal_code_suffix": {
                //   postcode = `${postcode}-${component.long_name}`;
                //   break;
                // }
                case "locality": // city
                    document.querySelector("#locality").value = component.long_name;
                    break;
                case "sublocality_level_1": // suburb
                    document.querySelector("#suburb").value = component.long_name;
                    break;
                case "subpremise": // unit_number
                    document.querySelector("#unit_number").value = component.long_name;
                    break;
                    // case "administrative_area_level_1": {
                    //   document.querySelector("#state").value = component.short_name;
                    //   break;
                    // }
                    // case "country":
                    //   document.querySelector("#country").value = component.long_name;
                    //   break;
            }
        }

        document.querySelector("#street").value = address1;
        // postalField.value = postcode;
        // After filling the form with address components from the Autocomplete
        // prediction, set cursor focus on the second address line to encourage
        // entry of subpremise information such as apartment, unit, or floor number.
    }
</script>