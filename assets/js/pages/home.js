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

// variable for firebase realtime database object
const databaseObj = firebase.database();

// variable for firebase authentication object
const authObj = firebase.auth();

// click functions for vote for and vote against for each proposal
const voteForProposal = (proposalID) => {
    databaseObj.ref("proposals/" + proposalID + "/voters/" + authObj.currentUser.email.split("@")[0] + "/").set("for");
}
const voteAgainstProposal = (proposalID) => {
    databaseObj.ref("proposals/" + proposalID + "/voters/" + authObj.currentUser.email.split("@")[0] + "/").set("against");
}

// functions and features that utilize database are put in this IIFE
(() => {
    // loop through proposals in database and sort into open and completed, and display in corresponding tab
    databaseObj.ref("proposals/").once("value", (snapshot) => {
        const databaseProposalsContent = snapshot.val();
        
        // variable for current date today
        let currentDateToday;
        (() => {
            const currentDateRightNow = new Date();
            const currentDateStringToday = currentDateRightNow.getFullYear() + "-" + (currentDateRightNow.getMonth() + 1).toString().padStart(2, "0") + "-" + currentDateRightNow.getDate().toString().padStart(2, "0");

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
            const proposalBlockHTML = generateProposalBlockHTML(proposalID, currentProposal.title, currentProposal.description, votesFor, votesAgainst, { full_name: currentProposal.proposer.full_name, profile_picture: currentProposal.proposer.profile_picture_url }, daysUntilCompletion, currentUserVote, authObj.currentUser.displayName);

            if(dateOfCompletionDate.getTime() < currentDateToday.getTime()){
                // vote is completed, therefore display in completed tab
                document.querySelector("body > div.container > div.tabs > div.completedProposalsTab").innerHTML += proposalBlockHTML;
            }else{
                // vote is open, therefore display in open tab
                document.querySelector("body > div.container > div.tabs > div.openProposalsTab").innerHTML += proposalBlockHTML;
            }

            // refresh proposal block voting area when database value has changed
            databaseObj.ref("proposals/" + proposalID + "/").on("value", (snapshot) => {
                const databaseProposalContent = snapshot.val();

                // the vote the current user cast
                let currentUserVote = null;

                // calculate how many votes for and against, and what vote the current user cast
                let votesFor = 0;
                let votesAgainst = 0;
                for (const voter in databaseProposalContent.voters) {
                    if(databaseProposalContent.voters[voter] == "for") {
                        // add to votesFor variable if vote is for
                        votesFor++;
                    }else if(databaseProposalContent.voters[voter] == "against") {
                        // add to votesFor variable if vote is against
                        votesAgainst++;
                    }

                    // if vote was either for or against, and it was cast by current user, then set the currentUserVote variable
                    if((databaseProposalContent.voters[voter] == "against" || databaseProposalContent.voters[voter] == "for") && voter == authObj.currentUser.email.split("@")[0]) {
                        currentUserVote = databaseProposalContent.voters[voter];
                    }
                }
                
                // refresh proposal block with function
                refreshProposalBlockVotingAreaHTML(proposalID, votesFor, votesAgainst, currentUserVote);
            });
        }

        // set width of voting progress bar
        (() => {
            // get width of vote against button
            const voteAgainstButtonWidth = document.querySelector("body > div.container > div.tabs > div > div.proposal_block > div.row:nth-child(2) > div.voting_button_container:first-child").offsetWidth;
            
            // get width of vote for button
            const voteForButtonWidth = document.querySelector("body > div.container > div.tabs > div > div.proposal_block > div.row:nth-child(2) > div.voting_button_container:last-child").offsetWidth;

            // set voting progress width variable
            document.querySelector("body > div.container > div.tabs").setAttribute("style", "--voting-progress-width: calc(100% - " + (voteForButtonWidth + voteAgainstButtonWidth) + "px);");
        })();

        // remove loading icon as database has loaded
        (() => {
            // variable for loading icon container element
            const loadingIconContainerElement = document.querySelector("body > div.container > div.loading_icon_container");

            // remove loading icon container
            loadingIconContainerElement.parentNode.removeChild(loadingIconContainerElement);
        })();
    });
})();