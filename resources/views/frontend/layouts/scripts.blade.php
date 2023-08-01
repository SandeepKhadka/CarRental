@yield('scripts')
{{-- <script src="https://cdn.tailwindcss.com"></script> --}}
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


{{-- autocomplete --}}
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        var path = "{{ route('autosearch') }}";
        $('#search_text').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: path,
                    dataType: "JSON",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 1
        });
    });
</script>
<script>
    setTimeout(function() {
        $("#alert").slideUp();
    }, 4000);

    $(document).on('click', '.cart_delete', function(e) {
        e.preventDefault();
        var cart_id = $(this).data('id');
        var token = "{{ csrf_token() }}";
        var path = "{{ route('cart.delete') }}";

        $.ajax({
            url: path,
            type: "POST",
            dataType: "JSON",
            data: {
                cart_id: cart_id,
                _token: token,
            },
            success: function(data) {
                console.log(data);
                if (data['status']) {
                    $('body #header-ajax').html(data['header']);
                    $('body #cart_counter').html(data['cart_count']);
                    Swal.fire({
                        icon: 'success',
                        title: 'Great',
                        text: data['message'],
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                // setTimeout(function() {
                //     location.reload();
                // }, 1500);
            },
            error: function(err) {
                console.log(err);
            }
        });

    });
</script>
<script>
    const cameraIcon = document.querySelector(".camera-icon");
    const uploadDialog = document.querySelector("#upload-dialog");

    cameraIcon.addEventListener("click", function() {
        uploadDialog.style.display = "block";
    });

    const cancelButton = document.querySelector("#cancel-button");

    cancelButton.addEventListener("click", function() {
        uploadDialog.style.display = "none";
    });

    const fileInput = document.querySelector("#image-upload");

    fileInput.addEventListener("change", function(event) {
        // Show preview of uploaded image
    });

    const uploadButton = document.querySelector("#upload-button");
</script>

<script>
    const imageUpload = document.getElementById("image-upload");
    const imagePreview = document.getElementById("image-preview");

    // Event listener for file input change
    imageUpload.addEventListener("change", function() {
        // Check if a file was selected
        if (this.files && this.files[0]) {
            // Create a new FileReader object
            const reader = new FileReader();

            // Set up a callback function for when the FileReader finishes loading the image
            reader.onload = function(e) {
                // Update the background image of the image preview element with the selected image
                imagePreview.style.backgroundImage = `url(${e.target.result})`;
            };

            // Read the selected file as a Data URL (which is a string that represents the file contents)
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Event listeners for drag and drop
    imagePreview.addEventListener("dragover", function(e) {
        // Prevent the default behavior of opening the file in the browser window
        e.preventDefault();
    });

    imagePreview.addEventListener("drop", function(e) {
        // Prevent the default behavior of opening the file in the browser window
        e.preventDefault();

        // Get the dragged file
        const file = e.dataTransfer.files[0];

        // Create a new FileReader object
        const reader = new FileReader();

        // Set up a callback function for when the FileReader finishes loading the image
        reader.onload = function(e) {
            // Update the background image of the image preview element with the selected image
            imagePreview.style.backgroundImage = `url(${e.target.result})`;
        };

        // Read the dropped file as a Data URL (which is a string that represents the file contents)
        reader.readAsDataURL(file);
    });
</script>

<script>
    const uploadForm = document.getElementById('upload-form');

    // Event listener for form submission
    uploadForm.addEventListener('submit', function(e) {
        // Prevent the default form submission behavior
        e.preventDefault();

        // Get the selected image (assuming you've already implemented the code to get the selected image)
        const selectedImage = imagePreview.style.backgroundImage;

        // Do something with the selected image (e.g. upload it to a server)

        // Submit the form
        this.submit();
    });
</script>
<script>
    const cancelButton = document.getElementById('cancel-button');
    const uploadDialog = document.getElementById('upload-dialog');

    // Event listener for cancel button
    cancelButton.addEventListener('click', function(e) {
        // Prevent the default form submission behavior
        e.preventDefault();

        // Hide the upload dialog
        uploadDialog.style.display = 'none';
    });
</script>
<script>
    const chatifyBtn = document.getElementById('chat-btn');
    const chatify = new Chatify();

    chatifyBtn.addEventListener('click', () => {
        chatify.toggle();
    });
</script>
<script>
    function submitForm() {
        document.getElementById("my-form").submit();
    }
</script>
<script>
    const menuToggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('nav');

    menuToggle.addEventListener('click', function() {
        this.classList.toggle('active');
        nav.classList.toggle('active');
    });
</script>
</body>

</html>
