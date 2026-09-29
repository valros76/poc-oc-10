<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Utils\Validator;

class ValidatorTest extends TestCase {

    public function testSanitizeStringRemovesTagsAndTrims(): void {
        $raw = "  <script>alert('xss')</script> Mon Gîte  ";
        $clean = Validator::sanitizeString($raw);
        $this->assertEquals("alert(&#039;xss&#039;) Mon Gîte", $clean);
    }

    public function testSanitizeStringHandlesNull(): void {
        $this->assertEquals("", Validator::sanitizeString(null));
    }

    public function testSanitizeEmailValid(): void {
        $email = "  contact@mon-gite.fr  ";
        $this->assertEquals("contact@mon-gite.fr", Validator::sanitizeEmail($email));
    }

    public function testSanitizeEmailInvalid(): void {
        $this->assertFalse(Validator::sanitizeEmail("invalid-email"));
        $this->assertFalse(Validator::sanitizeEmail(null));
    }

    public function testSanitizeUrlValid(): void {
        $url = "https://mon-gite.fr";
        $this->assertEquals("https://mon-gite.fr", Validator::sanitizeUrl($url));
    }

    public function testSanitizeUrlInvalid(): void {
        $this->assertNull(Validator::sanitizeUrl("not-a-url"));
        $this->assertNull(Validator::sanitizeUrl(null));
    }
}