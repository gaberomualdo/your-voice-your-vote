// this is the main JavaScript file, which includes global JavaScript functions for every page.

// this useless function (commented out) changes the theme color randomly every second
/*let theme_color = [218, 19, 51];
setInterval(function(){
    theme_color = [Math.floor(Math.random() * 256),Math.floor(Math.random() * 256),Math.floor(Math.random() * 256)];
    let dark_color = [theme_color[0] - 25, theme_color[1] - 25, theme_color[2] - 25];
    dark_color.forEach((item, index) => {
        if(item < 0){
            dark_color[index] = 0
        }
        if(item > 255){
            dark_color[index] = 255
        }
    });

    document.body.setAttribute("style", "--theme-color: rgb(" + theme_color.join(",") + "); --dark-color: rgb(" + dark_color.join(",") + ");");
}, 1000);*/

// configure and initialize firebase
firebase.initializeApp({
    apiKey: "AIzaSyCNOgpFbSJHlmsnB-uVQrVcPn4dX_gmImU",
    authDomain: "democracy-for-asl.firebaseapp.com",
    databaseURL: "https://democracy-for-asl.firebaseio.com",
    projectId: "democracy-for-asl",
    storageBucket: "",
    messagingSenderId: "816314598868",
    appId: "1:816314598868:web:ffa7a522bb3389ee"
});

// this function will execute after page has loaded and user either is logged in, or logs out
firebase.auth().onAuthStateChanged((user) => {
    // variable for current HTML page filename (file extension removed)
    let currentpage_filename = window.location.pathname.split("/").pop().split(".")[0];

    if(user && !user.email.endsWith("asl.org")) {
        // user is logged in, but user is using an email address
        // not hosted on asl.org, so display error and delete user
        // if at homepage; else, go to homepage.
        if(currentpage_filename == "index"){
            // display error in homepage, and then delete user
            displayAuthenticationError("Please use an @asl.org email address.");
            firebase.auth().currentUser.delete();
        }else {
            // go to homepage
            window.open("index.php", "_self");
        }
    }else if(user){
        // user is logged in, so redirect to logged-in homepage if not already in it
        if(currentpage_filename == "index"){
            window.open("home.php", "_self");
        }
    }else{
        // user is not logged in, so redirect to public homepage if not already in it
        if(currentpage_filename != "index"){
            window.open("index.php", "_self");
        }
    }
});
