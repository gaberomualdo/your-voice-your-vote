// this is the main JavaScript file, which includes global JavaScript functions for every page.

// this useless function (commented out) changes the theme color randomly every second
/*let theme_color = [218, 19, 51];
setInterval(function(){
    theme_color = [Math.floor(Math.random() * 256),Math.floor(Math.random() * 256),Math.floor(Math.random() * 256)];
    let dark_color = [theme_color[0] - 25, theme_color[1] - 25, theme_color[2] - 25];
    dark_color.forEach((item, index) => {
        if(item < 0){
            dark_color[index] = 0
        }
        if(item > 255){
            dark_color[index] = 255
        }
    });

    document.body.setAttribute("style", "--theme-color: rgb(" + theme_color.join(",") + "); --dark-color: rgb(" + dark_color.join(",") + ");");
}, 1000);*/

// configure and initialize firebase
firebase.initializeApp(FIREBASE_CONFIG_OBJ);

// this function will execute after page has loaded and user either is logged in, or logs out
firebase.auth().onAuthStateChanged((user) => {
  if (user) {
    // user is logged in, so redirect to logged-in homepage if not already in it
    if (PAGEFILE == 'index') {
      window.open('home.php', '_self');
    } else {
      // if user logged in and in logged in page, trigger function to set profile picture
      setProfilePictureImageNav();

      // if user logged in and in logged in page, trigger function to set profile box display name
      setProfileBoxName();
    }
  } else {
    // user is not logged in, so redirect to public homepage if not already in it
    if (PAGEFILE != 'index') {
      window.open('index.php', '_self');
    } else {
      // if is currently on index.php, remove loading_auth class from body if present
      document.body.classList.remove('loading_auth');
      if (window.location.href.split('?')[0] != window.location.href) {
        window.history.pushState({}, document.title, window.location.href.split('?')[0]);
      }
    }
  }
});

// SHA
const getSHA256Hash = (text) => {
  const shaObj = new jsSHA('SHA-256', 'TEXT');
  shaObj.update(text);
  return shaObj.getHash('HEX');
};
