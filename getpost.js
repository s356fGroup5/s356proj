
(function () {

    var postRequest = function (url, params) {
        var form = new FormData();
        Object.keys(params).forEach(function (key) {
            form.append(key, params[key]);
        });

        var req = new XMLHttpRequest();
        req.open("POST", url);
        req.send(form);

        return new Promise(function (resolve, reject) {
            req.onload = function () {
                if (req.status === 200) {
                    resolve(JSON.parse(req.response));
                } else {
                    reject(req);
                }
            };
        });
    };

    var invokeLike = function (cid) {
        return postRequest("/ajax_like.php", {comment_id: cid});
    };

    var invokeDislike = function (cid) {
        return postRequest("/ajax_dislike.php", {comment_id: cid});
    };

    var posts = [].slice.call(document.querySelectorAll(".post"));

    posts.forEach(function (post) {
        var id = post.getAttribute("pid");
        var likeButton = post.querySelector(".like");
        var likeCount = post.querySelector(".like-count");
        var dislikeButton = post.querySelector(".dislike");
        var dislikeCount = post.querySelector(".dislike-count");

        likeButton.onclick = function (e) {
            e.preventDefault();
            console.log("like", id);

            invokeLike(id).then(function (res) {
                if (res.success) {
                    likeCount.innerHTML = String(res.count);
                } else {
                    alert("You have already liked this comment.");
                }
            });
        };

        dislikeButton.onclick = function (e) {
            e.preventDefault();
            console.log("dislike", id);

            invokeDislike(id).then(function (res) {
                if (res.success) {
                    dislikeCount.innerHTML = String(res.count);
                } else {
                    alert("You have already disliked this comment.");
                }
            });
        };

        // console.log(post, likeButton, likeCount, dislikeButton, dislikeCount);
    });

})();
