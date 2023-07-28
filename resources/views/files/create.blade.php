<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>File Sharing Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css"
        integrity="sha512-WvVX1YO12zmsvTpUQV8s7ZU98DnkaAokcciMZJfnNWyNzm7//QRV61t4aEr0WdIa4pe854QHLTV302vH92FSMw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css"
        integrity="sha512-hwwdtOTYkQwW2sedIsbuP1h0mWeJe/hFOfsvNKpRB3CkRxq8EW7QMheec1Sgd8prYxGm1OM9OZcGW7/GUud5Fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    @if ($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
    @endif
    <section style="padding-top:60px;">
        <div class="container">
          
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <form action="{{ route('files.store') }}" method="post" enctype="multipart/form-data"
                        class=" dz-clickable" id="files-upload-form">
                        <div class="card">
                            <div class="card-header">
                                Files Upload
                            </div>
                            <div class="card-body">
                                @csrf
                                <div class="form-group text-center">
                                    <h3>Upload Files By Clicking on the Box</h3>
                                    <div class="dropzone" id="document-dropzone"></div>

                                </div>
                                {{-- <div class="text-center">
                                    <h3>Upload Files By Clicking on the Box</h3>
                                </div>
                                <div class="dz-default dz-message"><span>Drop files here to upload</span></div> --}}
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <button type="button" id="uploadButton" class="btn btn-primary">Upload</button>
                            </div>
                        </div>
                    </form>
                    <div class="mt-5 alert alert-success mt-2 alert-dismissible fade show" role="alert"
                        id="successAlert" style="display:none; ">

                        <h5>Uploaded Files Completed. </h5>
                        <div class="d-flex" style="justify-content: space-between;  " style="display: none;">
                            <div>

                                <i> URL: <span id="urlToCopy"> </span> </i>
                            </div>
                            <button id="copyButton" class="btn btn-primary" onclick="copyURL()">Copy URL</button>
                            <span id="copyButtonText" style="display: none;">Copied!</span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                    </div>


                </div>
            </div>
        </div>
    </section>
    <script>
        var uplaodFileURL = "{{ route('files.upload') }}";
        var saveFileURL = "{{ route('files.store') }}";
        var CSRF = "{{ csrf_token() }}";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"
        integrity="sha512-oQq8uth41D+gIH/NJvSJvVB85MFk1eWpMK6glnkg6I7EdMqC1XVkW7RxLheXwmFdG03qScCM7gKS/Cx3FYt7Tg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"
        integrity="sha512-MqEDqB7me8klOYxXXQlB4LaNf9V9S0+sG1i8LtPOYmHqICuEZ9ZLbyV3qIfADg2UJcLyCm4fawNiFvnYbcBJ1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets/js/upload-file.js') }}"> </script>
</body>

</html>
