// this is the JavaScript file only used in the home.php file

// process tab button clicks with class changes to display tabs accordingly

// open proposals button
document.querySelector('body > div.container > ul.tabButtons > li.openProposalsButton').addEventListener('click', () => {
  document.querySelector('body > div.container').classList.remove('completedProposalsTabShown');
  document.querySelector('body > div.container').classList.add('openProposalsTabShown');
});

// completed proposals button
document.querySelector('body > div.container > ul.tabButtons > li.completedProposalsButton').addEventListener('click', () => {
  document.querySelector('body > div.container').classList.remove('openProposalsTabShown');
  document.querySelector('body > div.container').classList.add('completedProposalsTabShown');
});

// variable for firebase realtime database object
const databaseObj = firebase.database();

// variable for firebase authentication object
const authObj = firebase.auth();

// click functions for vote for and vote against for each proposal
const voteForProposal = (proposalID) => {
  // user email string to be hashed --> e.g. "john_smith" if email is "john_smith@school.edu"
  user_email_string = authObj.currentUser.email.split('@')[0];

  databaseObj.ref('proposals/' + proposalID + '/voters/' + getSHA256Hash(user_email_string) + '/').set('for');
};
const voteAgainstProposal = (proposalID) => {
  // user email string to be hashed --> e.g. "john_smith" if email is "john_smith@school.edu"
  user_email_string = authObj.currentUser.email.split('@')[0];

  databaseObj.ref('proposals/' + proposalID + '/voters/' + getSHA256Hash(user_email_string) + '/').set('against');
};

// functions and features that utilize database are put in this IIFE
(() => {
  // loop through proposals in database and sort into open and completed, and display in corresponding tab
  databaseObj.ref('proposals/').once('value', (snapshot) => {
    const databaseProposalsContent = snapshot.val();

    // variable for current date today
    let currentDateToday;
    (() => {
      const currentDateRightNow = new Date();
      const currentDateStringToday =
        currentDateRightNow.getFullYear() +
        '-' +
        (currentDateRightNow.getMonth() + 1).toString().padStart(2, '0') +
        '-' +
        currentDateRightNow.getDate().toString().padStart(2, '0');

      currentDateToday = new Date(currentDateStringToday);
    })();

    // loop through proposals in database content and process/display
    for (const proposalID in databaseProposalsContent) {
      const currentProposal = databaseProposalsContent[proposalID];

      // the vote the current user cast
      let currentUserVote = null;

      // user email hashed string --> e.g. "john_smith" if email is "john_smith@school.edu"
      user_email_hash = getSHA256Hash(authObj.currentUser.email.split('@')[0]);

      // calculate how many votes for and against, and what vote the current user cast
      let votesFor = 0;
      let votesAgainst = 0;
      for (const voter in currentProposal.voters) {
        if (currentProposal.voters[voter] == 'for') {
          // add to votesFor variable if vote is for
          votesFor++;
        } else if (currentProposal.voters[voter] == 'against') {
          // add to votesFor variable if vote is against
          votesAgainst++;
        }

        // if vote was either for or against, and it was cast by current user, then set the currentUserVote variable
        if ((currentProposal.voters[voter] == 'against' || currentProposal.voters[voter] == 'for') && voter == user_email_hash) {
          currentUserVote = currentProposal.voters[voter];
        }
      }

      // check if vote for proposal has ended or not by comparing date_of_completion variable to current date
      const dateOfCompletionDate = new Date(currentProposal.date_of_completion);

      const daysUntilCompletion = (dateOfCompletionDate.getTime() - currentDateToday.getTime()) / (1000 * 3600 * 24);

      // generate HTML for proposal block
      const proposalBlockHTML = generateProposalBlockHTML(
        proposalID,
        currentProposal.title,
        currentProposal.description,
        votesFor,
        votesAgainst,
        { full_name: currentProposal.proposer.full_name, profile_picture: currentProposal.proposer.profile_picture_url },
        daysUntilCompletion,
        currentUserVote,
        authObj.currentUser.displayName,
        currentProposal.isVote,
        Object.values(currentProposal.comments || {}).reverse()
      );

      if (dateOfCompletionDate.getTime() < currentDateToday.getTime()) {
        // vote is completed, therefore display in completed tab
        const completedProposalsTabElement = document.querySelector('body > div.container > div.tabs > div.completedProposalsTab');
        completedProposalsTabElement.innerHTML = proposalBlockHTML + completedProposalsTabElement.innerHTML;
      } else {
        // vote is open, therefore display in open tab
        const openProposalsTabElement = document.querySelector('body > div.container > div.tabs > div.openProposalsTab');
        openProposalsTabElement.innerHTML = proposalBlockHTML + openProposalsTabElement.innerHTML;
      }

      // refresh proposal block voting area when database value has changed
      databaseObj.ref('proposals/' + proposalID + '/').on('value', (snapshot) => {
        const databaseProposalContent = snapshot.val();

        // the vote the current user cast
        let currentUserVote = null;

        // calculate how many votes for and against, and what vote the current user cast
        let votesFor = 0;
        let votesAgainst = 0;
        for (const voter in databaseProposalContent.voters) {
          if (databaseProposalContent.voters[voter] == 'for') {
            // add to votesFor variable if vote is for
            votesFor++;
          } else if (databaseProposalContent.voters[voter] == 'against') {
            // add to votesFor variable if vote is against
            votesAgainst++;
          }

          // if vote was either for or against, and it was cast by current user, then set the currentUserVote variable
          if ((databaseProposalContent.voters[voter] == 'against' || databaseProposalContent.voters[voter] == 'for') && voter == user_email_hash) {
            currentUserVote = databaseProposalContent.voters[voter];
          }
        }

        // refresh proposal block with function
        refreshProposalBlockVotingAreaHTML(proposalID, votesFor, votesAgainst, currentUserVote);
      });
    }

    // set width of voting progress bar and continue to do so when window is resized
    const setWidthOfVotingProgressBar = () => {
      try {
        // get width of vote against button
        let voteAgainstButtonWidth = document.querySelector(
          'body > div.container > div.tabs > div > div.proposal_block:first-child > div.row:nth-child(2) > div.voting_button_container:first-child'
        ).offsetWidth;

        // get width of vote for button
        let voteForButtonWidth = document.querySelector(
          'body > div.container > div.tabs > div > div.proposal_block:first-child > div.row:nth-child(2) > div.voting_button_container:last-child'
        ).offsetWidth;

        // margin for error
        voteAgainstButtonWidth += 0.5;
        voteForButtonWidth += 0.5;

        // set voting progress width variable
        document
          .querySelector('body > div.container > div.tabs')
          .setAttribute('style', '--voting-progress-width: calc(100% - ' + (voteForButtonWidth + voteAgainstButtonWidth) + 'px);');
      } catch (err) {}
    };

    setWidthOfVotingProgressBar();
    window.addEventListener('resize', setWidthOfVotingProgressBar);

    // remove loading icon as database has loaded
    (() => {
      // variable for loading icon container element
      const loadingIconContainerElement = document.querySelector('body > div.container > div.loading_container');

      // remove loading icon container
      loadingIconContainerElement.parentNode.removeChild(loadingIconContainerElement);
    })();
  });
})();

// make search functionality

// list of content and IDs of every proposal
let proposalsContentList = [];

// generate proposal content and IDs list
(() => {
  // variable for firebase realtime database object
  const databaseObj = firebase.database();

  // get value of proposals in database and add content to list
  databaseObj.ref('proposals/').once('value', (snapshot) => {
    const databaseProposalsContent = snapshot.val();

    // loop through proposals in database content and add content and ID to list
    for (const proposalID in databaseProposalsContent) {
      proposalsContentList.push({
        title: databaseProposalsContent[proposalID].title.toLowerCase(),
        description: databaseProposalsContent[proposalID].description.toLowerCase(),
        name: databaseProposalsContent[proposalID].proposer.full_name.toLowerCase(),
        id: proposalID,
      });
    }
  });
})();

// handle input for search bar
document.querySelector('body > nav > ul > input.search').addEventListener('input', () => {
  // get new value of search bar (not case sensitive) and put into variable
  const searchQuery = document.querySelector('body > nav > ul > input.search').value.toLowerCase();

  // remove any current search results by looping through proposal blocks and deactivating

  // variable for list of active proposal blocks
  const activeProposalBlocks = Array.from(document.querySelectorAll('body > div.container > div.tabs > div > div.proposal_block.active'));

  // loop through active proposal blocks and remove "active" class
  activeProposalBlocks.forEach((element, index) => {
    element.classList.remove('active');
  });

  // reset search results button text to "Search Results"
  document.querySelector('body > div.container > ul.tabButtons > li.searchResultsButton').innerText = 'Search Results';

  // reset "no_results_found" class
  document.querySelector('body > div.container > ul.tabButtons > li.searchResultsButton').classList.remove('no_results_found');

  // if search query has content, process query and add search results
  if (searchQuery != '') {
    // variable for amount of search results found
    let searchResultsAmount = 0;

    // loop through proposals titles list and add any titles that match
    proposalsContentList.forEach((currentProposalObj, index) => {
      // if match is found, display match as a search result
      if (
        currentProposalObj.title.indexOf(searchQuery) > -1 ||
        currentProposalObj.description.indexOf(searchQuery) > -1 ||
        currentProposalObj.name.indexOf(searchQuery) > -1
      ) {
        document.getElementById('proposalBlock_' + currentProposalObj.id).classList.add('active');

        // add to search result amount variable
        searchResultsAmount++;
      }
    });

    // if no search results were found, display "no results found" as tab button label, and add "no_results_found" class
    if (searchResultsAmount == 0) {
      document.querySelector('body > div.container > ul.tabButtons > li.searchResultsButton').innerText = 'No Results Found';
      document.querySelector('body > div.container > ul.tabButtons > li.searchResultsButton').classList.add('no_results_found');
    }

    // add search class to container
    document.querySelector('body > div.container').classList.add('search_results_shown');
  } else {
    // remove search class as search query is empty
    document.querySelector('body > div.container').classList.remove('search_results_shown');
  }
});

window.addComment = (proposalID) => {
  let text = document.getElementById('comment_box_' + proposalID).value;
  text = text.trim();
  if (text.length === 0) return;
  databaseObj
    .ref('proposals/' + proposalID + '/comments/')
    .push({
      commentText: text,
      date: new Date().toISOString(),
    })
    .then(() => {
      document.getElementById('comment_box_' + proposalID).value = '';
      databaseObj.ref('proposals/' + proposalID + '/comments/').once('value', (e) => {
        const commentsHTML = generateCommentsHTML(Object.values(e.val() || {}).reverse(), proposalID);
        document.querySelector('#proposalBlock_' + proposalID + ' .row.comments').outerHTML = commentsHTML;
      });
    });
};
