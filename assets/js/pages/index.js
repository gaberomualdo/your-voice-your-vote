// this is the JavaScript file only used in the index.php file

// function for displaying authentication/sign-in error
function displayAuthenticationError(errorMessage){
    document.querySelector("body > nav > ul > p.error_box").innerText = errorMessage;
    document.querySelector("body > nav > ul > p.error_box").style.display = "inline-block";
}

// login with Google when button is clicked
document.querySelector("body > nav > ul > button").addEventListener("click", () => {
    // before anything happens, run basic error checks;
    // all errors found will be displayed in error box,
    // and the login will be aborted.
    
    // Check if has Internet connection
	if(!navigator.onLine){
        displayAuthenticationError("No Internet Connection");
        return;
	}

	// Check if firebase exists, if not: server error
	if(typeof firebase == "undefined"){
        displayAuthenticationError("Server Error");
        return;
	}
    
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
            // Handle errors and display error message

            // display error message accordingly
            switch(error.code){
                case "auth/popup-blocked":
                    displayAuthenticationError("Sign in popup window was blocked.");
                    break;
                case "auth/popup-closed-by-user":
                    displayAuthenticationError("Sign in within popup was never completed.");
                    break;
                case "auth/cancelled-popup-request":
                    displayAuthenticationError("Sign in popup already created.");
                    break;
                default:
                    displayAuthenticationError("An error occured: \"" + error.code + "\".");
            }
        });
    }
});