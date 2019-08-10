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

    // variable for firebase authentication object
    const authObj = firebase.auth();

    // loop through proposals in database and sort into open and completed, and display in corresponding tab
    databaseObj.ref("proposals/").once("value", (snapshot) => {
        const databaseProposalsContent = snapshot.val();
        
        // variable for current date today
        let currentDateToday;
        (function(){
            const currentDateRightNow = new Date();
            const currentDateStringToday = currentDateRightNow.getFullYear() + "-" + currentDateRightNow.getMonth().toString().padStart(2, "0") + "-" + currentDateRightNow.getDate().toString().padStart(2, "0");
            
            currentDateToday = new Date(currentDateStringToday);
        })();

        // loop through proposals in database content and process/display
        for (const proposalID in databaseProposalsContent) {
            const currentProposal = databaseProposalsContent[proposalID];
            
            // the vote the current user cast
            let currentUserVote = null;

            // calculate how many votes for and against, and what vote the current user cast
            let votesFor = 0;
            let votesAgainst = 0;
            for (const voter in currentProposal.voters) {
                if(currentProposal.voters[voter] == "for") {
                    // add to votesFor variable if vote is for
                    votesFor++;
                }else if(currentProposal.voters[voter] == "against") {
                    // add to votesFor variable if vote is against
                    votesAgainst++;
                }

                // if vote was either for or against, and it was cast by current user, then set the currentUserVote variable
                if((currentProposal.voters[voter] == "against" || currentProposal.voters[voter] == "for") && voter == authObj.currentUser.email.split("@")[0]) {
                    currentUserVote = currentProposal.voters[voter];
                }
            }

            // check if vote for proposal has ended or not by comparing date_of_completion variable to current date
            const dateOfCompletionDate = new Date(currentProposal.date_of_completion);

            const daysUntilCompletion = (dateOfCompletionDate.getTime() - currentDateToday.getTime()) / (1000 * 3600 * 24);

            // generate HTML for proposal block
            const proposalBlockHTML = generateProposalBlockHTML(proposalID, currentProposal.title, currentProposal.description, votesFor, votesAgainst, { full_name: currentProposal.proposer.full_name, profile_picture: currentProposal.proposer.profile_picture_url }, daysUntilCompletion, currentUserVote);

            if(dateOfCompletionDate.getTime() < currentDateToday.getTime()){
                // vote is completed, therefore display in completed tab
                document.querySelector("body > div.container > div.tabs > div.completedProposalsTab").innerHTML += proposalBlockHTML;
            }else{
                // vote is open, therefore display in open tab
                document.querySelector("body > div.container > div.tabs > div.openProposalsTab").innerHTML += proposalBlockHTML;
            }
        }
    });
})();