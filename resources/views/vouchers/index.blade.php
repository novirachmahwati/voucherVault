@extends('layouts/contentNavbarLayout')

@section('title', 'Vouchers')
@section('textTitle', 'Redeem Voucher')

@section('buttonMenu')
    <button id="navButton" class="btn btn-primary" onclick="window.location.href='{{ url('/history') }}'">History</button>
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
<h6 class="pb-1 mb-2">Special Treats Just for You!</h5>
<p class="pb-1 mb-6">You've earned it! Redeem your voucher and indulge in special treats curated just for you.</h5>
<div id="vouchers-list" class="row">
  <!-- Vouchers will be loaded here -->
</div>

<script>
  $(document).ready(function() {
      const token = localStorage.getItem('token');

      // Function to get URL parameters
      function getUrlParams() {
          const params = {};
          window.location.search.substring(1).split("&").forEach(param => {
              const [key, value] = param.split("=");
              if (key) params[key] = decodeURIComponent(value);
          });
          return params;
      }

      const params = getUrlParams();
      const kategori = params.kategori ? params.kategori : null;
      let url = '/api/vouchers';
      if (kategori) {
          url += `?kategori=${kategori}`;
      }

      $.ajax({
          url: url,
          type: 'GET',
          headers: {
              'Authorization': 'Bearer ' + token
          },
          success: function(response) {
            if (response.success) {
                var vouchers = response.data;
                var vouchersList = $('#vouchers-list');

                vouchersList.empty(); // Clear previous content

                $.each(vouchers, function(index, voucher) {
                    var voucherItem = `
                    <div class="col-md-4">
                      <div class="card h-80 mb-8">
                        <img class="card-img-top" src="/storage/${voucher.foto}" alt="Card image cap" />
                        <div class="card-body">
                          <h5 class="card-title">${voucher.nama}</h5>
                          <div class="row">
                            <div class="col-md-8">
                              <p class="card-text">
                                ${voucher.kategori}
                              </p>
                            </div>
                            <div class="col-md-4">
                              <button class="btn btn-primary claim-voucher" data-id="${voucher.id}">Claim</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    `;
                    vouchersList.append(voucherItem);
                });
            // Add event listener for claim button
            $('.claim-voucher').on('click', function() {
                    var voucherId = $(this).data('id');
                    var voucherElement = $(this).closest('.voucher-item');
                    claimVoucher(voucherId, voucherElement);
                });
            } else {
                $('#vouchers-list').html('<div class="alert alert-danger">Failed to load vouchers.</div>');
            }
        },
        error: function(xhr) {
            $('#vouchers-list').html('<div class="alert alert-danger">An unexpected error occurred.</div>');
        }
    });

    function claimVoucher(voucherId, voucherElement) {
        $.ajax({
            url: '{{ route('voucher_claims.store') }}',
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            data: {
                id_voucher: voucherId
            },
            success: function(response) {
                if (response.success) {
                    alert('Voucher claimed successfully!');
                    $.ajax({
                        url: `/api/vouchers/${voucherId}`,
                        type: 'DELETE',
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
                    alert('Failed to claim voucher.');
                }
            },
            error: function(xhr) {
                alert('An unexpected error occurred.');
            }
        });
    }
});
</script>
@endsection
