<!DOCTYPE html>
<html lang="en">
    <!-- HEAD -->
    <head>
        <!-- META declarations -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <!-- page title -->
        <title>Submission Platform &bull; <?php
        // include site title after page title
        include "../assets/txt/site_title.txt";
        ?></title>

        <!-- favicons -->
        <link rel="apple-touch-icon" sizes="57x57" href="../assets/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="../assets/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="../assets/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="../assets/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="../assets/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="../assets/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="../assets/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="../assets/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="../assets/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="../assets/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
        <link rel="manifest" href="../manifest.json">
        <meta name="msapplication-TileColor" content="#DA1333">
        <meta name="msapplication-TileImage" content="../assets/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#DA1333">

        <!-- CSS -->
        <link rel="stylesheet" href="main.css">
    </head>

    <!-- BODY -->
    <body>
        <!-- site content and container DIV -->
        <div class="container not_logged_in">
            <!-- back to main site btn -->
            <a href="../" class="back_to_main_site"><?php include "back_arrow.svg"; ?> Back to Site</a>

            <!-- header -->
            <h1 class="header">Submission Platform</h1>
            <!-- login area -->
            <div class="login_area">
                <input type="password" placeholder="Submission Platform Password...">
                <button>Go!</button>
            </div>

            <!-- logged-in area -->
            <div class="logged_in_area">
                <!-- input box to enter voting duration in days -->
                <div class="voting_duration_input">
                    <strong>Proposal Voting Duration: </strong>
                    <input type="number" value="7" min="0" max="365">
                    <p>days</p>
                </div>

                <!-- loading -->
                <div class="loading">Loading...</div>

                <!-- tabs with proposals to approve and active proposals -->
                <div class="tabs">
                    <div class="proposals_to_approve tab"></div>
                    <div class="active_proposals tab"></div>
                </div>
            </div>

            <!-- footer with copyright and site author name -->
            <footer>
                <p>&copy; <?php include "../assets/txt/site_author.txt"; ?> 2019&ndash;Present</p>
            </footer>
        </div>

        <!-- import firebase for authentication and database -->
        <script src="https://www.gstatic.com/firebasejs/6.3.4/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/6.3.4/firebase-auth.js"></script>
        <script src="https://www.gstatic.com/firebasejs/6.3.4/firebase-database.js"></script>

        
        <script>

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
                        const proposalsToApproveElement = document.querySelector("body > div.container > div.logged_in_area > ul.proposals_to_approve");

                        // clear any submissions that are currently displayed
                        proposalsToApproveElement.innerHTML = "";

                        // loop through submissions and display
                        for (const objectID in submissionPlatformContent) {
                            // add HTML of current submission to beginning of proposalsToApproveElement HTML
                            proposalsToApproveElement.innerHTML = `
                            <div class="proposal">
                                <!-- proposal title and description -->
                                <h1 class="title">${submissionPlatformContent[objectID].title}</h1>
                                <p class="description">${submissionPlatformContent[objectID].description}</p>
                                
                                <!-- approve and reject proposal buttons -->
                                <div class="buttons_container">
                                    <button class="approve" onclick="if(confirm('Approve this proposal?')){ approveProposal('${objectID}'); alert('Proposer was: ${submissionPlatformContent[objectID].proposer.email}'); }">Approve Proposal</button>
                                    <button class="reject" onclick="if(confirm('Reject this proposal?')){ rejectProposal('${objectID}'); alert('Proposer was: ${submissionPlatformContent[objectID].proposer.email}'); }">Reject Proposal</button>
                                </div>
                            </div>
                            ` + proposalsToApproveElement.innerHTML;
                        }
                    });
                } else {
                    // if password was incorrect or there was an error with the request, alert to user, and focus password input
                    alert("Incorrect Password or Error");
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

                // add submissionObjContent to proposals section i ndatabase
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

        </script>
    </body>
</html>