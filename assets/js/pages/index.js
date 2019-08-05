// login with Google when button is clicked
document.querySelector("body > nav > ul > button").addEventListener("click", () => {
    // create Google auth provider object
    var provider = new firebase.auth.GoogleAuthProvider();

    // show domain "@asl.org" at end of email field
    provider.setCustomParameters({
        "hd": "asl.org",
    });

    // if using mobile device, sign in with redirect; else, use popup
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        // sign in with redirect Google sign in site
        firebase.auth().signInWithRedirect(provider);
    }else{
        // sign in with Google sign in popup and handle errors
        firebase.auth().signInWithPopup(provider).catch(function(error) {
            // Handle errors and display error box with error message

            // display error message accordingly
            switch(error.code){
                case "auth/popup-blocked":
                    document.querySelector("body > nav > ul > p.error_box").innerText = "Sign in popup window was blocked.";
                    break;
                case "auth/popup-closed-by-user":
                    document.querySelector("body > nav > ul > p.error_box").innerText = "Sign in within popup was never completed.";
                    break;
                case "auth/cancelled-popup-request":
                    document.querySelector("body > nav > ul > p.error_box").innerText = "Sign in popup already created.";
                    break;
                default:
                    document.querySelector("body > nav > ul > p.error_box").innerText = "An error occured: \"" + error.message + "\"";
            }

            // display error box
            document.querySelector("body > nav > ul > p.error_box").style.display = "block";
        });
    }
});