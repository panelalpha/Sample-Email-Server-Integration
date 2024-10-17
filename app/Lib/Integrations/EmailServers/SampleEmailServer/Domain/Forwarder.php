<?php

namespace App\Lib\Integrations\EmailServers\SampleEmailServer\Domain;

use App\Lib\Integrations\EmailServers\SampleEmailServer;
use App\Lib\Interfaces\Integrations\EmailServer\Domain\ForwarderInterface;
use App\Models\EmailDomain;
use Exception;

/**
 * Class Forwarder
 *
 * This class handles the creation and deletion of email forwarders associated with
 * a domain on an email server.
 *
 * Server configuration array can be accessed by using
 * `$this->emailServer->model->connection_config` from within this class
 * 
 */
class Forwarder implements ForwarderInterface
{
    /**
     * Constructor for the Forwarder class.
     *
     * The EmailDomain model includes the following attributes:
     * - id (int)               : Unique identifier of the model
     * - user_id (int)          : ID of the associated user
     * - service_id (int)       : ID of the associated service
     * - server_account_id (int): ID of the associated server account
     * - domain (string)        : Domain name
     * - details (array)        : Additional details about the domain
     *
     * @param SampleEmailServer $emailServer Instance of the email server being used
     * @param EmailDomain $emailDomain Instance of the EmailDomain model
     */
    public function __construct(private SampleEmailServer $emailServer, private EmailDomain $emailDomain)
    {
        
    }

    /**
     * Creates a new email forwarder for the given domain.
     *
     * Parameters:
     * - email (string)      : The email address from which the emails are forwarded
     * - domain (string)     : The domain of the email address
     * - destination (string): The destination email address to which emails are forwarded
     *
     * @param array $params An array containing 'email', 'domain', and 'destination'
     * @return void
     * @throws Exception If the forwarder creation fails
     */
    public function create(array $params): void
    {
        // Example API call to create a new forwarder
        $this->emailServer->apiCall('POST', '/email/domain/' . $this->emailDomain->domain . '/forwarders', $params);
    }

    /**
     * Deletes an existing email forwarder for the given domain.
     *
     * Parameters:
     * - email (string)      : The email address from which the emails are forwarded
     * - forward_to (string) : The destination email address to which emails are forwarded
     *
     * @param string $email The email address that is being forwarded
     * @param string $forward_to The destination email address for the forwarder
     * @return void
     * @throws Exception If the forwarder deletion fails
     */
    public function delete(string $email, string $forward_to): void
    {
        // Example API call to delete an existing forwarder
        $this->emailServer->apiCall('DELETE', '/email/domain/' . $this->emailDomain->domain . '/forwarders', [
            'email' => $email,
            'forward_to' => $forward_to,
        ]);
    }
}