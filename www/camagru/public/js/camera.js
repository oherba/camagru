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
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              //document.getElementById("demo").innerHTML = this.responseText;
            }
          };
        
        xhttp.open("POST",'http://localhost/camagru/posts/mergePic' ,true);
        
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