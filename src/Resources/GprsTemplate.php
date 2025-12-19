<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class GprsTemplate
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * Get user GPRS templates
     * Retrieves all GPRS templates for the user.
     * 
     * @param array $params Optional parameters
     * @return array List of GPRS templates
     */
    public function getUserGprsTemplates(array $params = [])
    {
        return $this->client->request('GET', 'api/get_user_gprs_templates', ['query' => $params]);
    }

    /**
     * Get data to add GPRS template
     * Retrieves necessary data for creating a GPRS template.
     * 
     * @param array $params Optional parameters
     * @return array GPRS template creation data
     */
    public function addUserGprsTemplateData(array $params = [])
    {
        return $this->client->request('GET', 'api/add_user_gprs_template_data', ['query' => $params]);
    }

    /**
     * Create GPRS template
     * Creates a new GPRS template.
     * 
     * @param array $data Template data
     * @return array Created template response
     */
    public function addUserGprsTemplate(array $data)
    {
        return $this->client->request('POST', 'api/add_user_gprs_template', [
            'multipart' => $this->buildMultipartData($data)
        ]);
    }

    /**
     * Get data to edit GPRS template
     * Retrieves necessary data for editing a GPRS template.
     * 
     * @param int $templateId Template ID
     * @param array $params Optional parameters
     * @return array GPRS template edit data
     */
    public function editUserGprsTemplateData(int $templateId, array $params = [])
    {
        $params['template_id'] = $templateId;
        return $this->client->request('GET', 'api/edit_user_gprs_template_data', ['query' => $params]);
    }

    /**
     * Edit GPRS template
     * Updates an existing GPRS template.
     * 
     * @param int $templateId Template ID
     * @param array $data Template data to update
     * @return array Updated template response
     */
    public function editUserGprsTemplate(int $templateId, array $data)
    {
        $data['template_id'] = $templateId;
        return $this->client->request('POST', 'api/edit_user_gprs_template', [
            'multipart' => $this->buildMultipartData($data)
        ]);
    }

    /**
     * Delete GPRS template
     * Deletes a GPRS template.
     * 
     * @param int $templateId Template ID
     * @return array Deletion response
     */
    public function destroyUserGprsTemplate(int $templateId)
    {
        return $this->client->request('GET', 'api/destroy_user_gprs_template', ['query' => ['template_id' => $templateId]]);
    }

    /**
     * Get user GPRS message
     * Retrieves GPRS message for a template.
     * 
     * @param int $templateId Template ID
     * @param array $params Optional parameters
     * @return array GPRS message
     */
    public function getUserGprsMessage(int $templateId, array $params = [])
    {
        $params['template_id'] = $templateId;
        return $this->client->request('GET', 'api/get_user_gprs_message', ['query' => $params]);
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
