<?php

namespace App\Lib\Integrations\EmailServers\SampleEmailServer\Domain;

use App\Lib\Integrations\EmailServers\AbstractEmailServer\Domain\AbstractForwarder;
use App\Lib\Integrations\EmailServers\SampleEmailServer;
use App\Lib\Interfaces\Integrations\EmailServer\Domain\ForwarderInterface;
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
class Forwarder extends AbstractForwarder implements ForwarderInterface
{
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
        SampleEmailServer::sampleAPI()->createForwarder($this->emailDomain->domain, $params);
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
        SampleEmailServer::sampleAPI()->createForwarder($this->emailDomain->domain, $email, $forward_to);
    }
}
