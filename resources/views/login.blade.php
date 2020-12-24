<!--https://docs.microsoft.com/en-us/azure/active-directory/develop/quickstart-v2-javascript-->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>START TO GROW - Back Office</title>
  <!--  <link rel="SHORTCUT ICON" href="favicon.ico" type="image/x-icon">-->
  <link href="css/login.css?v=1" rel="stylesheet">

  <!-- msal.min.js can be used in the place of msal.js; included msal.js to make debug easy -->
  <script type="text/javascript" src="https://alcdn.msauth.net/lib/1.4.4/js/msal.js" integrity="sha384-fTmwCjhRA6zShZq8Ow5ZkbWwmgp8En46qW6yWpNEkp37MkV50I/V2wjzlEkQ8eWD"
          crossorigin="anonymous"></script>

  <!-- msal.js with a fallback to backup CDN -->
  <script type="text/javascript">
    if (typeof Msal === 'undefined') document.write(unescape("%3Cscript src='https://alcdn.msftauth.net/lib/1.4.4/js/msal.js' type='text/javascript' %3E%3C/script%3E"));
  </script>

  <!-- adding Bootstrap 4 for UI components  -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
        crossorigin="anonymous">
</head>

<body>
<div class="container-fluid">
  <div class="d-flex justify-content-center h-100">
    <img src="/images/logo.svg" style="position: absolute; width: 80px; bottom: 20px; right: 20px">
    <div class="card">
      <div class="card-header">
        <h3>เข้าสู่ระบบ</h3>
        <div class="d-flex justify-content-end social_icon">
          <span><img src="/images/logo_stg.png" style="height: 80px"></span>
        </div>
      </div>
      <div class="card-body d-flex justify-content-center align-items-center">
        <form>
          <input type="button" value="LOGIN" class="btn login_btn" onclick="signIn()">
        </form>
      </div>
      <!--      <div class="card-footer">
              <div class="d-flex justify-content-center links">
                Don't have an account?<a href="#">Sign Up</a>
              </div>
              <div class="d-flex justify-content-center">
                <a href="#">Forgot your password?</a>
              </div>
            </div>-->
    </div>
  </div>
</div>

<!-- importing bootstrap.js and supporting js libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>

<!-- importing app scripts (load order is important) -->
<!--<script type="text/javascript" src="{{ asset('js/azure/authConfig.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/azure/graphConfig.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/azure/ui.js') }}"></script>-->

<!-- replace next line with authRedirect.js if you would like to use the redirect flow -->
<!-- <script type="text/javascript" src="./authRedirect.js"></script>   -->
<!--<script type="text/javascript" src="{{ asset('js/azure/authPopup.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/azure/graph.js') }}"></script>-->

<script>
  // Config object to be passed to Msal on creation.
  // For a full list of msal.js configuration parameters,
  // visit https://azuread.github.io/microsoft-authentication-library-for-js/docs/msal/modules/_authenticationparameters_.html
  const msalConfig = {
    auth: {
      clientId: '2035ec54-9f6b-4228-8ea1-99c4f2201357', //"Enter_the_Application_Id_Here"
      authority: "https://login.microsoftonline.com/0ad5298e-296d-45ab-a446-c0d364c5b18b", //"Enter_the_Cloud_Instance_Id_Here/Enter_the_Tenant_Info_Here"
      redirectUri: "https://ssw003asv801.azurewebsites.net/login", //"Enter_the_Redirect_Uri_Here"
    },
    cache: {
      cacheLocation: "sessionStorage", // This configures where your cache will be stored
      storeAuthStateInCookie: false, // Set this to "true" if you are having issues on IE11 or Edge
    }
  };

  // Add here the scopes to request when obtaining an access token for MS Graph API
  // for more, visit https://github.com/AzureAD/microsoft-authentication-library-for-js/blob/dev/lib/msal-core/docs/scopes.md
  const loginRequest = {
    //scopes: ["openid", "profile", "User.Read"]
    scopes: []
  };

  // Create the main myMSALObj instance
  // configuration parameters are located at authConfig.js
  const myMSALObj = new Msal.UserAgentApplication(msalConfig);

  function signIn() {
    myMSALObj.loginPopup(loginRequest)
      .then(loginResponse => {
        console.log("id_token acquired at: " + new Date().toString());
        console.log(loginResponse);

        const account = myMSALObj.getAccount();
        if (account) {
          localStorage.setItem('azure_account', JSON.stringify(account));
          setTimeout(() => {
            window.location.href = '/admin';
          }, 500);
        }
      }).catch(error => {
      console.log(error);
    });
  }

  function signOut() {
    myMSALObj.logout();
  }

  /*
  Account's Properties
  - accountIdentifier
  - environment
  - homeAccountIdentifier
  - idToken
  - idTokenClaims
  - name
  - sid
  - userName
  */
</script>
</body>
</html>
