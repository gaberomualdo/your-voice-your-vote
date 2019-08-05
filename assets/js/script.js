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

    if(user){
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
