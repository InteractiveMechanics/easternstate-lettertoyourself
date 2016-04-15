<!DOCTYPE HTML>
<html>
<head>
    <title>Constant Contact API v2 Add/Update Contact Example</title>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>

<!--
README: Add or update contact example
This example flow illustrates how a Constant Contact account owner can add or update a contact in their account. In order for this example to function 
properly, you must have a valid Constant Contact API Key as well as an access token. Both of these can be obtained from 
http://constantcontact.mashery.com.
-->

<?php
	
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 'On');  //On or Off
// require the autoloaders
require_once '../src/Ctct/autoload.php';
require_once '../vendor/autoload.php';

use Ctct\Components\Contacts\Contact;
use Ctct\ConstantContact;
use Ctct\Exceptions\CtctException;

// Enter your Constant Contact APIKEY and ACCESS_TOKEN
define("APIKEY", "aupyn2983w3agxsxc92qgdaz");
define("ACCESS_TOKEN", "0c71d402-0d33-45ef-b0c1-9b3ad1983b69");

$cc = new ConstantContact(APIKEY);

// attempt to fetch lists in the account, catching any exceptions and printing the errors to screen
try {
    $lists = $cc->listService->getLists(ACCESS_TOKEN);
} catch (CtctException $ex) {
    foreach ($ex->getErrors() as $error) {
        print_r($error);
    }
    if (!isset($lists)) {
        $lists = null;
    }
}

// check if the form was submitted
if (isset($_POST['email']) && strlen($_POST['email']) > 1) {
    $action = "Getting Contact By Email Address";
    try {
        // check to see if a contact with the email address already exists in the account
        $response = $cc->contactService->getContacts(ACCESS_TOKEN, array("email" => $_POST['email']));

        // create a new contact if one does not exist
        if (empty($response->results)) {
            $action = "Creating Contact";

            $contact = new Contact();
            $contact->addEmail($_POST['email']);
            $contact->addList("2");
            $contact->first_name = $_POST['first_name'];
            $contact->last_name = '';

            /*
             * The third parameter of addContact defaults to false, but if this were set to true it would tell Constant
             * Contact that this action is being performed by the contact themselves, and gives the ability to
             * opt contacts back in and trigger Welcome/Change-of-interest emails.
             *
             * See: http://developer.constantcontact.com/docs/contacts-api/contacts-index.html#opt_in
             */
            $returnContact = $cc->contactService->addContact(ACCESS_TOKEN, $contact, true);

            // update the existing contact if address already existed
        } else {
            $action = "Updating Contact";

            $contact = $response->results[0];
            if ($contact instanceof Contact) {
                $contact->addList($_POST['list']);
                $contact->first_name = $_POST['first_name'];
                $contact->last_name = '';

                /*
                 * The third parameter of updateContact defaults to false, but if this were set to true it would tell
                 * Constant Contact that this action is being performed by the contact themselves, and gives the ability to
                 * opt contacts back in and trigger Welcome/Change-of-interest emails.
                 *
                 * See: http://developer.constantcontact.com/docs/contacts-api/contacts-index.html#opt_in
                 */
                $returnContact = $cc->contactService->updateContact(ACCESS_TOKEN, $contact, true);
            } else {
                $e = new CtctException();
                $e->setErrors(array("type", "Contact type not returned"));
                throw $e;
            }
        }

        // catch any exceptions thrown during the process and print the errors to screen
    } catch (CtctException $ex) {
        echo '<span class="label label-important">Error ' . $action . '</span>';
        echo '<div class="container alert-error"><pre class="failure-pre">';
        print_r($ex->getErrors());
        echo '</pre></div>';
        die();
    }
}
?>

<body>

<!-- Success Message -->
<?php if (isset($returnContact)) {
    print "1";
} ?>

</body>
</html>
