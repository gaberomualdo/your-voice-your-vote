// this is the JavaScript file only used in the home.php file

// process tab button clicks with class changes to display tabs accordingly

// open proposals button
document.querySelector("body > div.container > ul.tabButtons > li.openProposalsButton").addEventListener("click", () => {
    document.querySelector("body > div.container").classList.remove("completedProposalsTabShown");
    document.querySelector("body > div.container").classList.add("openProposalsTabShown");
});

// completed proposals button
document.querySelector("body > div.container > ul.tabButtons > li.completedProposalsButton").addEventListener("click", () => {
    document.querySelector("body > div.container").classList.remove("openProposalsTabShown");
    document.querySelector("body > div.container").classList.add("completedProposalsTabShown");
});

// functions and features that utilize database are put in this IIFE
(function(){
    // variable for firebase realtime database object
    const databaseObj = firebase.database();

    // loop through proposals in database and sort into open and completed, and display in corresponding tab
    databaseObj.ref("proposals/").once("value", (snapshot) => {
        const databaseProposalsContent = snapshot.val();
        
        // loop through proposals in database content
        for (const proposalID in databaseProposalsContent) {
            console.log(proposalID);
        }
    });
})();