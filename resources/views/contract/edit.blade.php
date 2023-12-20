@extends('layouts/layoutMaster')

@section('title', ' Horizontal Layouts - Forms')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />

<link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />

@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>

<script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>

@endsection

@section('page-script')
<script src="{{asset('assets/js/form-layouts.js')}}"></script>
<script src="{{asset('assets/js/forms-extras.js')}}"></script>

<script>
  const whitelist = [
    'LIM',
    'Due Diligence',
    'Solicitor Approval',
    'Insurance',
    'Finance',
    'Sale of Property',
  ];
  const tagListEl = document.querySelector('#conditions');
  let tagList = new Tagify(tagListEl, {
    whitelist: whitelist,
    maxTags: 10,
    dropdown: {
      maxItems: 20,
      classname: 'tags-inline',
      enabled: 0,
      closeOnSelect: false
    }
  });
</script>

@endsection

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Contract/</span> Edit</h4>

<div class="row">
  <div class="card mb-4">
    <div class="card-body">
      <form method="post" action="{{route('contract.update', $contract->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <?php
        $purchases_list = [];
        foreach ($contract->contacts as $contact) {
          array_push($purchases_list, $contact->id);
        }

        ?>

        <div class="row mb-3">
          <label class="form-check-label col-sm-2" for="purchasers">Listing</label>
          <div class="col-sm-10">
            <select id="listing_id" class="select2 form-select form-select-lg" name="listing_id" data-allow-clear="true">
              @foreach($listings as $listing)
              <option value="{{$listing->id}}" {{$listing->id == $contract->listing_id? 'selected' : ''}}> {{$listing->address?->unit_number ? $listing->address->unit_number."/" : ""}}{{$listing->address->street}}, {{$listing->address->city}} </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="purchaser_name">Purchaser Name</label>
          <div class="col-sm-10">
            <input type="text" name="purchaser_name" id="purchaser_name" class="form-control" value="{{$contract->purchaser_name}}" placeholder="Purchaser Name" />
          </div>
        </div>

        <div class="row mb-3">
          <label class="form-check-label col-sm-2" for="purchasers">Purchaser</label>
          <div class="col-sm-10">
            <select id="purchasers" class="select2 form-select form-select-lg" name="purchasers[]" data-allow-clear="true" multiple>
              @foreach($contacts as $contact)
              <option value="{{$contact->id}}" {{in_array($contact->id, $purchases_list)? 'selected' : ''}}>{{$contact->first_name}} </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="vendor_name">Vendor name</label>
          <div class="col-sm-10">
            <input type="text" name="vendor_name" id="vendor_name" value="{{$contract->vendor_name}}" class="form-control" placeholder="Vendor Name" />
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="contract_accepted_date">Contract Accepted Date</label>
          <div class="col-sm-10">
            <input type="date" name="contract_accepted_date" value="{{$contract->contract_accepted_date}}" class="form-control" placeholder="Contract Accepted Date" />
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="unconditional_date">Unconditional Date</label>
          <div class="col-sm-10">
            <input type="date" name="unconditional_date" value="{{$contract->unconditional_date}}" class="form-control" placeholder="Unconditional Date" />
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="settlement_date">Settlement Date</label>
          <div class="col-sm-10">
            <input type="date" name="settlement_date" value="{{$contract->settlement_date}}" class="form-control" placeholder="Settlement Date" />
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">Conditions</label>
          <div class="col-sm-10">
            <input id="conditions" name="conditions" class="form-control" placeholder="Select Conditions" value="{{json_encode($contract->full_conditions)}}">
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="deposit_due_date">Deposit Due Date</label>
          <div class="col-sm-10">
            <input type="date" name="deposit_due_date" value="{{$contract->deposit_due_date}}" class="form-control" placeholder="Deposit Due Date" />
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="deposit_received_date">Deposit Received Date</label>
          <div class="col-sm-10">
            <input type="date" name="deposit_received_date" value="{{$contract->deposit_received_date}}" class="form-control" placeholder="Deposit Received Date" />
          </div>
        </div>


        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="commission">Commission (EX GST)</label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" name="commission" value="{{$contract->commission}}" id="commission" class="form-control numeral-mask" aria-label="">
              <span class="input-group-text">$</span>
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">Documents</label>
          <div class="col-sm-10">
            <input type="file" name="documents[]" class="form-control" multiple />
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="comment">Comment</label>
          <div class="col-sm-10">
            <textarea name="comment" class="form-control" placeholder="">{{$contract->comment}}</textarea>
          </div>
        </div>

        <div class="row justify-content-end">
          <div class="col-sm-4 text-end">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection