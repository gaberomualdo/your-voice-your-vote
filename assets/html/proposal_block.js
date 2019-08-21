// this function generates the HTML for a proposal block,
// which is shown in the logged-in homepage for a "feed"
// of proposals.

// this function is used in the main one for generating the HTML for the voting progress bar
const generateProposalBlockVotingAreaHTML = (proposal_id, votes_for, votes_against, current_user_vote) => {
    // calculate percentage of voters that voted for
    let votes_for_percentage;
    
    // case where no votes have been cast yet (just put 50%)
    if(votes_for + votes_against == 0) {
        votes_for_percentage = 50;
    }else {
        votes_for_percentage = Math.floor((votes_for / (votes_for + votes_against)) * 100);
    }
    
    // return HTML
    return `
    <div class="voting_progress">
        <div class="votes_for" style="width: ${votes_for_percentage}%; ${votes_for_percentage == 100 ? "border-radius: 3px;" : "" }"></div>
        <div class="votes_against" style="width: ${100 - votes_for_percentage}%; ${100 - votes_for_percentage == 100 ? "border-radius: 3px;" : "" }"></div>
        <p class="votes_for_label">${votes_for} in favor <span class='current_user_vote ${current_user_vote == "for" ? "active" : ""}'>(including you)</span></p>
        <p class="votes_against_label">${votes_against} against <span class='current_user_vote ${current_user_vote == "against" ? "active" : ""}'>(including you)</span></p>
    </div>
    `;
};

// this function refreshes the HTML and classnames for the voting area of the given proposal ID
const refreshProposalBlockVotingAreaHTML = (proposal_id, votes_for, votes_against, current_user_vote) => {
    // HTML element to refresh variable
    const votingAreaToRefresh = document.getElementById("proposalBlock_" + proposal_id).querySelector("div.row:nth-child(2)");

    // refresh voting progress bar with function
    votingAreaToRefresh.querySelector("div.voting_progress").outerHTML = generateProposalBlockVotingAreaHTML(proposal_id, votes_for, votes_against, current_user_vote);

    // refresh voting buttons

    // remove any active classes from voting buttons
    votingAreaToRefresh.querySelector("div.voting_button_container:first-child > button").classList.remove("active");
    votingAreaToRefresh.querySelector("div.voting_button_container:last-child > button").classList.remove("active");

    // add active class to voting area as necessary
    if(current_user_vote == "for"){
        votingAreaToRefresh.querySelector("div.voting_button_container:first-child > button").classList.add("active");
    }else if(current_user_vote == "against") {
        votingAreaToRefresh.querySelector("div.voting_button_container:last-child > button").classList.add("active");
    }
};

const generateProposalBlockHTML = (proposal_id, title, description, votes_for, votes_against, proposer, ends_in_days, current_user_vote, current_user_full_name) => {
    // limit description length to 50 words, and add "..." if needed
    let description_limited_length = description;
    if(description_limited_length.split(" ").length > 75){
        description_limited_length = description_limited_length.split(" ").slice(0, 50).join(" ") + "...";
    }

    // get string for vote_ends_in text block
    let vote_ends_in_string;
    if(ends_in_days == 0){
        vote_ends_in_string = `Voting ends <strong>today</strong>`;
    }else if(ends_in_days > 0){
        vote_ends_in_string = `Voting ends in <strong>${ends_in_days} ${ends_in_days == 1 ? "day" : "days"}</strong>`;
    }else{
        vote_ends_in_string = `Voting ended <strong>${ends_in_days * -1} ${ends_in_days == -1 ? "day" : "days"} ago</strong>`;
    }

    // return formatted HTML of proposal block
    return `
    <div class="proposal_block animated fadeInUpBig" id="proposalBlock_${proposal_id}">
        <!-- informational area -->
        <div class="row">
            <div class="col">
                <h1 class="title">${title}</h1>
                <p class="description_limited_length">${description_limited_length} ${description_limited_length == description ? "" : "<a onclick='this.parentElement.parentElement.classList.add(\"show_full_description\");'>(more)</a>"}</p>
                <p class="description_full_length">${description}</p>
            </div>
            <div class="col">
                <div class="proposer">
                    <img class="profile_picture" src="${proposer.profile_picture}">
                    <p>${proposer.full_name == current_user_full_name ? "You" : proposer.full_name}</p>
                </div>
                <div class="vote_ends_in">
                    ${getClockSVG()}
                    <p>${vote_ends_in_string}</p>
                </div>
            </div>
        </div>

        <!-- voting area -->
        <div class="row">
            <div class="voting_button_container">
                <!-- don't have voting button functionality if proposal is completed -->
                <button class="vote_for_button ${current_user_vote == "for" ? "active" : ""}" onclick="${ends_in_days < 0 ? "" : "voteForProposal('" + proposal_id + "');" }"><p>Vote For</p>${getLikeSVG()}</button>
            </div>
            ${generateProposalBlockVotingAreaHTML(proposal_id, votes_for, votes_against, current_user_vote)}
            <div class="voting_button_container">
                <!-- don't have voting button functionality if proposal is completed -->
                <button class="vote_against_button ${current_user_vote == "against" ? "active" : ""}" onclick="${ends_in_days < 0 ? "" : "voteAgainstProposal('" + proposal_id + "');" }">${getDislikeSVG()}<p>Vote Against</p></button>
            </div>
        </div>
    </div>
    `;
};