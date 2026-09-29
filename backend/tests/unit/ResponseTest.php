<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Utils\Response;

class ResponseTest extends TestCase {

    public function testJsonOutputsCorrectPayloadAndHttpCode(): void {
        $payload = ['success' => true, 'data' => 'test'];

        ob_start();
        Response::json($payload, 201);
        $output = ob_get_clean();

        $this->assertJsonStringEqualsJsonString(
            json_encode($payload),
            $output
        );
        $this->assertEquals(201, http_response_code());
    }
}