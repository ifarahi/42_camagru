const comment = document.querySelectorAll('#comment');
const like = document.querySelectorAll('#likes');

comment.forEach(comment => comment.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData();

    formData.append('comment', e.target.comment.value);
    formData.append('image_id', e.target.image_id.value);
    const url = 'http://localhost:8001/camagru/gallery/comment';

    e.target.comment.value = '';
    fetch(url, {
        method: 'POST',
        body: formData,
        }).then((response) => response.json())
        .then((info) => showComment(info))
    }
));

function showComment(info){
    const commentList = document.querySelector(`#commentList-${info.image_id}`);
    if (info['status'] == 'OK')
    {
        const space = document.createElement('div');
        space.innerHTML = "&nbsp;&nbsp;";
        const img = document.createElement('img');
        const comment = document.createTextNode(info.comment);
        const list = document.createElement('li');
        list.className = 'list-group-item d-flex align-items-center';
        const span = document.createElement('span');
        span.className = 'badge badge-info badge-pill mr-3';
        img.className = 'class="gall-profile';
        img.setAttribute('src',`http://localhost:8001/camagru/${info['profile_img']}`);
        img.setAttribute('style', 'height: 40px; border-radius: 50%; width: 40px;')
        span.textContent = info.username;
        list.appendChild(img);
        list.appendChild(space);
        list.appendChild(span);
        list.appendChild(comment);
        commentList.appendChild(list);

    } else {
        console.log(info['error']);
    }

};

like.forEach(like => like.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData();

    formData.append('image_id', e.target.image_id.value);
    const url = 'http://localhost:8001/camagru/gallery/like';

    fetch(url, {
        method: 'POST',
        body: formData,
        }).then((response) => response.json())
        .then((info) => showLike(info))
    }
));


function showLike(info){
    const likeBtn = document.querySelector(`#btn-${info.image_id}`);
    const likeNbr = document.querySelector(`#like-number-${info.image_id}`);

    if (info['status'] == 'ON'){
        likeBtn.className = 'mb-2 btn btn-danger btn-sm';
        likeBtn.firstElementChild.className = 'far fa-thumbs-down';
        numberOfLikes = parseInt(likeNbr.textContent);
        likeNbr.textContent = numberOfLikes + 1;
        // console.log(numberOfLikes + 10);
    }
    if (info['status'] == 'OFF'){
        likeBtn.className = 'mb-2 btn btn-success btn-sm';
        likeBtn.firstElementChild.className = 'far fa-thumbs-up';
        numberOfLikes = parseInt(likeNbr.textContent);
        likeNbr.textContent = numberOfLikes - 1;
        // console.log(numberOfLikes + 10);
    }

}
