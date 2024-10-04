<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use Illuminate\Support\Facades\DB;

class GoogleSheetsService
{
    protected $client;
    protected $service;
    protected $documentId;
    protected $range;

    public function __construct()
    {
        $this->client = $this->getClient();
        $this->service = new Sheets($this->client);
        $this->documentId = "1FTyv9JVb0NgkATr1YKTpRTUiarmGOeamJ5p3TeTlhLY";
        $this->range = "A:Z";
    }


    public function getClient()
    {
        $client = new Client();
        $client->setApplicationName("employees");
        $client->setRedirectUri("http://localhost:8000/api/employee/googlesheet");
        $client->setScopes(Sheets::SPREADSHEETS);
        $client->setAuthConfig(storage_path('app/' . env('GOOGLE_SERVICE_ACCOUNT_CREDENTIALS')));
        $client->setAccessType("offline");
        return $client;
    }

    public function uploadData($data)
    {
        $header = ['Name', "Email",  "Employe title", "Salary", "Date started", "Birthday"];

        $values = array_map(function ($row) {
            return array_values((array) $row);
        }, $data);

        array_unshift($values, $header);
        array_push($values, ["Last update:", date("Y-m-d h:i:sa")]);
        $body = new ValueRange([
            'values' => $values,
        ]);

        $params = ['valueInputOption' => 'RAW'];
        $this->service->spreadsheets_values->update($this->documentId, $this->range, $body, $params);
        return $this->documentId;
    }

    public function readData()
    {
        $document = $this->service->spreadsheets_values->get($this->documentId, $this->range);
        return $document;
    }
}
