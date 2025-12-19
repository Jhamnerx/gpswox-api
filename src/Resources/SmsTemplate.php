<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class SmsTemplate
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * Get user SMS templates
     * Retrieves all SMS templates for the user.
     * 
     * @param array $params Optional parameters
     * @return array List of SMS templates
     */
    public function getUserSmsTemplates(array $params = [])
    {
        return $this->client->request('GET', 'api/get_user_sms_templates', ['query' => $params]);
    }

    /**
     * Get data to add SMS template
     * Retrieves necessary data for creating an SMS template.
     * 
     * @param array $params Optional parameters
     * @return array SMS template creation data
     */
    public function addUserSmsTemplateData(array $params = [])
    {
        return $this->client->request('GET', 'api/add_user_sms_template_data', ['query' => $params]);
    }

    /**
     * Create SMS template
     * Creates a new SMS template.
     * 
     * @param array $data Template data
     * @return array Created template response
     */
    public function addUserSmsTemplate(array $data)
    {
        return $this->client->request('POST', 'api/add_user_sms_template', [
            'multipart' => $this->buildMultipartData($data)
        ]);
    }

    /**
     * Get data to edit SMS template
     * Retrieves necessary data for editing an SMS template.
     * 
     * @param int $templateId Template ID
     * @param array $params Optional parameters
     * @return array SMS template edit data
     */
    public function editUserSmsTemplateData(int $templateId, array $params = [])
    {
        $params['template_id'] = $templateId;
        return $this->client->request('GET', 'api/edit_user_sms_template_data', ['query' => $params]);
    }

    /**
     * Edit SMS template
     * Updates an existing SMS template.
     * 
     * @param int $templateId Template ID
     * @param array $data Template data to update
     * @return array Updated template response
     */
    public function editUserSmsTemplate(int $templateId, array $data)
    {
        $data['template_id'] = $templateId;
        return $this->client->request('POST', 'api/edit_user_sms_template', [
            'multipart' => $this->buildMultipartData($data)
        ]);
    }

    /**
     * Delete SMS template
     * Deletes an SMS template.
     * 
     * @param int $templateId Template ID
     * @return array Deletion response
     */
    public function destroyUserSmsTemplate(int $templateId)
    {
        return $this->client->request('GET', 'api/destroy_user_sms_template', ['query' => ['template_id' => $templateId]]);
    }

    /**
     * Get user SMS message
     * Retrieves SMS message for a template.
     * 
     * @param int $templateId Template ID
     * @param array $params Optional parameters
     * @return array SMS message
     */
    public function getUserSmsMessage(int $templateId, array $params = [])
    {
        $params['template_id'] = $templateId;
        return $this->client->request('GET', 'api/get_user_sms_message', ['query' => $params]);
    }

    /**
     * Build multipart form data
     * Converts array data to multipart format.
     * 
     * @param array $data Data to convert
     * @return array Multipart data
     */
    protected function buildMultipartData(array $data)
    {
        $multipart = [];
        foreach ($data as $key => $value) {
            $multipart[] = [
                'name' => $key,
                'contents' => is_array($value) ? json_encode($value) : $value
            ];
        }
        return $multipart;
    }
}
