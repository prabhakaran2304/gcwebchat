<!doctype html>
<html lang="en">
<style>
  button {
    background-color: #04AA6D;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 5%;
  }

  body {
    font-family: Arial, Helvetica, sans-serif;
  }

  .container {
    padding: 25px;
    background-color: lightblue;
  }
</style>

<script src="https://global.oktacdn.com/okta-auth-js/5.2.2/okta-auth-js.min.js" type="text/javascript"></script>


<body>
  <center>
    <h1> Authenticated Web Messaging</h1>
  </center>
  <div class="container">
    <?php
    session_start();
    //Change below details according to identity setup {client_id,client_secret,redirect_uri,metadata_url}
    $client_id = '0oa8idus1xsmBHY0S5d7';
    $client_secret = 'mbJrIOwxV2mFl9a2qFYHK7vnkw19wK2HyxDdPBKf';
    $redirect_uri = 'http://localhost:81/AuthMessenger/OKTAWebMessaging.php';
    $metadata_url = 'https://dev-53034387.okta.com/oauth2/default/.well-known/openid-configuration';
    // Fetch the authorization server metadata which contains a few URLs
    
    if (isset($_GET['logout'])) {
      unset($_SESSION['Code']);
      //Change below details according to folder location {Location}
      header('Location: /AuthMessenger/OKTAWebMessaging.php');
      die();
    }

    if (isset($_GET['code'])) {
      echo '<p>Success Logged In</p>';
      $_SESSION['Code'] = $_GET['code'];
      echo '<p>Code : ' . $_SESSION['Code'] . '</p>';
      $code = $_SESSION['Code'];
      //Change below details according to folder location {Location}
      echo ("<button onclick=\"location.href='/AuthMessenger/OKTAWebMessaging.php?logout=logout'\">Logout</button>");

      ?>
      <script>
        var code = '<?php echo $_SESSION['Code']; ?>';
        (function (g, e, n, es, ys) {
          g['_genesysJs'] = e;
          g[e] = g[e] || function () {
            (g[e].q = g[e].q || []).push(arguments)
          };
          g[e].t = 1 * new Date();
          g[e].c = es;
          ys = document.createElement('script'); ys.async = 1; ys.src = n; ys.charset = 'utf-8'; document.head.appendChild(ys);
        })(window, 'Genesys', 'https://apps.mypurecloud.com.au/genesys-bootstrap/genesys.min.js', {
          //Change below details according to messenger details  {environment, deploymentId}
          environment: 'apse2',
          deploymentId: 'f35e5906-2855-4307-ae2d-cae29cb81ac1',
          debug: false,
        });
        Genesys('registerPlugin', 'AuthProvider', (AuthProvider) => {

          // COMMAND
          // *********
          // getAuthCode
          AuthProvider.registerCommand('getAuthCode', (e) => {

            //Messenger calls this command to get the the tokens.

            e.resolve({
              authCode: code,			// Pass your authCode here
              //Change below details according to folder location {redirectUri}
              redirectUri: 'http://localhost:81/AuthMessenger/OKTAWebMessaging.php',	   // Pass the redirection URI configured in your authentication provider here
            });
          });
          AuthProvider.registerCommand('reAuthenticate', (e) => {
            e.resolve();
          });
          // Tell Messenger that your plugin is ready (mandatory)
          AuthProvider.ready();
        });
      </script>
      <?php
      die();
    }
    $metadata = http($metadata_url);

    if (!isset($_GET['code'])) {

      $authorize_url = $metadata->authorization_endpoint . '?' . http_build_query([
        'client_id' => $client_id,
        'redirect_uri' => $redirect_uri,
        'response_type' => 'code',
        //cant be reuse to get token or other else will code will be invalid
        'state' => $_SESSION['state'] = bin2hex(random_bytes(15)),
        'scope' => 'openid email profile offline_access',
      ]);
      echo "Request :" . urldecode($authorize_url);

      echo '<p><h3>Not logged in</h3></p>';
      echo ("<button onclick=\"location.href='" . $authorize_url . "'\">Login</button> &nbsp");
      //Change below details according to folder location {location}
      echo ("<button onclick=\"location.href='/AuthMessenger/AuthWebMessaging.php'\">Back</button>");


    } else {

      if ($_SESSION['state'] != $_GET['state']) {
        die('Authorization server returned an invalid state parameter');
      }

      if (isset($_GET['error'])) {
        die('Authorization server returned an error: ' . htmlspecialchars($_GET['error']));
      }
    }
    function base64_urlencode($string)
    {
      return rtrim(strtr(base64_encode($string), '+/', '-_'), '=');
    }
    function http($url, $params = false)
    {
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      if ($params)
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
      return json_decode(curl_exec($ch));
    }

    ?>
  </div>
</body>

</html>