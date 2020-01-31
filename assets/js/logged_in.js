// this is the main JavaScript file for all pages where the user is logged in.

// logout when logout button (in footer) is clicked.
document.querySelector("body > footer > ul.links > a.logout").addEventListener("click", () => {
    // if user exists, then logout
    const authObj = firebase.auth();
    if(authObj.currentUser) {
        authObj.signOut();
    }
});

// this function returns a formatted date given a date like "2019-01-01" --> "January 1, 2019"
function formatDateString(dateString) {
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const dateStringSplit = dateString.split("-");
    return months[parseInt(dateStringSplit[1]) - 1] + " " + parseInt(dateStringSplit[2]).toString() + ", " + dateStringSplit[0];
}

// set profile picture image function (called when authentication is loaded)
const setProfilePictureImageNav = () => {
    const authObj = firebase.auth();
    // get profile picture image URL and store in var
    const profilePictureURL = firebase.auth().currentUser.photoURL;

    // set profile picture image
    document.querySelector("body > nav > ul > button.profileimage_btn").style.backgroundImage = "url(" + profilePictureURL + ")"; 
};

// set profile box signed in name
const setProfileBoxName = () => {
    const authObj = firebase.auth();
    // get profile picture image URL and store in var
    const name = firebase.auth().currentUser.displayName;

    // set profile picture image
    document.querySelector("body > nav > ul > ul.profile_btns > li.welcome > span.display_name").innerText = name;     
}

// profile picture button functionality
document.querySelector("body > nav > ul > button.profileimage_btn").addEventListener("click", () => {
    document.querySelector("body > nav > ul > ul.profile_btns").classList.toggle("open");
});