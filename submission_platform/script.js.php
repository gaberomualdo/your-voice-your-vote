<?php header("Content-type: application/javascript"); ?>

// define array count function, taken from https://stackoverflow.com/questions/6120931/how-to-count-the-number-of-certain-element-in-an-array
Object.defineProperties(Array.prototype, {
    count: {
        value: function(value) {
            return this.filter(x => x==value).length;
        }
    }
});

// redirect to "/submission_platform/" if page is "/submission_platform"
if(!window.location.href.endsWith("/")) {
    window.open("submission_platform/", "_self");
}

// configure and initialize firebase
firebase.initializeApp(<?php include "../assets/json/firebase_config.json"; ?>);

// variable for firebase database object
const databaseObj = firebase.database();

// function for logging in
const loginToSubmissionPlatform = () => {
    // get value of password input
    const passwordInputValue = document.querySelector("body > div.container > div.login_area > input[type=password]").value;

    // check if password is correct using API

    // create API HTTP request object, and open site with GET variable of inputted password
    const request = new XMLHttpRequest();
    request.open("GET", "./password_is_correct.php?password=" + passwordInputValue, true);

    // when request has loaded, process response and statuses
    request.onload = () => {
        if(request.readyState == 4 && request.status == 200 && request.responseText == "true") {
            /* login was successful, so replace "not_logged_in" class in container DIV, and 
            add any scripts that are needed for the logged in site */

            // replace "not_logged_in" class in container DIV with "logged_in" class                    
            document.querySelector("body > div.container").classList.remove("not_logged_in");
            document.querySelector("body > div.container").classList.add("logged_in");

            // IIFE with voting duration box event(s)
            (() => {
                // variable for voting duration input box element
                const votingDurationInputElement = document.querySelector("body > div.container > div.logged_in_area > div.voting_duration_input > input[type=number]");
                
                // validate voting duration input box
                votingDurationInputElement.addEventListener("blur", function(){

                    // variable for numerical value of input box
                    const inputValue = parseInt(this.value);

                    // if there is no numerical value found, set value to zero and exit function
                    if(isNaN(inputValue)) {
                        this.value = "0";
                        return;
                    }

                    // if inputted value is not between 0 and 365, make value 0 or 365 correspondingly
                    if(inputValue < 0) {
                        this.value = "0";
                    }else if(inputValue > 365) {
                        this.value = "365";
                    }
                });
            })();

            // when the value of the submission platform database object is changed, update the HTML element container
            databaseObj.ref("submission_platform/").on("value", (snapshot) => {
                // variable for value of the data
                const submissionPlatformContent = snapshot.val();

                // variable for submissions container element
                const proposalsToApproveElement = document.querySelector("body > div.container > div.logged_in_area > div.tabs > div.tab.proposals_to_approve");

                // clear any submissions that are currently displayed
                proposalsToApproveElement.innerHTML = "";

                // loop through submissions and display
                for (const objectID in submissionPlatformContent) {
                    // add HTML of current submission to beginning of proposalsToApproveElement HTML
                    proposalsToApproveElement.innerHTML = `
                    <div class="proposal">
                        <!-- proposal title and description -->
                        <h1 class="title">${submissionPlatformContent[objectID].title}</h1>
                        <div class="description"><strong>Description: </strong><p>${submissionPlatformContent[objectID].description}</p></div>
                        
                        <!-- approve and reject proposal buttons -->
                        <div class="buttons_container">
                            <button class="approve" onclick="if(confirm('Approve this proposal?')){ approveProposal('${objectID}'); }">Approve Post</button>
                            <button class="reject" onclick="if(confirm('Reject this proposal?')){ rejectProposal('${objectID}'); alert('Proposal was by: ${submissionPlatformContent[objectID].proposer.email}'); }">Reject Post</button>
                        </div>
                    </div>
                    ` + proposalsToApproveElement.innerHTML;
                }

                // tab header
                proposalsToApproveElement.innerHTML = `<h1 class="tab_header">Submissions</h1>` + proposalsToApproveElement.innerHTML;
            });

            // when the value of the site proposals database is changed, update HTML
            databaseObj.ref("proposals/").on("value", (snapshot) => {
                // variable for value of the data
                const proposalsDatabaseContent = snapshot.val();

                // variable for active proposals container element
                const activeProposalsElement = document.querySelector("body > div.container > div.logged_in_area > div.tabs > div.tab.active_proposals");

                // clear any proposals that are currently displayed
                activeProposalsElement.innerHTML = "";

                // loop through proposals and display
                for (const objectID in proposalsDatabaseContent) {
                    // add HTML of current submission to beginning of activeProposalsElement HTML
                    activeProposalsElement.innerHTML = `
                    <div class="proposal">
                        <!-- proposal title, description, proposer, date of completion, and student votes -->
                        <h1 class="title">${proposalsDatabaseContent[objectID].title}</h1>
                        <div class="description"><strong>Description: </strong><p>${proposalsDatabaseContent[objectID].description}</p></div>
                        <div class="proposer"><strong>Proposer: </strong><p>${proposalsDatabaseContent[objectID].proposer.email}</p></div>
                        <div class="date_of_completion"><strong>Date of Completion: </strong><p>${proposalsDatabaseContent[objectID].date_of_completion}</p></div>

                        <!-- rescind proposal button -->
                        <div class="buttons_container">
                            <button class="rescind" onclick="if(confirm('Rescind this proposal?')){ rescindProposal('${objectID}'); }">Rescind Post</button>
                        </div>
                    </div>
                    ` + activeProposalsElement.innerHTML;
                }

                // tab header
                activeProposalsElement.innerHTML = `<h1 class="tab_header">Active Posts</h1>` + activeProposalsElement.innerHTML;
            });
        } else {
            // if password was incorrect or there was an error with the request, alert to user, and focus password input
            alert("Incorrect Password");
            document.querySelector("body > div.container > div.login_area > input[type=password]").focus();
        }
    };

    // send request
    request.send(null);
};

// when "go" button on login form is clicked, login to platform
document.querySelector("body > div.container > div.login_area > button").addEventListener("click", loginToSubmissionPlatform);

// when enter key is hit on password field, login
document.querySelector("body > div.container > div.login_area > input[type=password]").addEventListener("keydown", (event) => {
    if(event.keyCode == 13) {
        loginToSubmissionPlatform();
    }
});

// function to approve proposal
const approveProposal = function(proposalID){
    // get value of submission, and move that value to the proposals object
    databaseObj.ref("submission_platform/" + proposalID + "/").once("value", (snapshot) => {
        // variable for value of submission
        let submissionObjContent = snapshot.val();

        // add calculated completion date to value of submission object
        
        // calculate completion date and put in variable

        // variable for completion date string
        let completionDateString;

        // calculate completion date
        (() => {
            // voting duration input value
            const votingDurationDays = document.querySelector("body > div.container > div.logged_in_area > div.voting_duration_input > input[type=number]").value;

            // create new date object with votingDurationDays days added to date right now
            let completionDate = new Date();
            completionDate.setDate(completionDate.getDate() + parseInt(votingDurationDays));

            // calculate date string from completion date object
            completionDateString = completionDate.getFullYear() + "-" + (completionDate.getMonth() + 1).toString().padStart(2, "0") + "-" + completionDate.getDate().toString().padStart(2, "0");
        })();

        // set completion date in submission object
        submissionObjContent.date_of_completion = completionDateString;

        // add submissionObjContent to proposals section in database
        databaseObj.ref("proposals/").push(submissionObjContent);

        // remove object from submission platform
        databaseObj.ref("submission_platform/" + proposalID + "/").set(null);
    });
};

// function to reject proposal
const rejectProposal = function(proposalID){
    // remove object from submission platform
    databaseObj.ref("submission_platform/" + proposalID + "/").set(null);
};

// function to rescind proposal
const rescindProposal = function(proposalID){
    // get value of proposal, and move that value to the submission platform object
    databaseObj.ref("proposals/" + proposalID + "/").once("value", (snapshot) => {
        // variable for value of proposal
        let proposalObjContent = snapshot.val();

        // add submissionObjContent to submission platform section in database
        databaseObj.ref("submission_platform/").push(proposalObjContent);

        // remove object from submission platform
        databaseObj.ref("proposals/" + proposalID + "/").set(null);
    });
};