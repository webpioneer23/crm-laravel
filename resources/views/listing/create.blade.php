@extends('layouts/layoutMaster')

@section('title', 'Listing Create')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/form-layouts.js')}}"></script>
<script>
  $("#price_type").change(function() {
    const prictType = $(this).val();
    if (["Tender", "Deadline Treaty"].includes(prictType)) {
      $("#tender_deadline_date_wrap").removeClass('d-none')
    } else {
      $("#tender_deadline_date_wrap").addClass('d-none')
    }
  })
</script>
@endsection



@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Create /</span> Edit</h4>

<!-- Tabs -->
<div class="row">
  <div class="col-xl-12">
    <div class="nav-align-top mb-4">
      <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#listing-detail" aria-controls="listing-detail" aria-selected="true">Listing Details</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link disabled" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false">Property Details</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link disabled" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-messages" aria-controls="navs-pills-top-messages" aria-selected="false">Images and Copy</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link disabled" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-messages" aria-controls="navs-pills-top-messages" aria-selected="false">Inspections</button>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade show active" id="listing-detail" role="tabpanel">
          <form method="post" action="{{route('listing.store')}}">
            @csrf
            <input type="hidden" name="step" value="2">
            <div class="content-header mb-3">
              <h5 class="mb-0">Change Status</h5>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-sm-6">
                <label class="form-label" for="status">Status</label>
                <select name="status" class="select2 form-select" id="status">
                  <option value="Draft">Draft</option>
                  <option value="Active">Active</option>
                  <option value="Off Market">Off Market</option>
                  <option value="Withdrawn">Withdrawn</option>
                  <option value="Sold">Sold</option>
                  <option value="Under Offer">Under Offer</option>
                </select>
              </div>
              <div class="col-sm-6">
                <div class="small fw-medium mb-3">Featured Property</div>
                <label class="switch">
                  <input class="form-check-input" type="checkbox" id="featured_property" name="featured_property">
                  <span class="switch-label">Tick this box to display this property in featured areas on your website</span>
                </label>
              </div>
            </div>
            <div class="content-header mb-3">
              <h5 class="mb-0">About the listing</h5>
            </div>
            <div class="row g-3">
              <div class="col-sm-6">
                <label class="form-label" for="property_type">Property Type *</label>
                <select name="property_type" class="select2 form-select" id="property_type">
                  <option value="Apartment">Apartment</option>
                  <option value="Boat Shed">Boat Shed</option>
                  <option value="Carpark">Carpark</option>
                  <option value="Home & Income">Home & Income</option>
                  <option value="House">House</option>
                  <option value="Lifestyle Property">Lifestyle Property</option>
                  <option value="Lifestyle Section">Lifestyle Section</option>
                  <option value="Multiple Properties">Multiple Properties</option>
                  <option value="Retirement Living - Apartment">Retirement Living - Apartment</option>
                  <option value="Retirement Living - Unit">Retirement Living - Unit</option>
                  <option value="Retirement Living - Villa">Retirement Living - Villa</option>
                  <option value="Section">Section</option>
                  <option value="Studio">Studio</option>
                  <option value="Townhouse">Townhouse</option>
                  <option value="Unit">Unit</option>
                </select>
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="established_development">Established or Development</label>
                <select name="established_development" class="select2 form-select" id="established_development">
                  <option value="Established Building">Established Building</option>
                  <option value="Under Development">Under Development</option>
                </select>
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="home_package">Is Home and Land Package</label>
                <select name="home_package" class="select2 form-select" id="home_package">
                  <option value="No">No</option>
                  <option value="Yes">Yes</option>
                </select>
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="authority">Authority</label>
                <select name="authority" class="select2 form-select" id="authority">
                  <option value="Auction">Auction</option>
                  <option value="Exclusive">Exclusive</option>
                  <option value="Multi List">Multi List</option>
                  <option value="Conjunctional">Conjunctional</option>
                  <option value="Open">Open</option>
                  <option value="Sale by Negotiation">Sale by Negotiation</option>
                </select>
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="office">Office</label>
                <select name="office" class="select2 form-select" id="office">
                  <option value="Lab Realty">Lab Realty</option>
                  <option value="Vivacity">Vivacity</option>
                </select>
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="expiry_date">Listing Expiry Date</label>
                <input type="date" class="form-control" placeholder="YYYY-MM-DD" name="expiry_date" id="expiry_date" />
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="price_type">Price Type</label>
                <select name="price_type" class="select2 form-select" id="price_type">
                  <option value="Asking Price">Asking Price</option>
                  <option value="Enquiries Over">Enquiries Over</option>
                  <option value="Price By Negotiation">Price By Negotiation</option>
                  <option value="Deadline Treaty">Deadline Treaty</option>
                  <option value="Tender">Tender</option>
                </select>
              </div>

              <div class="col-sm-6 d-none" id="tender_deadline_date_wrap">
                <label class="form-label" for="tender_deadline_date">Tender/Deadline Date</label>
                <input type="date" class="form-control" name="tender_deadline_date" id="tender_deadline_date" placeholder="YYYY-MM-DD" />
              </div>


              <div class="col-sm-6">
                <label class="form-label" for="price">Price *</label>
                <div class="input-group">
                  <input type="number" id="price" name="price" class="form-control" aria-label="Dollar amount (with dot and two decimal places)" required>
                  <span class="input-group-text">$</span>
                </div>
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="display_price">Display Price</label>
                <div class="form-check mt-3">
                  <input name="display_price" class="form-check-input" type="radio" value="actual_price" id="actual_price" checked />
                  <label class="form-check-label" for="actual_price">
                    Show actual price
                  </label>
                </div>
                <div class="form-check">
                  <input name="display_price" class="form-check-input" type="radio" value="text" id="text" />
                  <label class="form-check-label" for="text">
                    Show text instead of price
                  </label>
                </div>
                <input type="text" class="form-control form-control-sm">
                <div class="form-check">
                  <input name="display_price" class="form-check-input" type="radio" value="contact_agent" id="contact_agent" />
                  <label class="form-check-label" for="contact_agent">
                    Hide the price and display 'Contact Agent'
                  </label>
                </div>

              </div>
            </div>

            <div class="content-header mb-3">
              <h5 class="mb-0">Vendor details</h5>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-sm-6">
                <label class="form-label" for="contact_id">Vendor</label>
                <select name="contact_id" class="select2 form-select" id="contact_id">
                  @foreach($contacts as $contact)
                  <option value="{{$contact->id}}">{{$contact->first_name}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="content-header mt-3 mb-3">
              <h5 class="mb-0">Property Address</h5>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-sm-6">
                <label class="form-label" for="address_id">Address</label>
                <div class="row">
                  <div class="col-sm-9">
                    <select id="address_id" class="select2 form-select form-select-lg" name="address_id" data-allow-clear="true">
                      @foreach($addresses as $address)
                      <option value="{{$address->id}}">{{$address->unit_number ? $address->unit_number."/" : ""}}{{$address->street}}, {{$address->city}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-sm-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newAddressModal">Add Property</button>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="display">Display</label>
                <select name="display" class="select2 form-select" id="display">
                  <option value="Full Address">Full Address</option>
                  <option value="Suburb Only">Suburb Only</option>
                </select>
              </div>
            </div>


            <div class="content-header mt-3 mb-3">
              <h5 class="mb-0">Internal Notes</h5>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-sm-6">
                <label class="form-label" for="key_number">Key Number</label>
                <input name="key_number" class="form-control" type="text" id="key_number" />
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="key_location">Key Location</label>
                <input name="key_location" class="form-control" type="text" id="key_location" />
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="alarm_code">Alarm Code</label>
                <input name="alarm_code" class="form-control" type="text" id="alarm_code" />
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="internal_notes">Internal Notes</label>
                <input name="internal_notes" class="form-control" type="text" id="internal_notes" />
              </div>
            </div>

            <div class="content-header mt-3 mb-3">
              <h5 class="mb-0">Rent Appraisal</h5>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-sm-6">
                <label class="form-label" for="rent_appraisal">Rent Appraisal</label>
                <input name="rent_appraisal" class="form-control" type="text" id="rent_appraisal" />
              </div>
              <div class="col-12 text-end">
                <!-- <div class="col-12 d-flex justify-content-between text-end"> -->
                <!-- <button class="btn btn-label-secondary btn-prev" disabled> <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                  <span class="align-middle d-sm-inline-block d-none">Previous</span>
                </button> -->
                <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ti ti-arrow-right"></i></button>
              </div>
            </div>
          </form>
        </div>
        <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
          <p>
            Donut dragée jelly pie halvah. Danish gingerbread bonbon cookie wafer candy oat cake ice cream. Gummies
            halvah
            tootsie roll muffin biscuit icing dessert gingerbread. Pastry ice cream cheesecake fruitcake.
          </p>
          <p class="mb-0">
            Jelly-o jelly beans icing pastry cake cake lemon drops. Muffin muffin pie tiramisu halvah cotton candy
            liquorice caramels.
          </p>
        </div>
        <div class="tab-pane fade" id="navs-pills-top-messages" role="tabpanel">
          <p>
            Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies cupcake gummi
            bears
            cake chocolate.
          </p>
          <p class="mb-0">
            Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake. Sweet roll icing
            sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding jelly jelly-o tart brownie
            jelly.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Pills -->

@endsection