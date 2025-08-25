<?php

use PHPUnit\Framework\TestCase;
use Gpswox\Wox;
use Gpswox\Resources\Setup;

class SetupTest extends TestCase
{
    private $client;
    private $setup;

    protected function setUp(): void
    {
        /** @var Wox $client */
        $this->client = $this->createMock(Wox::class);
        $this->setup = new Setup($this->client);
    }

    public function testGetEditSetupData()
    {
        $expectedResponse = [
            'item' => [
                'id' => 2,
                'email' => 'test@example.com',
                'lang' => 'en',
                'timezone_id' => '65'
            ],
            'timezones' => [
                ['id' => 1, 'value' => 'UTC -14:00'],
                ['id' => 2, 'value' => 'UTC -13:45']
            ],
            'status' => 1
        ];

        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', 'api/edit_setup_data', ['query' => []])
            ->willReturn($expectedResponse);

        $result = $this->setup->getEditSetupData();

        $this->assertEquals($expectedResponse, $result);
        $this->assertEquals(2, $result['item']['id']);
        $this->assertEquals('test@example.com', $result['item']['email']);
    }

    public function testGetEditSetupDataWithLanguage()
    {
        $expectedResponse = ['status' => 1];

        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', 'api/edit_setup_data', ['query' => ['lang' => 'es']])
            ->willReturn($expectedResponse);

        $result = $this->setup->getEditSetupData('es');

        $this->assertEquals($expectedResponse, $result);
    }

    public function testUpdateSetupData()
    {
        $updateData = [
            'lang' => 'es',
            'unit_of_distance' => 'km',
            'timezone_id' => '65'
        ];

        $expectedResponse = ['status' => 1, 'message' => 'Updated successfully'];

        $this->client->expects($this->once())
            ->method('request')
            ->with('POST', 'api/edit_setup_data', ['json' => $updateData])
            ->willReturn($expectedResponse);

        $result = $this->setup->updateSetupData($updateData);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetTimezones()
    {
        $setupData = [
            'timezones' => [
                ['id' => 1, 'value' => 'UTC -14:00'],
                ['id' => 2, 'value' => 'UTC -13:45']
            ]
        ];

        $this->client->expects($this->once())
            ->method('request')
            ->willReturn($setupData);

        $timezones = $this->setup->getTimezones();

        $this->assertCount(2, $timezones);
        $this->assertEquals('UTC -14:00', $timezones[0]['value']);
    }

    public function testGetDistanceUnits()
    {
        $setupData = [
            'units_of_distance' => [
                ['id' => 'km', 'value' => 'Kilometer'],
                ['id' => 'mi', 'value' => 'Mile']
            ]
        ];

        $this->client->expects($this->once())
            ->method('request')
            ->willReturn($setupData);

        $units = $this->setup->getDistanceUnits();

        $this->assertCount(2, $units);
        $this->assertEquals('km', $units[0]['id']);
        $this->assertEquals('Kilometer', $units[0]['value']);
    }

    public function testGetCapacityUnits()
    {
        $setupData = [
            'units_of_capacity' => [
                ['id' => 'lt', 'value' => 'Liter'],
                ['id' => 'gl', 'value' => 'Gallon']
            ]
        ];

        $this->client->expects($this->once())
            ->method('request')
            ->willReturn($setupData);

        $units = $this->setup->getCapacityUnits();

        $this->assertCount(2, $units);
        $this->assertEquals('lt', $units[0]['id']);
    }

    public function testGetAltitudeUnits()
    {
        $setupData = [
            'units_of_altitude' => [
                ['id' => 'mt', 'value' => 'Meter'],
                ['id' => 'ft', 'value' => 'Feet']
            ]
        ];

        $this->client->expects($this->once())
            ->method('request')
            ->willReturn($setupData);

        $units = $this->setup->getAltitudeUnits();

        $this->assertCount(2, $units);
        $this->assertEquals('mt', $units[0]['id']);
    }

    public function testGetSmsGatewayOptions()
    {
        $setupData = [
            'request_method_select' => [
                ['id' => 'get', 'value' => 'GET'],
                ['id' => 'post', 'value' => 'POST']
            ],
            'encoding_select' => [
                ['id' => 0, 'value' => 'No'],
                ['id' => 'json', 'value' => 'JSON']
            ],
            'authentication_select' => [
                ['id' => 0, 'value' => 'No'],
                ['id' => 1, 'value' => 'Yes']
            ]
        ];

        $this->client->expects($this->once())
            ->method('request')
            ->willReturn($setupData);

        $options = $this->setup->getSmsGatewayOptions();

        $this->assertArrayHasKey('request_methods', $options);
        $this->assertArrayHasKey('encoding_options', $options);
        $this->assertArrayHasKey('authentication_options', $options);
        $this->assertCount(2, $options['request_methods']);
    }

    public function testGetUserInfo()
    {
        $setupData = [
            'item' => [
                'id' => 2,
                'email' => 'test@example.com',
                'active' => 1,
                'lang' => 'en'
            ]
        ];

        $this->client->expects($this->once())
            ->method('request')
            ->willReturn($setupData);

        $userInfo = $this->setup->getUserInfo();

        $this->assertEquals(2, $userInfo['id']);
        $this->assertEquals('test@example.com', $userInfo['email']);
        $this->assertEquals(1, $userInfo['active']);
    }

    public function testGetDstOptions()
    {
        $setupData = [
            'dst_types' => [
                ['id' => 'none', 'value' => 'None'],
                ['id' => 'exact', 'value' => 'Exact date']
            ],
            'months' => [
                ['id' => 'january', 'value' => 'January']
            ],
            'weekdays' => [
                'monday' => 'Monday',
                'tuesday' => 'Tuesday'
            ],
            'week_pos' => [
                'first' => 'First',
                'last' => 'Last'
            ],
            'dst_countries' => [
                ['id' => 1, 'value' => 'Albania']
            ]
        ];

        $this->client->expects($this->once())
            ->method('request')
            ->willReturn($setupData);

        $dstOptions = $this->setup->getDstOptions();

        $this->assertArrayHasKey('dst_types', $dstOptions);
        $this->assertArrayHasKey('months', $dstOptions);
        $this->assertArrayHasKey('weekdays', $dstOptions);
        $this->assertArrayHasKey('week_pos', $dstOptions);
        $this->assertArrayHasKey('dst_countries', $dstOptions);
        $this->assertCount(2, $dstOptions['dst_types']);
    }

    public function testGetCurrentTimezone()
    {
        $setupData = [
            'item' => [
                'timezone_id' => '65'
            ],
            'timezones' => [
                ['id' => 1, 'value' => 'UTC -14:00'],
                ['id' => 65, 'value' => 'UTC +01:00'],
                ['id' => 2, 'value' => 'UTC -13:45']
            ]
        ];

        $this->client->expects($this->once())
            ->method('request')
            ->willReturn($setupData);

        $currentTimezone = $this->setup->getCurrentTimezone();

        $this->assertNotNull($currentTimezone);
        $this->assertEquals(65, $currentTimezone['id']);
        $this->assertEquals('UTC +01:00', $currentTimezone['value']);
    }

    public function testGetCurrentTimezoneNotFound()
    {
        $setupData = [
            'item' => [
                'timezone_id' => '999' // timezone que no existe
            ],
            'timezones' => [
                ['id' => 1, 'value' => 'UTC -14:00'],
                ['id' => 65, 'value' => 'UTC +01:00']
            ]
        ];

        $this->client->expects($this->once())
            ->method('request')
            ->willReturn($setupData);

        $currentTimezone = $this->setup->getCurrentTimezone();

        $this->assertNull($currentTimezone);
    }

    public function testGetCurrentTimezoneNoTimezoneId()
    {
        $setupData = [
            'item' => [
                // No timezone_id definido
            ],
            'timezones' => [
                ['id' => 1, 'value' => 'UTC -14:00']
            ]
        ];

        $this->client->expects($this->once())
            ->method('request')
            ->willReturn($setupData);

        $currentTimezone = $this->setup->getCurrentTimezone();

        $this->assertNull($currentTimezone);
    }
}
