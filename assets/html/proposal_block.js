// this function generates the HTML for a proposal block,
// which is shown in the logged-in homepage for a "feed"
// of proposals.

// this function is used in the main one for generating the HTML for the voting area
generateProposalBlockVotingAreaHTML = (proposal_id, votes_for, votes_against, current_user_vote) => {
    // calculate percentage of voters that voted for
    const votes_for_percentage = Math.floor((votes_for / (votes_for + votes_against)) * 100);
    
    // return HTML
    return `
    <button class="vote_for_button" onclick="voteForProposal('${proposal_id}');">${getUpArrowSVG()} Vote For</button>
    <div class="voting_progress">
        <div class="votes_for" style="width: ${votes_for_percentage}%">${votes_for} in favor <span class='current_user_vote ${current_user_vote == "for" ? "active" : ""}'>(including you)</span></div>
        <div class="votes_against" style="width: ${100 - votes_for_percentage}%">${votes_against} against <span class='current_user_vote ${current_user_vote == "against" ? "active" : ""}'>(including you)</span></div>
    </div>
    <button class="vote_against_button" onclick="voteAgainstProposal('${proposal_id}');">${getDownArrowSVG()} Vote Against</button>
    `;
};

generateProposalBlockHTML = (proposal_id, title, description, votes_for, votes_against, proposer, ends_in_days, current_user_vote) => {
    // limit description length to 50 words, and add "..." if needed
    let description_limited_length = description;
    if(description_limited_length.split(" ").length > 50){
        description_limited_length = description_limited_length.split(" ").slice(0, 50).join(" ") + "...";
    }

    // get string for vote_ends_in text block
    let vote_ends_in_string;
    if(ends_in_days > 0){
        vote_ends_in_string = `Vote ends <strong>today</strong>`;
    }else if(ends_in_days == 0){
        vote_ends_in_string = `Vote ends in <strong>${ends_in_days} days</strong>`;
    }else{
        vote_ends_in_string = `Vote ended <strong>${ends_in_days * -1} days ago</strong>`;
    }

    // return formatted HTML of proposal block
    return `
    <div class="proposal_block" id="proposalBlock_${proposal_id}">
        <!-- informational area -->
        <div class="row">
            <div class="col">
                <h1 class="title">${title}</h1>
                <p class="description_limited_length">${description_limited_length} ${description_limited_length == description ? "" : "<a class='expand_description'>(more)</a>"}</p>
                <p class="description_full_length">${description}</p>
            </div>
            <div class="col">
                <div class="proposer">
                    <img class="profile_picture" src="${proposer.profile_picture}">
                    <p>${proposer.full_name}</p>
                </div>
                <p class="vote_ends_in">${vote_ends_in_string}</p>
            </div>
        </div>

        <!-- voting area -->
        <div class="row">
            ${generateProposalBlockVotingAreaHTML(proposal_id, votes_for, votes_against, current_user_vote)}
        </div>
    </div>
    `;
};