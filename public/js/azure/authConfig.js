
// Config object to be passed to Msal on creation.
// For a full list of msal.js configuration parameters,
// visit https://azuread.github.io/microsoft-authentication-library-for-js/docs/msal/modules/_authenticationparameters_.html
const msalConfig = {
  auth: {
    clientId: '2035ec54-9f6b-4228-8ea1-99c4f2201357', //"Enter_the_Application_Id_Here"
    authority: "https://login.microsoftonline.com/0ad5298e-296d-45ab-a446-c0d364c5b18b", //"Enter_the_Cloud_Instance_Id_Here/Enter_the_Tenant_Info_Here"
    redirectUri: "https://starttogrow.sec.or.th", //"Enter_the_Redirect_Uri_Here"
  },
  cache: {
    cacheLocation: "sessionStorage", // This configures where your cache will be stored
    storeAuthStateInCookie: false, // Set this to "true" if you are having issues on IE11 or Edge
  }
};

// Add here the scopes to request when obtaining an access token for MS Graph API
// for more, visit https://github.com/AzureAD/microsoft-authentication-library-for-js/blob/dev/lib/msal-core/docs/scopes.md
const loginRequest = {
  scopes: ["openid", "profile", "User.Read"]
};

// Add here scopes for access token to be used at MS Graph API endpoints.
const tokenRequest = {
  scopes: ["Mail.Read"]
};
