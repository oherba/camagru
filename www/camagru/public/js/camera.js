(function () {
    var video = document.getElementById('video');
    canvas = document.getElementById('canvas');
    context = canvas.getContext('2d');
    photo = document.getElementById('photo');
    navigator.getMedia = navigator.getUserMedia ||
                         navigator.webKitGetUserMedia ||
                         navigator.mozGetUserMedia ||
                         navigator.msGetUserMedia;
    navigator.mediaDevices.getUserMedia({
        video: true,
        audio: false,
    }).then((stream) => {
        video.srcObject = stream;
        video.play();
    });
    document.getElementById('capture').addEventListener('click',function(){
        context.drawImage(video,0,0,400,300);
        photo.setAttribute('src', canvas.toDataURL('image/png'));
        //console.log(canvas.toDataURL('image/png'));
        var filter_choix = document.querySelector('input[name="filter"]:checked');
        var filter;
        if (filter_choix)
            filter = filter_choix.value;
        // var image_url = '../../public/images/'+filter+'.png';
        var image_url = filter+'.png';
        var formData = new FormData ();
        formData.append('camPicData',canvas.toDataURL('image/png'));
        formData.append('filter',image_url);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              //document.getElementById("demo").innerHTML = this.responseText;
              //var response = JSON.parse(httpRequest.responseText);
            }
          };
        
        xhttp.open("POST",'http://localhost/camagru/posts/mergePic' ,true);
        xhttp.send(formData);
    });
})();

function live_filter()
{
    var filter = document.querySelector('input[name="filter"]:checked').value;
    var filter_div = document.getElementById('live_filter');
    var setBtn = document.getElementById("capture");
    setBtn.disabled = false;
    image_url = 'url'+'("../images/'+filter+'.png")';
    filter_div.style.backgroundImage = image_url;
}