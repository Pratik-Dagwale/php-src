--TEST--
GH-23876 (json_decode() invalid UTF-8 flags must be mutually exclusive)
--FILE--
<?php
$json = "\"a\xb0b\"";
var_dump(json_decode($json, flags: JSON_INVALID_UTF8_IGNORE));
var_dump(bin2hex(json_decode($json, flags: JSON_INVALID_UTF8_SUBSTITUTE)));

foreach ([$json, '"valid"', ''] as $input) {
    foreach ([0, JSON_THROW_ON_ERROR, JSON_OBJECT_AS_ARRAY | JSON_BIGINT_AS_STRING] as $flags) {
        try {
            var_dump(json_decode($input, flags: $flags | JSON_INVALID_UTF8_IGNORE | JSON_INVALID_UTF8_SUBSTITUTE));
        } catch (Throwable $e) {
            echo $e::class, ': ', $e->getMessage(), "\n";
        }
    }
}
?>
--EXPECT--
string(2) "ab"
string(10) "61efbfbd62"
ValueError: json_decode(): Argument #4 ($flags) must not include both JSON_INVALID_UTF8_IGNORE and JSON_INVALID_UTF8_SUBSTITUTE
ValueError: json_decode(): Argument #4 ($flags) must not include both JSON_INVALID_UTF8_IGNORE and JSON_INVALID_UTF8_SUBSTITUTE
ValueError: json_decode(): Argument #4 ($flags) must not include both JSON_INVALID_UTF8_IGNORE and JSON_INVALID_UTF8_SUBSTITUTE
ValueError: json_decode(): Argument #4 ($flags) must not include both JSON_INVALID_UTF8_IGNORE and JSON_INVALID_UTF8_SUBSTITUTE
ValueError: json_decode(): Argument #4 ($flags) must not include both JSON_INVALID_UTF8_IGNORE and JSON_INVALID_UTF8_SUBSTITUTE
ValueError: json_decode(): Argument #4 ($flags) must not include both JSON_INVALID_UTF8_IGNORE and JSON_INVALID_UTF8_SUBSTITUTE
ValueError: json_decode(): Argument #4 ($flags) must not include both JSON_INVALID_UTF8_IGNORE and JSON_INVALID_UTF8_SUBSTITUTE
ValueError: json_decode(): Argument #4 ($flags) must not include both JSON_INVALID_UTF8_IGNORE and JSON_INVALID_UTF8_SUBSTITUTE
ValueError: json_decode(): Argument #4 ($flags) must not include both JSON_INVALID_UTF8_IGNORE and JSON_INVALID_UTF8_SUBSTITUTE
