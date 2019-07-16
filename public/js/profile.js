const inputFile = document.getElementById('upload-profile-picture');
const uploadPicture = document.getElementById('uploadbutton');

inputFile.addEventListener('change', function(event) {
    const file = document.querySelector('[type=file]').files[0];
    const fileReader = new FileReader();

    if (file){
        if (file.size < 10)
            alert('Worning! select a valid picture');
        else {
            if (file.type.startsWith('image/')){
                if (file.size <= 4000000){
                    fileReader.onloadend = function (e){
                        const img = new Image();
                        img.onload = function (){
                            const canvas = document.getElementById('canvas');
                            const context = canvas.getContext('2d');
                            const profImage = document.getElementById('card-profile-image');

                            profImage.src = img.src;
                            context.drawImage(img, 0, 0, 500, 400);
                                        
                            uploadPicture.addEventListener('click', function(){

                                event.preventDefault();
                                var formData = new FormData();
                                url = 'http://localhost:8001/camagru/profile/uploadprofilepicture';
                                            
                                formData.append('file', file);
                                formData.append('imageSrc', canvas.toDataURL('image/png'));
                                
                                fetch(url, {
                                    method: 'POST',
                                    body: formData,
                                    }).then((response) => response.json())
                                    .then((info) => showImage(info))
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
    }
});

function showImage(info){
    if (info['status'] == 'OK'){
        const navProfileImage  = document.getElementById('nav-profile-img');
        const profileImage = document.getElementById('card-profile-image');
        profileImage.src = `data:image/png;base64,${info['image_src']}`;
        navProfileImage.src = `data:image/png;base64,${info['image_src']}`;
    } else {
        alert($info['error']);
    }
}