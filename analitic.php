    <!DOCTYPE html>
    <html>
    <head>
        <title>Analyze Sample</title>
        <script src="jquery.min.js"></script>
    </head>
    <body>
     <input type="hidden" id="img-anal" value="<?php echo $_GET['images']; ?>">
    <script type="text/javascript">
    $(document).ready(function () {
        // **********************************************
        // *** Update or verify the following values. ***
        // **********************************************
     
        // Replace <Subscription Key> with your valid subscription key.
        var subscriptionKey = "d1c4c24ac4424181a93314962132196e";
     
        // You must use the same Azure region in your REST API method as you used to
        // get your subscription keys. For example, if you got your subscription keys
        // from the West US region, replace "westcentralus" in the URL
        // below with "westus".
            //
        // Free trial subscription keys are generated in the "westus" region.
        // If you use a free trial subscription key, you shouldn't need to change
        // this region.
        var uriBase = "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";
     
        // Request parameters.
        var params = {
            "visualFeatures": "Categories,Description,Color",
            "details": "",
            "language": "en",
        };
     
        // Display the image.
        var sourceImageUrl = document.getElementById("img-anal").value;
        document.querySelector("#sourceImage").src = sourceImageUrl;
     
        // Make the REST API call.
        $.ajax({
            url: uriBase + "?" + $.param(params),
     
            // Request headers.
            beforeSend: function(xhrObj){
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader(
                    "Ocp-Apim-Subscription-Key", subscriptionKey);
            },
     
            type: "POST",
     
            // Request body.
            data: '{"url": ' + '"' + sourceImageUrl + '"}',
        }).done(function(data) {
            // Show formatted JSON on webpage.
            $("#responseTextArea").val(JSON.stringify(data, null, 2));
            $("#description").text(data.description.captions[0].text);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            // Display error message.
            var errorString = (errorThrown === "") ? "Error. " :
                errorThrown + " (" + jqXHR.status + "): ";
            errorString += (jqXHR.responseText === "") ? "" :
                jQuery.parseJSON(jqXHR.responseText).message;
            alert(errorString);
        }); 
    });
    </script>
     
    <h1>Analyze image:</h1>
    <br><br>
    <div id="wrapper" style="width:1020px; display:table;">
        <div id="jsonOutput" style="width:600px; display:table-cell;">
            Response:
            <br><br>
            <textarea id="responseTextArea" class="UIInput"
                      style="width:580px; height:400px;"></textarea>
        </div>
        <div id="imageDiv" style="width:420px; display:table-cell;">
            Source image:
            <br><br>
            <img id="sourceImage" width="400" />
            <h3 id="description"></h3>
        </div>
    </div>
    </body>
    </html>