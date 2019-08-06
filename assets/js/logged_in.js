// this is the main JavaScript file for all pages where the user is logged in.

// logout when logout button (in footer) is clicked.
document.querySelector("body > footer > ul.links > a.logout").addEventListener("click", () => {
    // if user exists, then logout
    const authObj = firebase.auth();
    if(authObj.currentUser) {
        authObj.signOut();
    }
});