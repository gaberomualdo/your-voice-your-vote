// this is the JavaScript file only used in the submit.php file

// display animations when page is loaded
window.addEventListener('load', () => {
  // header animation
  document
    .querySelector('body > div.container > div.block:first-child > div.row:first-child > h1.header:first-child')
    .classList.add('animation_shown');

  // description and form animation (in) goes after header animation is done (can be checked with last word transition time)
  const headerTransitionTimeMilliseconds =
    parseInt(
      document
        .querySelector(
          'body > div.container > div.block:first-child > div.row:first-child > h1.header:first-child > span.word_container:last-child > span.word_animated'
        )
        .style.transitionDelay.split('s')[0]
    ) + 0.625;

  setTimeout(() => {
    // animate (in) description and form
    document.querySelector('body > div.container > div.block:first-child > div.row:nth-child(2) > div.description').style.opacity = '1';
    document.querySelector('body > div.container > div.block:first-child > div.row:nth-child(2) > div.description').classList.add('fadeIn');

    document.querySelector('body > div.container > div.block:first-child > div.row:nth-child(2) > div.form').style.opacity = '1';
    document.querySelector('body > div.container > div.block:first-child > div.row:nth-child(2) > div.form').classList.add('fadeIn');
  }, headerTransitionTimeMilliseconds * 1000);
});

// variable for firebase realtime database object
const databaseObj = firebase.database();

// variable for firebase authentication object
const authObj = firebase.auth();

// submit button and form functionality
document
  .querySelector('body > div.container > div.block:first-child > div.row:nth-child(2) > div.form > div.button_container > button')
  .addEventListener('click', function () {
    // variables for all inputs
    const titleInputElement = document.querySelector('body > div.container > div.block > div.row:nth-child(2) > div.form > input[type=text]');
    const descriptionInputElement = document.querySelector('body > div.container > div.block > div.row:nth-child(2) > div.form > textarea');
    const submitAnonymouslyInputElement = document.querySelector(
      'body > div.container > div.block > div.row:nth-child(2) > div.form > div.button_container > div.submit_anon_checkbox > input[type=checkbox]'
    );
    const isVoteInputElement = document.querySelector(
      'body > div.container > div.block > div.row:nth-child(2) > div.form > div.button_container > div.post_is_vote > input[type=checkbox]'
    );

    // remove any error classes in all inputs
    titleInputElement.classList.remove('error');
    descriptionInputElement.classList.remove('error');

    // first, check if both inputs have been filled in, and if not, focus those and set error class
    if (titleInputElement.value.length == 0) {
      // focus title input and show error
      titleInputElement.classList.add('error');
      titleInputElement.focus();
    } else if (descriptionInputElement.value.length == 0) {
      // focus description input and show error
      descriptionInputElement.classList.add('error');
      descriptionInputElement.focus();
    } else {
      // no errors, so submit content object to database

      // user credentials to submit object
      let currentUserProposerObj = {
        email: authObj.currentUser.email,
        full_name: authObj.currentUser.displayName,
        profile_picture_url: authObj.currentUser.photoURL,
      };

      // if anonymous is checked, then use anonymized user credentials
      if (submitAnonymouslyInputElement.checked) {
        currentUserProposerObj = {
          email: 'anonymous',
          full_name: 'Anonymous',
          profile_picture_url: getAnonymousUserPNG(),
        };
      }

      // add to database
      databaseObj
        .ref('submission_platform/')
        .push({
          title: titleInputElement.value,
          description: descriptionInputElement.value,
          isVote: isVoteInputElement.checked,
          proposer: currentUserProposerObj,
        })
        .then(() => {
          // after adding to database, show "thanks for submitting!" header

          // don't display second row with description and form
          document.querySelector('body > div.container > div.block:first-child > div.row:nth-child(2)').style.display = 'none';

          // don't display first header
          document.querySelector('body > div.container > div.block:first-child > div.row:first-child > h1.header:first-child').style.display = 'none';

          // display second header
          document.querySelector('body > div.container > div.block:first-child > div.row:first-child > h1.header:nth-child(2)').style.display =
            'block';

          // animate (in) second header and show space for description/extra-text after 0.025 seconds
          setTimeout(() => {
            document
              .querySelector('body > div.container > div.block:first-child > div.row:first-child > h1.header:nth-child(2)')
              .classList.add('animation_shown');
            document.querySelector('body > div.container > div.block:first-child > div.row:nth-child(3)').style.display = 'block';
          }, 25);

          // description/extra-text animation (in) goes after header animation is done (can be checked with last word transition time)
          const headerTransitionTimeMilliseconds =
            parseInt(
              document
                .querySelector(
                  'body > div.container > div.block:first-child > div.row:first-child > h1.header:nth-child(2) > span.word_container:last-child > span.word_animated'
                )
                .style.transitionDelay.split('s')[0]
            ) + 0.65;

          setTimeout(() => {
            // animate (in) description/extra-text
            document.querySelector('body > div.container > div.block:first-child > div.row:nth-child(3)').style.opacity = '1';
            document.querySelector('body > div.container > div.block:first-child > div.row:nth-child(3)').classList.add('fadeIn');
          }, headerTransitionTimeMilliseconds * 1000);
        });
    }
  });
