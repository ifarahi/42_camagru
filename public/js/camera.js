const filters = document.getElementById('photo-filter');
// const takePicture = document.getElementById('startbutton');
var capture = document.getElementById('startbutton');
const inputFile = document.getElementById('upload-file');
const uploadPicture = document.getElementById('uploadbutton');

/*-----------------------------------------------------------------------------------------------
*** Starting of the upload part .
 */

inputFile.addEventListener('change', function(event) {
    const file = document.querySelector('[type=file]').files[0];
    const fileReader = new FileReader();

    if (file){
        if (file.type.startsWith('image/')){
            if (file.size <= 4000000){
                fileReader.onloadend = function (e){
                    const img = new Image();
                    img.onload = function (){
                        const canvas = document.getElementById('canvas');
                        const context = canvas.getContext('2d');
                        const selectFileSection = document.querySelector('#inputg').remove();
                        const videoSection = document.querySelector('#video');
                        const orSection = document.querySelector('#strike');
                        const displaySection = document.querySelector('#imageshow');
                        capture.setAttribute('style', 'display: none');
                        uploadPicture.setAttribute('style', 'display: block');
                        const imageSrc = URL.createObjectURL(file);

                        if (videoSection)
                            videoSection.remove();
                        if (orSection)
                            orSection.remove();
                        
                        filters.removeAttribute('disabled');
                        displaySection.setAttribute('src', imageSrc);
                        displaySection.classList.add('w-100');
                        context.drawImage(img, 0, 0, 500, 400);
                                    
                        uploadPicture.addEventListener('click', function(){
                        if (filters.value != 'big_smile' && filters.value != 'christmas_hat' && filters.value != 'golden_crown' && filters.value != 'thumbs_up'){
                            alert('Worning! you should select a filter');
                        } else {
                            event.preventDefault();
                            var formData = new FormData();
                            url = 'http://localhost:8001/camagru/camera/uploadedImages';
                                        
                            formData.append('file', file);
                            formData.append('imageSrc', canvas.toDataURL('image/png'));
                            formData.append('filter', filters.value);
                                
                            fetch(url, {
                                method: 'POST',
                                body: formData,
                                }).then((response) => response.json())
                                .then((info) => showImage(info))
                            }
                        });
                    };
                    img.onerror = function () {
                        alert('Worning! select a valid picture');
                    };
                    img.src = e.target.result;
                };
                fileReader.readAsDataURL(file);
            } else {
                alert('Too big 4MB picture is the max!')
            }
        }
    }
});

/*-----------------------------------------------------------------------------------------------
*** End of the upload part .
 */






/*-----------------------------------------------------------------------------------------------
*** Starting of the camera part .
 */

// select the filter to controll it (enable or disable or change it)
var filterImage = document.getElementById('filterimg');

// select all the buttons include a class named .delete-image
var deleteImg = document.querySelectorAll('.delete-image');

// Add an eventlistener to every button has the .delete-image class
deleteImg.forEach(elem => elem.addEventListener('click', deleteImage));

// reSelect fucntion work when we add new image to the page with JS it wont have the eventlistener added by the foreach 
function reSelect(){
    deleteImg = document.querySelectorAll('.delete-image');
    deleteImg[0].addEventListener('click', deleteImage);
}


(async function (){

    try {
    var video  = document.getElementById('video');

    const params = {
        audio: false, 
        video: {width: 500, height: 400}
    };
    const stream = await navigator.mediaDevices.getUserMedia(params);
    video.srcObject = stream;
    video.play();
    } catch (error) {
        capture.setAttribute('style', 'display: none');
        uploadPicture.setAttribute('style', 'display: block');
        const videoSection = document.querySelector('#video').remove();
        const orSection = document.querySelector('#strike').remove();
        filters.setAttribute('disabled', "");

    };
    // send the image to the server to be added and call showImage function to show it up on the page
    
})();


capture.addEventListener('click', function(){
    var canvas = document.getElementById('canvas');
    var context = canvas.getContext('2d');
    
    if (filters.value != 'big_smile' && filters.value != 'christmas_hat' && filters.value != 'golden_crown' && filters.value != 'thumbs_up'){
        alert('Worning! you should select a filter');
    } else {
        event.preventDefault();
        context.drawImage(video, 0, 0, 500, 400);
        var formData = new FormData();
        url = 'http://localhost:8001/camagru/camera/capturedImages';
    
        formData.append('image', canvas.toDataURL('image/png'));
        formData.append('filter', filters.value);

        fetch(url, {
        method: 'POST',
        body: formData,
        }).then((response) => response.json())
        .then((info) => showImage(info))
    }
});

// This is function only show the image newly added when it as already sent and added to the database with ajax
function    showImage(info){
    if (info['status'] == 'OK'){
        const imageHolder = document.getElementById('image-holder');
        const imageHolderChild = imageHolder.firstElementChild;
        const element = document.createElement('div');
        element.innerHTML = `
        <img class="w-100 mb-2"  src="data: image/png;base64,${info['image_src']}">
        </form>
        <form action="#" method="post">
        <input type="hidden" name="${info['image_row']['id']}" value="${info['image_row']['image_url']}">
        <button class="btn btn-primary btn-block mb-2 delete-image">Delete this picture</button>
        </form>
        `;
        imageHolder.insertBefore(element, imageHolderChild);
        reSelect();
    } else {
        alert(info['error']);
    }
}

// deleteImage not only delete the image from the page on the user side its also sent an http request in the background
// to the server to delete the image from the database and physically from the server
function    deleteImage(event){
    event.preventDefault();
    const formData = new FormData();
    url = 'http://localhost:8001/camagru/camera/deleteImage';
    formData.append('image_id', event.target.parentElement.firstElementChild.name);
    formData.append('image_url', event.target.parentElement.firstElementChild.value);
    fetch(url, {
        method: 'POST',
        body: formData,
    }).then((response) => response.text())
    .then((info) => console.log(info))
    event.target.parentElement.previousElementSibling.remove();
    event.target.parentElement.remove();
}


// Check if the filter has been slected then allow the user to take picture
filters.addEventListener('change', function (event){
    // even is the change event is faired check if its not the none
    if (this.value !== 'none' && filters.value == 'big_smile' || filters.value == 'christmas_hat' || filters.value == 'golden_crown' || filters.value == 'thumbs_up'){
        capture.removeAttribute('disabled');
        uploadPicture.removeAttribute('disabled');
        filterImage.setAttribute('src', `img/filters/${this.value}.png`);
        filterImage.setAttribute('style', 'display: block;');
    }
    else {
        uploadPicture.setAttribute('disabled', "");
        capture.setAttribute('disabled',"");
        filterImage.setAttribute('style', 'display: none;');
    }
})


/*------------------------------------------------------------------------------------------------------
*** End of the camera part .
 */ 