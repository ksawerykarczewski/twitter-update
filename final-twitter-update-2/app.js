async function postTweet() {
    // TODO: validate input fields
    // Pretend that all the data is valid
    var data = new FormData(document.querySelector("#formTweet"));

    // get the data from the form and 
    // it will make it ready to be passed via AJAX
    let bridge = await fetch('api-create-tweet.php', {
        "method": "POST",
        "body": data
    })
    if (bridge.status != 200) {
        console.log('error');
    }
    //console.log(bridge);
    let sResponse = await bridge.text()
    //console.log(sResponse);
    //let jResponse = JSON.parse(sResponse) // convert text into JSON
    //console.log(jResponse);
}

let latestReceivedTweetId = -1;

setInterval(async function () {
    let connection = await fetch(
        "api-get-tweets.php?latestReceivedTweetId=" + latestReceivedTweetId
    );
    let sTweets = await connection.text();
    let jTweets = JSON.parse(sTweets);

    if (connection.status != 200) {
        alert("error");
    }

    for (let i = 0; i < jTweets.length; i++) {
        if (latestReceivedTweetId < jTweets[i].id) {
            let tweet =
                `<div class='tweet' id='${jTweets[i].id}'>
                    <p>${jTweets[i].message}</p>
                    <button onclick='deleteTweet()'>delete</button>
                    <button onclick='updateTweet()'>update</button>
                </div>`;
            document.querySelector("#tweets").insertAdjacentHTML("afterbegin", tweet);
            latestReceivedTweetId = jTweets[i].id;
        }
    }
}, 1000);

async function deleteTweet() {
    let tweet = event.target.parentNode;
    let id = event.target.parentNode.id;
    tweet.remove();
    let connection = await fetch("api-delete-tweet.php?id=" + id);
    let sResponse = await connection.text();
    //let jResponse = JSON.parse(sResponse);
    console.log(sResponse);
}

async function updateTweet() {
    let tweet = event.target.parentNode;
    let id = event.target.parentNode.id;
    //console.log(id);
    let connection = await fetch("api-get-tweets.php?singleId=" + id);

    let sResponse = await connection.text();
    let jResponse = JSON.parse(sResponse);
    console.log(jResponse);
    let updateTweet =
        `
            <form name="form-update-tweet" id="form-update-tweet" onsubmit="return false;">
            <input type="text" name="update-tweet-message" id="update-tweet-message" value="" required minlength="3" maxlength="140" />
            <input type="text" hidden value="${id}" name="tweet-id" id="tweet-id" />
            <button onclick='cancelUpdate()'>cancel</button>
            <button class="save-update-btn" onclick='saveUpdate()'>save changes</button></form>
        `;
    tweet.innerHTML = updateTweet;
}

async function cancelUpdate() {
    let tweet = event.target.parentNode;
    let id = event.target.parentNode.id;
    console.log(tweet);
}

async function cancelUpdate() {
    let tweet = event.target.parentNode;
    let id = event.target.parentNode.id;
    let connection = await fetch("api-get-tweets.php?singleId=" + id);
    let sTweet = await connection.text();
    let jTweet = JSON.parse(sTweet);
    let oldTweet =
        `<div class='tweet' id='${jTweet.id}'><p>${jTweet.message}</p><button onclick='deleteTweet()'>delete</button><button onclick='updateTweet()'>update</button>
    </div>`;
    tweet.innerHTML = oldTweet;
}

async function saveUpdate() {
    let tweet = event.target.parentNode;
    let id = event.target.parentNode.id;
    //console.log(id);
    let connection = await fetch("api-get-tweets.php?singleId=" + id);
    let sResponse = await connection.text();
    //console.log(sResponse);

    let tweetTitle = document.forms["form-update-tweet"]["update-tweet-message"].value;
    //console.log(tweetTitle);

    let data = new FormData(document.querySelector("#form-update-tweet"));

    //console.log(data);

    let bridge = await fetch("api-update-tweet.php", {
        method: "POST",
        body: data
    });

    if (bridge.status != 200) {
        console.log("error");
    }

    let sTweet = await bridge.text();
    let jTweet = JSON.parse(sTweet);
    console.log(sTweet);
    console.log(jTweet.message);
    let updatedTweet =
        `<div class='tweet' id='${jTweet.id}'><p>${jTweet.message}</p><button onclick='deleteTweet()'>delete</button> <button onclick='updateTweet()'>update</button>
    </div>`;
    tweet.innerHTML = updatedTweet;
}
