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
  let prefixUrl = '/public';
  if (location.hostname === 'localhost' || location.hostname === '127.0.0.1') {
    prefixUrl = '';
  }

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

  // auto add comment
  function addComment() {
    $(".comment-list").append(`
      <div class="col-sm-12 mb-2">
        <textarea name="comment[]" class="form-control" placeholder=""></textarea>
      </div>
    `)
  }


  const conditionDates = <?php echo json_encode($contract->full_conditions); ?>;
  const conditionDateMap = [];
  conditionDates.map(conDate => {
    conditionDateMap[conDate.tag_name] = conDate.tag_date;
  })



  function handleConditions() {
    const jsonConditions = $("#conditions").val();
    if (jsonConditions) {

      const conditions = JSON.parse(jsonConditions);
      const conditionListEle = conditions.map(con => `
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="deposit_due_date">${con.value} Date</label>
          <div class="col-sm-10">
            <input type="date" name="${con.value}" class="form-control" placeholder="${con.value} Date" value="${conditionDateMap[con.value]}" />
          </div>
        </div>
      `);

      $(".conditions-date").html(conditionListEle)

    }
  }


  $("#listing_id").change(async function() {
    const listingId = $(this).val();
    const listingRes = await fetch(prefixUrl + '/listing/' + listingId);
    const listing = await listingRes.json();
    $("#price").val(listing.price)
  })
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
          <label class="col-sm-2 col-form-label" for="price">Price</label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" name="price" id="price" class="form-control numeral-mask" value="{{$contract->price}}" aria-label="">
              <span class="input-group-text">$</span>
            </div>
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

        <?php


        $conditions = [];
        foreach ($contract->full_conditions as $tag_list) {
          array_push($conditions, $tag_list->tag_name);
        }
        ?>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">Conditions</label>
          <div class="col-sm-10">
            <input id="conditions" name="conditions" class="form-control" placeholder="Select Conditions" value="{{json_encode($conditions)}}" onchange="handleConditions()">
          </div>
        </div>

        <div class="conditions-date">
          @foreach ($contract->full_conditions as $condition)
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="deposit_due_date">{{$condition->tag_name}} Date</label>
            <div class="col-sm-10">
              <input type="date" name="{{$condition->tag_name}}" value="{{$condition->tag_date}}" class="form-control" placeholder="{{$condition->tag_name}} Date" />
            </div>
          </div>
          @endforeach
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
            <div class="row mb-2 comment-list">
              @foreach($contract->full_comments as $comment)
              <div class="col-sm-12 mb-2">
                <textarea name="comment[]" class="form-control" placeholder="">{{$comment}}</textarea>
              </div>
              @endforeach
            </div>

            <button type="button" class="btn btn-primary" onclick="addComment()"> + New Comment</button>
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