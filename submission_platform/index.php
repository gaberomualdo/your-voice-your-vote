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
        <style>
        
        /* global styles */
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: #222;
        }

        /* container */
        body > div.container {
            padding: 3.75rem calc((100% - 750px) / 2);
            display: block;
            width: 100%;
            box-sizing: border-box;
        }

        /* container is full width (apart from a small margin) on smaller screens */
        @media only screen and (max-width: 750px) {
            body > div.container {
                padding: 2.5rem 0.75rem !important;
            }
        }

        /* style container header */
        body > div.container > h1.header {
            text-align: center;
            font-size: 2.75rem;
            line-height: 1.375;
        }

        /* style footer */
        body > div.container > footer {
            text-align: center;
            padding: 1.25rem 0;
            border-top: 1px solid #ccc;
        }

        /* display login_area and logged_in_area correctly depending on container DIV classname */
        body > div.container.not_logged_in > div.logged_in_area {
            display: none;
        }
        body > div.container.logged_in > div.login_area {
            display: none;
        }

        /* style authenticated area */

        /* voting duration input */

        /* input container */
        body > div.container > div.logged_in_area > div.voting_duration_input {
            margin-top: 1.25rem;
            min-height: 3rem;
            box-sizing: border-box;
            padding: 0.5rem 0;
            overflow: hidden;
        }
        
        /* all direct children of input container */
        body > div.container > div.logged_in_area > div.voting_duration_input > * {
            display: block;
            float: left;
        }

        /* input labels */
        body > div.container > div.logged_in_area > div.voting_duration_input > p, body > div.container > div.logged_in_area > div.voting_duration_input > strong {
            font-size: 1rem;
            line-height: 1.75rem;
            min-height: 1.75rem;
        }

        /* input main bolded label */
        body > div.container > div.logged_in_area > div.voting_duration_input > strong {
            margin-right: 1rem;
        }

        /* input */
        body > div.container > div.logged_in_area > div.voting_duration_input > input[type=number] {
            height: 1.75rem;
            line-height: calc(2rem - 2px);
            border: 1px solid #ccc;
            padding-left: 0.5rem;
            font-size: 1rem;
            width: 3.5rem;
            margin-right: 0.5rem;
            outline: none;
            box-sizing: border-box;
        }

        /* input focus */
        body > div.container > div.logged_in_area > div.voting_duration_input > input[type=number]:focus {
            border-color: #222;
        }

        /* proposals to approve section */
        body > div.container > div.logged_in_area > ul.proposals_to_approve {
            overflow: hidden;
            padding: 2rem 0;
        }

        /* proposal */
        body > div.container > div.logged_in_area > ul.proposals_to_approve > div.proposal {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 2rem;
            overflow: hidden;
            box-sizing: border-box;
        }

        /* margin between proposals */
        body > div.container > div.logged_in_area > ul.proposals_to_approve > div.proposal:not(:last-child) {
            margin-bottom: 2rem;
        }

        /* proposal title */
        body > div.container > div.logged_in_area > ul.proposals_to_approve > div.proposal > h1.title {
            font-size: 2.25rem;
            line-height: 1.35;
        }

        /* proposal description */
        body > div.container > div.logged_in_area > ul.proposals_to_approve > div.proposal > p.description {
            font-size: 1rem;
            line-height: 1.5;
            margin-top: 1rem;
        }

        /* buttons container  */
        body > div.container > div.logged_in_area > ul.proposals_to_approve > div.proposal > div.buttons_container {
            margin-top: 0.75rem;
        }

        /* buttons */
        body > div.container > div.logged_in_area > ul.proposals_to_approve > div.proposal > div.buttons_container > button {
            margin-right: 1rem;
            font-size: 1rem;
            line-height: calc(2rem - 1px);
            height: 2rem;
            padding: 0 0.5rem;
            border: 1px solid #ccc;
            box-sizing: border-box;
            background-color: transparent;
            cursor: pointer;
            outline: none;
            margin-top: 0.75rem;
        }

        /* buttons hover */
        body > div.container > div.logged_in_area > ul.proposals_to_approve > div.proposal > div.buttons_container > button:hover {
            background-color: #222;
            color: #fff;
            border-color: #222;
        }

        /* style login area */
        body > div.container > div.login_area {
            padding-top: 0.875rem;
            padding-bottom: 2.5rem;
            min-height: 2.5rem;
            text-align: center;
        }

        /* input and button */
        body > div.container > div.login_area > input[type=password], body > div.container > div.login_area > button {
            display: inline-block;
            border: 1px solid #ccc;
            height: 2.5rem;
            box-sizing: border-box;
            font-size: 1rem;
            padding: 0 0.75rem;
            outline: none;
            margin-top: 0.75rem;
        }

        /* input and button are full width on mobile devices */
        @media only screen and (max-width: 400px) {
            body > div.container > div.login_area > input[type=password], body > div.container > div.login_area > button {
                width: 100% !important;
            }
        }

        /* input and button focus/hover */
        body > div.container > div.login_area > input[type=password]:focus, body > div.container > div.login_area > button:hover {
            border-color: #222;
        }

        /* input only */
        body > div.container > div.login_area > input[type=password] {
            width: 300px;
            margin-right: 0.75rem;
            text-align: left;
        }

        /* button only */
        body > div.container > div.login_area > button {
            cursor: pointer;
        }

        /* button only hover */
        body > div.container > div.login_area > button:hover {
            background-color: #222;
            color: #fff;
        }
        </style>
    </head>

    <!-- BODY -->
    <body>

        <!-- site content and container DIV -->
        <div class="container not_logged_in">
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


                <!-- parent element of proposals to approve -->
                <ul class="proposals_to_approve">

                </ul>
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