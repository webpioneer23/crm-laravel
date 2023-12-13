<form method="post" action="{{route('listing.update', $listing->id)}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="step" value="4">
    <div class="content-header mb-3">
        <h5 class="mb-0">UPLOAD IMAGES</h5>
    </div>
    <div class="row">
        @foreach($listing->photos as $photo)
        <div class="col-md-2">
            <img class="mb-3 img-fluid" src="{{asset('uploads/' . $photo->path)}}" alt="{{$photo->file_name}}">
        </div>
        @endforeach
    </div>
    <div class="row g-3 mb-3">
        <div class="col-sm-6">
            <label for="photos" class="form-label">Upload photos...</label>
            <input class="form-control" type="file" id="photos" name="photos[]" multiple>
        </div>
    </div>

    <div class="content-header mb-3">
        <h5 class="mb-0">UPLOAD FLOORPLANS</h5>
    </div>
    <div class="row">
        @foreach($listing->floorplans as $floorplan)
        <div class="col-md-2">
            <img class="mb-3 img-fluid" src="{{asset('uploads/' . $floorplan->path)}}" alt="{{$floorplan->file_name}}">
        </div>
        @endforeach
    </div>
    <div class="row g-3 mb-3">
        <div class="col-sm-6">
            <label for="floorplans" class="form-label">Upload floorplans...</label>
            <input class="form-control" type="file" id="floorplans" name="floorplans[]" multiple>
        </div>
    </div>

    <div class="content-header mb-3">
        <h5 class="mb-0">UPLOAD DOCUMENTS</h5>
    </div>
    <div class="row">
        @foreach($listing->documents as $document)
        <div class="col-md-2">
            <a href="{{asset('uploads/' . $document->path)}}" class="btn btn-primary me-2 btn-sm" download>
                <img class="mb-3 img-fluid" src="{{asset('assets/img/icons/misc/doc.png')}}" width="70" height="70" alt="{{$document->file_name}}">
            </a>
        </div>
        @endforeach
    </div>
    <div class="row g-3 mb-3">
        <div class="col-sm-6">
            <label for="documents" class="form-label">Upload documents...</label>
            <input class="form-control" type="file" id="documents" name="documents[]" multiple>
        </div>
    </div>


    <div class="content-header mb-3">
        <h5 class="mb-0">Listing Copy</h5>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-sm-6">
            <label class="form-label" for="headline">Headline</label>
            <textarea class="form-control" name="headline" id="headline" rows="3">{{$listing->headline}}</textarea>
        </div>

        <div class="col-sm-6">
            <label class="form-label" for="description">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3">{{$listing->description}}</textarea>
        </div>
    </div>

    <div class="content-header mb-3">
        <h5 class="mb-0">Links</h5>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-sm-6">
            <label for="video_url" class="form-label">Video URL</label>
            <input class="form-control" type="text" id="video_url" name="video_url" value="{{$listing->video_url}}">
        </div>
        <div class="col-sm-6">
            <label for="online_tour1" class="form-label">Online Tour 1</label>
            <input class="form-control" type="text" id="online_tour1" name="online_tour1" value="{{$listing->online_tour1}}">
        </div>
        <div class="col-sm-6">
            <label for="online_tour2" class="form-label">Online Tour 2</label>
            <input class="form-control" type="text" id="online_tour2" name="online_tour2" value="{{$listing->online_tour2}}">
        </div>
        <div class="col-sm-6">
            <label for="third_party_link" class="form-label">Third party website link</label>
            <input class="form-control" type="text" id="third_party_link" name="third_party_link" value="{{$listing->third_party_link}}">
        </div>
    </div>

    <div class="col-12 text-end">
        <!-- <div class="col-12 d-flex justify-content-between text-end"> -->
        <!-- <button class="btn btn-label-secondary btn-prev" disabled> <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                  <span class="align-middle d-sm-inline-block d-none">Previous</span>
                </button> -->
        <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ti ti-arrow-right"></i></button>
    </div>
</form>