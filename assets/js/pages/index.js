// this is the JavaScript file only used in the index.php file

// trigger first login button from login button in container
document.querySelector("body > div.container > div.col:first-child > button.login_alias").addEventListener("click", () => {
    document.querySelector("body > nav > ul > button.login").click();    
});

// display animations when page is loaded
window.addEventListener("load", () => {
    // header animation
    document.querySelector("body > div.container > div.col:first-child > h1.catchy_header").classList.add("animation_shown");
    
    // button and text animations go after header animation is done (can be checked with last word transition time)
    const transitionTimeSeconds = parseInt(document.querySelector("body > div.container > div.col:first-child > h1.catchy_header > span.word_container:last-child > span.word_animated").style.transitionDelay.split("s")[0]) + 0.6;

    setTimeout(() => {
        // animate text
        document.querySelector("body > div.container > div.col:first-child > h1.catchy_header ~ p").style.opacity = "1";
        document.querySelector("body > div.container > div.col:first-child > h1.catchy_header ~ p").classList.add("fadeInUp");

        // animate button
        document.querySelector("body > div.container > div.col:first-child > button.login_alias").style.opacity = "1";
        document.querySelector("body > div.container > div.col:first-child > button.login_alias").classList.add("fadeInUp");
    }, transitionTimeSeconds * 1000);
});

// function for displaying authentication/sign-in error
const displayAuthenticationError = (errorMessage) => {
    // for mobile devices, simply alert; otherwise, display error box
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ){
        alert(errorMessage);
    } else{
        document.querySelector("body > nav > ul > p.error_box").innerText = errorMessage;
        document.querySelector("body > nav > ul > p.error_box").style.display = "inline-block";
    }
}

// when page is loaded after authenticating w/Google, check for errors
firebase.auth().getRedirectResult().catch((error) => {
    // Handle errors and display error message

    // display error message accordingly
    switch(error.code){
        case "auth/auth-domain-config-required":
            displayAuthenticationError("Server error.");
            break;
        case "auth/web-storage-unsupported":
        case "auth/operation-not-supported-in-this-environment":
            displayAuthenticationError("Browser/environment not supported.");
            break;
        case "auth/timeout":
            displayAuthenticationError("Server error.");
            break;
        case "auth/network-request-failed":
            displayAuthenticationError("Network connection error.");
            break;
        case "auth/too-many-requests":
            displayAuthenticationError("We detected unusual activity from this account.");
            break;
        case "auth/user-disabled":
            displayAuthenticationError("Account has been disabled by admin.");
            break;
        case "auth/user-token-expired":
            displayAuthenticationError("Sign in expired. Try again.");
            break;
        default:
            displayAuthenticationError("An error occured: \"" + error.code + "\".");
    }
})

// login with Google when button is clicked
document.querySelector("body > nav > ul > button.login").addEventListener("click", () => {
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
    
    // firebase authentication object
    const authObj = firebase.auth();

    // create Google auth provider object
    const provider = new firebase.auth.GoogleAuthProvider();

    // show domain "@asl.org" at end of email field
    provider.setCustomParameters({
        "hd": "asl.org",
    });

    // sign in with redirect (we previously used sign-in with popup, but
    // that failed in browsers which disabled cross-site tracking).
    authObj.signInWithRedirect(provider);
});