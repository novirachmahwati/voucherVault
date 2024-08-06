@extends('layouts/contentNavbarLayout')

@section('title', 'Vouchers Claim History')
@section('textTitle', 'Voucher Claimed History')

@section('buttonMenu')
    <button id="navButton" class="btn btn-primary" onclick="window.location.href='{{ url('/') }}'">Home</button>
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
<h6 class="pb-1 mb-2">Voucher Claimed Successfully!</h5>
<p class="pb-1 mb-6">Congratulations! Your voucher has been successfully claimed. Enjoy exclusive deals and savings with VoucherVault—your gateway to unbeatable offers!</h5>

<div class="card">
  <h5 class="card-header">Table History</h5>
  <div class="table-responsive text-nowrap">
    <table class="table" id="historyTable">
      <thead>
        <tr>
          <th>Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
      </tbody>
    </table>
  </div>
</div>

<script>
  $(document).ready(function() {
      const token = localStorage.getItem('token');

      $.ajax({
          url: '/api/voucher_claims',
          type: 'GET',
          headers: {
              'Authorization': 'Bearer ' + token
          },
          success: function(response) {
            if (response.success) {
                var voucherClaims = response.data;
                var vouchersList = $('#historyTable tbody');

                vouchersList.empty(); // Clear previous content
                console.log(voucherClaims);

                $.each(voucherClaims, function(index, voucherClaims) {
                    var voucherItem = `
                    <tr>
                        <td>${voucherClaims.voucher.nama || 'N/A'}</td>
                        <td><button type="button" class="btn btn-danger delete-claim" data-id="${voucherClaims.id}">
                            <i class="bx bx-trash me-1"></i>Remove</button>
                        </td>
                    </tr>
                    `;
                    
                    vouchersList.append(voucherItem);
                });
            } else {
                $('#vouchers-list').html('<div class="alert alert-danger">Failed to load vouchers.</div>');
            }
        },
        error: function() {
            $('#historyTable tbody').html('<tr><td colspan="3">An error occurred while fetching history data.</td></tr>');
        }
    });

    // Handle delete button click
    $(document).on('click', '.delete-claim', function() {
        var id = $(this).data('id');
        var row = $(this).closest('tr');
        $.ajax({
            url: `/api/voucher_claims/${id}`,
            method: 'DELETE',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function(response) {
                if (response.success) {
                    alert('Voucher deleted successfully!');
                    row.remove();
                    $.ajax({
                        url: `/api/vouchers/restore/${response.voucherId}`,
                        type: 'POST',
                        headers: {
                            'Authorization': 'Bearer ' + token
                        },
                        success: function(response) {
                            location.reload();
                        },
                        error: function(response) {
                            alert('Failed to delete voucher: ' + response.responseJSON.message);
                        }
                    });
                } else {
                    alert('Error deleting record');
                }
            },
            error: function() {
                console.error('Error response:', xhr.responseText);
                alert('An error occurred while deleting the voucher claim.');
            }
        });
        });
    });
</script>
@endsection
