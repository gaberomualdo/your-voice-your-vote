// this function generates the HTML for a proposal block,
// which is shown in the logged-in homepage for a "feed"
// of proposals.

function generateProposalBlock(title, description, votes_for, votes_against, proposer, ends_in_days){
    // limit description length to 50 words, and add "..." if needed
    if(description.split(" ").length > 50){
        description = description.split(" ").slice(0, 50).join(" ") + "...";
    }

    // calculate percentage of voters that voted for
    var votes_for_percentage = Math.floor((votes_for / (votes_for + votes_against)) * 100);

    // return formatted HTML of proposal block
    return `
    <div class="proposal_block">
        <div class="row">
            <h1>${title}</h1>
            <p>${description}</p>
        </div>
        <div class="row">
            <div class="proposer">
                <img class="profile_picture" src="${proposer.profile_picture}">
                <p>${proposer.full_name}</p>
            </div>
            <p class="vote_ends_in">Vote ends in <strong>${ends_in_days} days</strong></p>
            <div class="voting_progress">
                <div class="votes_for" style="width: ${votes_for_percentage}%">${votes_for} in favor</div>
                <div class="votes_against" style="width: ${100 - votes_for_percentage}%">${votes_against} against</div>
            </div>
        </div>
    </div>
    `;
}