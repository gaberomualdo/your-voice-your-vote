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
            text-align: center;
        }

        /* container */
        body > div.container {
            padding: 3.75rem 0;
            display: inline-block;
            width: 750px;
            text-align: left;
        }

        /* container is full width (apart from a small margin) on smaller screens */
        @media only screen and (max-width: 750px) {
            body > div.container {
                width: calc(100% - 1.5rem) !important;
            }
        }

        /* style container header */
        body > div.container > h1.header {
            text-align: center;
            font-size: 2.75rem;
            line-height: 1.375;
        }

        /* style voting duration input */

        /* input container */
        body > div.container > div.voting_duration_input {
            margin-top: 1.25rem;
            min-height: 3rem;
            box-sizing: border-box;
            padding: 0.5rem 0;
        }
        
        /* style all direct children of input container */
        body > div.container > div.voting_duration_input > * {
            display: block;
            float: left;
        }

        /* input labels */
        body > div.container > div.voting_duration_input > p, body > div.container > div.voting_duration_input > strong {
            font-size: 1rem;
            line-height: 1.75rem;
            min-height: 1.75rem;
        }

        /* input main bolded label */
        body > div.container > div.voting_duration_input > strong {
            margin-right: 1rem;
        }

        /* input */
        body > div.container > div.voting_duration_input > input[type=number] {
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
        body > div.container > div.voting_duration_input > input[type=number]:focus {
            border-color: #000;
        }

        /* style footer */
        body > div.container > footer {
            text-align: center;
            padding: 1.25rem 0;
            border-top: 1px solid #ccc;
        }

        /* style proposals to approve section */
        body > div.container > ul.proposals_to_approve {
            overflow: hidden;
            padding: 2.5rem 0;
        }
        </style>
    </head>

    <!-- BODY -->
    <body>
        <!-- site content and container DIV -->
        <div class="container">
            <!-- header -->
            <h1 class="header">Submission Platform</h1>

            <!-- input box to enter voting duration in days -->
            <div class="voting_duration_input">
                <strong>Proposal Voting Duration: </strong>
                <input type="number" value="7" min="0" max="365">
                <p>days</p>
            </div>
            

            <!-- parent element of proposals to approve -->
            <ul class="proposals_to_approve">

            </ul>

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
        
        // configure and initialize firebase
        firebase.initializeApp(<?php include "../assets/json/firebase_config.json"; ?>);
        
        // variable for firebase database object
        const databaseObj = firebase.database();

        // IIFE with voting duration box event(s)
        (() => {
            // variable for voting duration input box element
            const votingDurationInputElement = document.querySelector("body > div.container > div.voting_duration_input > input[type=number]");
            
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
            const proposalsToApproveElement = document.querySelector("body > div.container > ul.proposals_to_approve");

            // clear any submissions that are currently displayed
            proposalsToApproveElement.innerHTML = "";

            // loop through submissions and display
            for (const objectID in submissionPlatformContent) {
                // add HTML of current submission to beginning of proposalsToApproveElement HTML
                proposalsToApproveElement.innerHTML = `
                <div class="proposal">
                    <h1 class="title">${submissionPlatformContent[objectID].title}</h1>
                    <p class="description">${submissionPlatformContent[objectID].description}</p>
                    <div class="buttons_container">
                        <button class="approve" onclick="approveProposal('${objectID}')">Approve Proposal</button>
                    </div>
                </div>
                ` + proposalsToApproveElement.innerHTML;
            }
        });

        // function to approve proposal
        const approveProposal = function(proposalID){
            // get value of submission, and move that value to the proposals object
            databaseObj.ref("submission_platform/" + proposalID + "/").once("value", (snapshot) => {
                // variable for value of submission
                const submissionObjContent = snapshot.val();

                // add value to proposals object
                databaseObj.ref("proposals/").push(submissionObjContent);

                // remove object from submission platform
                databaseObj.ref("submission_platform/" + proposalID + "/").set(null);
            });
        };

        </script>
    </body>
</html>