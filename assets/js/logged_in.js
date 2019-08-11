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

// make search functionality

// list of titles of every proposal
let proposalsTitlesList = [];

// generate proposal titles list
(() => {
    // variable for firebase realtime database object
    const databaseObj = firebase.database();

    // get value of proposals in database and add titles to list
    databaseObj.ref("proposals/").once("value", (snapshot) => {
        const databaseProposalsContent = snapshot.val();

        // loop through proposals in database content and add title to list
        for (const proposalID in databaseProposalsContent) {
            proposalsTitlesList.push(databaseProposalsContent[proposalID].title);
        }
    });
})();

