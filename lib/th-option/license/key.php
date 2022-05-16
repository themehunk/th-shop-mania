<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
if ( ! function_exists( 'ThemeHunk_VerifyAndSaveLicenseKey' ) ) :
/**
 * That is a sample apllication designed to show how 
 * aMember SoftSale module can be used in real PHP apps
 * to handle license keys, activations and "call-home"
 */
// ini_set('display_errors', true);
// error_reporting(E_ALL);

define('ZITA_SITE_LIBRARY_API_URL', 'https://members.themehunk.com/softsale/api');
//define('DATA_DIR', __DIR__ . '/data');

function ThemeHunk_VerifyAndSaveLicenseKey()
{

    print_r($_POST);
    if (empty($_POST['key']))
    {
        zita_site_library_LicenseForm('Enter License Key To Access Pro Sites'); 
       exit();
    } else {
        $license_key = preg_replace('/[^A-Za-z0-9-_]/', '', trim(sanitize_key($_POST['key']))); 
         $checker = new Zita_Site_Llibrary_Am_LicenseChecker($license_key, ZITA_SITE_LIBRARY_API_URL);
    if (!$checker->checkLicenseKey()) // license key not confirmed by remote server
    {
        zita_site_library_LicenseForm($checker->getMessage());
      exit();
    } else { 
        // license key verified! save it into the file
        update_option( 'zita_license_key', $license_key);
        update_option( 'zita_license', $license_key.'-wpzita');
      //  file_put_contents(DATA_DIR . '/key.txt', $license_key);
        return $license_key;
    }

    }
   }

function zita_site_library_LicenseForm($errorMsg = null)
{
    $url = 'assets/image/wpzita.png';
   echo <<<CUT
    <div class='zita-sites-menu-page-wrapper'>
      <div class='zita-sites-menu-page-wrapper-validation'>
        <div class='zita-key-validation' style='color:#191919f0; font-weight:400;'>$errorMsg</div>
        <form method='post'>
         <a href='https://wpzita.com' target='_blank' rel='noopener'>
              <img width="35" src=$url class='zta-theme-icon' alt='Zita '></a>
            <label> 
            <input type="text" name="key">
            </label>
            <input type="submit" value="Verify">
        </form>
        <div class="user-manual">
            <ul class="manual-title"><li>Not purchased yet? Please check this <a target="_blank" href="https://wpzita.com/pricing/">View</a></li>
        <li>Already purchased? Please go to your members area and copy license key. For more details follow this <a target="_blank" href="https://wpzita.com/docs/how-to-activate-license-in-zita-pro-plugin-zita-site-library/">doc</a></li></ul>
        </div>
      </div>
    </div>
CUT;
}

// if (!is_writeable($fn = DATA_DIR . '/key.txt'))
//     exit("Please chmod file [$fn] to 666");
// if (!is_writeable($fn = DATA_DIR . '/activation-cache.txt'))
//     exit("Please chmod file [$fn] to 666");

// normally you put config reading and bootstraping before license checking
//  --- there should be your application bootstrapping code 
// this example just does not need any bootstrap

// in a real application, the license key and activation cache must be stored into
// a database 
// here we store it into files to keep things clear
require_once __DIR__ . '/LicenseChecker.php';

//$license_key = trim(file_get_contents(DATA_DIR  . '/key.txt'));
$license_key = get_option( 'zita_license_key');

if (!strlen($license_key)) // we have no saved key? so we need to ask it and verify it
{
    $license_key = ThemeHunk_VerifyAndSaveLicenseKey();
}
// now second, optional stage - check activation and binding of application
//$activation_cache = trim(file_get_contents(DATA_DIR . '/activation-cache.txt'));
$activation_cache = trim(get_option( 'zita_activation_cache'));

$prev_activation_cache = $activation_cache; // store previous value to detect change
$checker = new Zita_Site_Llibrary_Am_LicenseChecker($license_key, ZITA_SITE_LIBRARY_API_URL);

$ret = empty($activation_cache) ?
           $checker->activate($activation_cache) : // explictly bind license to new installation
           $checker->checkActivation($activation_cache); // just check activation for subscription expriation, etc.
           
// in any case we need to store results to avoid repeative calls to remote api
if ($prev_activation_cache != $activation_cache)
    update_option('zita_activation_cache', $activation_cache );
  //  file_put_contents(DATA_DIR . '/activation-cache.txt', $activation_cache);

if (!$ret)
    exit("Activation failed: (" . $checker->getCode() . ') ' . $checker->getMessage());

/// now your script may continue and do normal functionality
/// in this case it will be traditional code :)
  $url = ZITA_SITE_LIBRARY_URI.'assets/image/wpzita.png';
  echo "<div class='zita-key-success'><p>License Key Successfully activated.</p>
          <a href='themes.php?page=zita-site-library'><img style='width:24px;' src=$url class='zta-theme-icon' alt='Zita '> Go to Pro Demo</a>
          </br></br></br>
          <div class='user-manual'>
        <ul class='manual-title'><li>Now you can access Zita Pro demo features. Go to the Appearance > Zita Site Library</li>
          <li>To use Zita Pro Demo please check this <a target='_blank' href='https://wpzita.com/docs-cate/zita-site-library/'>doc</a></li></ul>
        </div></div>";
endif;
