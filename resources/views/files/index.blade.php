<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Files Table</title>
    <!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                All Files
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th class="text-center">Size</th>
                        <th class="text-center">Download Count</th>
                        <th class="text-center">Link Expireing Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @isset($files)
                        @forelse ($files as $file)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $file->name }}</td>
                                <td class="text-center">{{ $file->size . ' B' }}</td>
                                <td class="text-center">{{ $file->download_count }}</td>
                                <td class="text-center">
                                    @if ($file->isLinkExpired())
                                        <span class="badge text-bg-danger p-10">Expired Link</span>
                                    @else
                                        {{ $file->getExpirationDate() }}
                                </td>
                        @endif
                        <td class="text-center showLinkBtn"><a href="{{ route('files.getLink', $file->id) }}">Get Link</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No Files Found!</td>
                        </tr>
                        @endforelse
                    @endisset
                </tbody>
            </table>
        </div>
        @include('files.modals._show-link')
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
</body>

</html>

<script>
  $(function() {
      $('.showLinkBtn').click(function(e) {
        e.preventDefault()
          var _url  = $(this).find('a').attr('href');
    
          $.ajax({
              url: _url,
              type: 'GET',
              success: function(data) {
              
                if(data.status){

                  var fileLink = data.file_link;
                  $('#link-File').val(fileLink);
                  $('#dawnloadFileURl').attr('href', data.downloadRoute);
                  $('#fileModal').modal('show');
                }
              },
              error: function() {
                  alert('Failed to fetch file link.');
              }
          });
      });
  });
</script>

