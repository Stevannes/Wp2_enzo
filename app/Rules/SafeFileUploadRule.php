<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;
use Illuminate\Translation\PotentiallyTranslatedString;

class SafeFileUploadRule implements ValidationRule
{
    /**
     * Dangerous executable and script file extensions strictly forbidden.
     *
     * @var list<string>
     */
    protected array $blacklistedExtensions = [
        'php', 'phtml', 'php3', 'php4', 'php5', 'php7', 'php8', 'phar', 'phps',
        'exe', 'bat', 'cmd', 'sh', 'bash', 'zsh', 'bin', 'dll', 'so',
        'js', 'jsp', 'asp', 'aspx', 'py', 'pl', 'cgi', 'vbs', 'ps1',
        'svg', 'htm', 'html', 'xhtml', 'shtml', 'htaccess', 'htpasswd',
        'ini', 'env', 'config', 'xml', 'com', 'scr', 'msi',
    ];

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile) {
            return;
        }

        $originalName = $value->getClientOriginalName();

        // 1. Check for null byte injection
        if (str_contains($originalName, "\0") || str_contains($originalName, '%00')) {
            $fail('Nama berkas terdeteksi mengandung karakter terlarang (Null Byte injection).');

            return;
        }

        // 2. Check for path traversal characters in original filename
        if (str_contains($originalName, '..') || str_contains($originalName, '/') || str_contains($originalName, '\\')) {
            $fail('Nama berkas tidak boleh mengandung karakter direktori traversal.');

            return;
        }

        // 3. Check for double extensions (e.g. payload.php.pdf or exploit.phtml.jpg)
        $parts = explode('.', $originalName);
        if (count($parts) > 2) {
            foreach (array_slice($parts, 1, -1) as $middleExtension) {
                $cleanMiddle = strtolower(trim($middleExtension));
                if (in_array($cleanMiddle, $this->blacklistedExtensions, true)) {
                    $fail("Berkas ditolak: Ekstensi ganda berbahaya terdeteksi (.{$cleanMiddle}).");

                    return;
                }
            }
        }

        // 4. Check client extension
        $clientExtension = strtolower($value->getClientOriginalExtension());
        if (in_array($clientExtension, $this->blacklistedExtensions, true)) {
            $fail("Format berkas .{$clientExtension} dilarang demi keamanan sistem (Anti-Executable Protection).");

            return;
        }

        // 5. Inspect file content for PHP opening tags in uploaded documents
        $realPath = $value->getRealPath();
        if ($realPath && file_exists($realPath) && is_readable($realPath)) {
            $handle = @fopen($realPath, 'rb');
            if ($handle) {
                $sample = fread($handle, 4096);
                fclose($handle);

                if (is_string($sample)) {
                    $lowerSample = strtolower($sample);
                    if (str_contains($lowerSample, '<?php') || str_contains($lowerSample, '<?=') || str_contains($lowerSample, '<script')) {
                        $fail('Berkas ditolak: Terdeteksi muatan skrip / payload berbahaya dalam isi berkas.');

                        return;
                    }
                }
            }
        }
    }
}
