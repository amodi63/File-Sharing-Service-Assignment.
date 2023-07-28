
Dropzone.autoDiscover = false;
var uploadedDocuments = [];
var linkToCopy;

Dropzone.options.documentDropzone = {
    url: uplaodFileURL,
    maxFilesize: 20, // MB
    addRemoveLinks: true,
    autoProcessQueue: false,
    parallelUploads: 10,
    headers: {
        'X-CSRF-TOKEN': CSRF
    },
    init: function() {

        this.on("success", function(file, response) {
            uploadedDocuments.push(response.name);
        });

        this.on("removedfile", function(file) {
            this.removeFile(file);
            var name = file.upload.filename || '';
            var index = uploadedDocuments.indexOf(name);
            if (index !== -1) {
                uploadedDocuments.splice(index, 1);
            }
        });
        this.on("queuecomplete", function() {
            var url = saveFileURL;
            var data = {
                documents: uploadedDocuments
            };
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': CSRF
                },
                success: function(response) {
                    linkToCopy = response.link;
                    var successAlert = document.getElementById("successAlert");
                    var urlToCopyElement = document.getElementById("urlToCopy");
                    urlToCopyElement.textContent = linkToCopy;
                    successAlert.style.display = "block";
                },
                error: function(error) {
                    alert('Error: ' + error.responseText);
                }
            });
        });
    }
};

var documentDropzone = new Dropzone(".dropzone");
document.getElementById('uploadButton').addEventListener('click', function() {
    documentDropzone.processQueue();
});

function copyURL() {
    var urlToCopyElement = document.getElementById("urlToCopy");
    var urlToCopy = urlToCopyElement.textContent;

    if (urlToCopy) {
        copyToClipboard(urlToCopy);
        var copyButton = document.getElementById("copyButton");
        copyButton.style.display = "none";
        var copyButtonText = document.getElementById("copyButtonText");
        copyButtonText.style.display = "inline-block";
        setTimeout(function() {
            copyButtonText.style.display = "none";
            copyButton.style.display = "inline-block";
        }, 2000);
    }
}


function copyToClipboard(text) {
    var dummyTextArea = document.createElement("textarea");
    dummyTextArea.value = text;
    document.body.appendChild(dummyTextArea);
    dummyTextArea.select();
    document.execCommand("copy");
    document.body.removeChild(dummyTextArea);
}
