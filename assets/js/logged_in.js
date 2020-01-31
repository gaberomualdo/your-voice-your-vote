// this is the main JavaScript file for all pages where the user is logged in.

// logout when logout button (in nav profile btns) is clicked.
document.querySelector("body > nav > ul > ul.profile_btns > .logout_btn").addEventListener("click", () => {
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
};

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
};

// profile picture button functionality
document.querySelector("body > nav > ul > button.profileimage_btn").addEventListener("click", () => {
    const profileBtnsBoxElm = document.querySelector("body > nav > ul > ul.profile_btns");
    profileBtnsBoxElm.classList.toggle("open");
});

// update profile picture box position
const updateProfilePictureBoxPosition = () => {
    // profile picture btn elm
    const profilePictureBtnElmRight = document.querySelector("body > nav > ul > button.profileimage_btn");

    // get profile picture btn elm position from right
    const profilePictureBtnElmRightOffset = window.innerWidth - profilePictureBtnElmRight.getBoundingClientRect().right;

    // set profile btns box position based on profile btn right offset
    document.querySelector("body > nav > ul > ul.profile_btns").style.right = profilePictureBtnElmRightOffset + "px";
};

window.addEventListener("load", updateProfilePictureBoxPosition);
window.addEventListener("resize", updateProfilePictureBoxPosition);

// update profile picture box size
const updateProfilePictureBoxSize = () => {
    // function to get rem in px
    function getREM(rem) {
        return rem * parseFloat(getComputedStyle(document.documentElement).fontSize);
    }

    // profile picture btn elm
    const profilePictureBtnElmRight = document.querySelector("body > nav > ul > button.profileimage_btn");

    // get profile picture btn elm position from right
    const profilePictureBtnElmRightOffset = window.innerWidth - profilePictureBtnElmRight.getBoundingClientRect().right;

    // if window size - right offset - 2rem > 20rem (size of box), resize box to fit window

    // full available area in px
    const availableArea = window.innerWidth - profilePictureBtnElmRightOffset - getREM(1);

    console.log(availableArea);
    console.log(getREM(20));

    if(availableArea < getREM(20)) {
        document.querySelector("body > nav > ul > ul.profile_btns").style.width = availableArea + "px";
    }else {
        document.querySelector("body > nav > ul > ul.profile_btns").style.width = "20rem";
    }
};

window.addEventListener("load", updateProfilePictureBoxSize);
window.addEventListener("resize", updateProfilePictureBoxSize);

// click out of profile picture box when opened/focused
document.addEventListener("click", (e) => {
    const profileBtnsBoxElmSelector = "body > nav > ul > ul.profile_btns";
    const profileBtnsBoxElm = document.querySelector(profileBtnsBoxElmSelector);
    const targetElm = event.target;
    
    const checkIfElmIsTarget = (target, elmSelector) => {
        return !(!target.closest(elmSelector) || target.closest(elmSelector).length == 0);
    }

    if(!checkIfElmIsTarget(targetElm, profileBtnsBoxElmSelector) && !checkIfElmIsTarget(targetElm, "body > nav > ul > button.profileimage_btn") && profileBtnsBoxElm.classList.contains("open")) {
        profileBtnsBoxElm.classList.remove("open");

    }
});