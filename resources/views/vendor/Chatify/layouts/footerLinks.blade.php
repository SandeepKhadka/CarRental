<script src="https://js.pusher.com/7.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@3.0.3/dist/index.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>

<script>
    // Gloabl Chatify variables from PHP to JS
    window.chatify = {
        name: "{{ config('chatify.name') }}",
        sounds: {!! json_encode(config('chatify.sounds')) !!},
        allowedImages: {!! json_encode(config('chatify.attachments.allowed_images')) !!},
        allowedFiles: {!! json_encode(config('chatify.attachments.allowed_files')) !!},
        maxUploadSize: {{ Chatify::getMaxUploadSize() }},
        pusher: {!! json_encode(config('chatify.pusher')) !!},
        pusherAuthEndpoint: '{{ route('pusher.auth') }}'
    };
    window.chatify.allAllowedExtensions = chatify.allowedImages.concat(chatify.allowedFiles);
</script>
<script src="{{ asset('js/chatify/utils.js') }}"></script>
<script src="{{ asset('js/chatify/code.js') }}"></script>
<script>
    // Get the modal
    var modal = document.getElementById("coupon-modal");

    // Get the button that opens the modal
    var btn = document.getElementById("create-coupon-btn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<script>
    $(document).ready(function() {
        $('.coupon-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    // Parse JSON response
                    console.log(response); // Log the response object
                    var message = response.message;
                    // var couponCode = message.match(/#Customer_\d+/)[0]; // Extract the coupon code from the message string
                    // console.log(couponCode);
                    const regex = /#\w+_\d+/;
                    const match = message.match(regex);

                    if (match) {
                        var couponCode = match[0];
                        console.log(couponCode); // Output: #iamsandeepkdk_7798
                    }
                    // Show success message using SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: message,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Copy to Clipboard'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Copy coupon code to clipboard
                            navigator.clipboard.writeText(couponCode)
                                .then(() => {
                                    // Show confirmation message
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Coupon Code Copied',
                                        text: 'The coupon code has been copied to your clipboard.',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    });
                                })
                                .catch((error) => {
                                    // Show error message
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed to Copy Coupon Code',
                                        text: 'An error occurred while trying to copy the coupon code: ' +
                                            error,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    });
                                });
                        }
                    });
                },
                error: function(xhr, status, error) {
                    // Show error message using SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while creating the coupon: ' +
                            error,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
