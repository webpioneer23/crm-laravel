<!-- Edit User Modal -->
<div class="modal fade" id="newAddressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Create New Address</h3>
                </div>
                <form method="post" action="{{route('contact.address')}}">
                    @csrf
                    @include('address/address-create-form')
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Edit User Modal -->