<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CompressResponse
{
    /**
     * Handle an incoming request and compress the response using Gzip.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jangan kompresi pada saat test suite (agar assertSee & TestResponse bekerja normal)
        if (app()->environment('testing')) {
            return $next($request);
        }

        $response = $next($request);

        // Jangan kompres jika bukan status 200 OK
        if ($response->getStatusCode() !== 200) {
            return $response;
        }

        // Jangan kompres jika berupa file stream atau sudah terkompres
        if ($response instanceof BinaryFileResponse || $response instanceof StreamedResponse) {
            return $response;
        }

        if ($response->headers->has('Content-Encoding')) {
            return $response;
        }

        $contentType = $response->headers->get('Content-Type', '');

        // Hanya kompres response berbasis teks (HTML, JSON, XML, SVG, JavaScript, CSS)
        $isCompressible = empty($contentType) ||
            str_contains($contentType, 'text/') ||
            str_contains($contentType, 'application/json') ||
            str_contains($contentType, 'application/xml') ||
            str_contains($contentType, 'application/javascript') ||
            str_contains($contentType, 'image/svg+xml');

        if (!$isCompressible) {
            return $response;
        }

        $content = $response->getContent();

        // Lewati response kosong atau terlalu kecil (< 512 byte)
        if (empty($content) || strlen($content) < 512) {
            return $response;
        }

        // Kompresi HTML (Minify: hapus komentar HTML & spasi berlebih antar tag)
        if (str_contains($contentType, 'text/html') || empty($contentType)) {
            $content = $this->minifyHtml($content);
        }

        // Tambahkan header ETag untuk efisiensi HTTP cache pada request GET
        if ($request->isMethod('GET') && $response->getStatusCode() === 200) {
            $etag = '"' . md5($content) . '"';
            $response->headers->set('ETag', $etag);

            $ifNoneMatch = $request->header('If-None-Match');
            if ($ifNoneMatch && trim($ifNoneMatch) === $etag) {
                return response('', 304, [
                    'ETag' => $etag,
                    'Cache-Control' => 'no-cache, private',
                ]);
            }
        }

        $acceptEncoding = (string) $request->header('Accept-Encoding', '');

        // Kompresi Gzip (Level 5: rasio kompresi optimal dengan CPU minimal)
        if (str_contains($acceptEncoding, 'gzip') && function_exists('gzencode')) {
            $compressed = gzencode($content, 5);
            if ($compressed !== false && strlen($compressed) < strlen($content)) {
                $response->setContent($compressed);
                $response->headers->set('Content-Encoding', 'gzip');
                $response->headers->set('Content-Length', (string) strlen($compressed));
                $response->headers->set('Vary', 'Accept-Encoding');
            } else {
                $response->setContent($content);
            }
        } else {
            $response->setContent($content);
        }

        return $response;
    }

    /**
     * Minify HTML content safely without breaking pre/textarea tags.
     */
    protected function minifyHtml(string $html): string
    {
        if (str_contains($html, '<pre') || str_contains($html, '<textarea')) {
            return $html;
        }

        // 1. Hapus komentar HTML biasa (kecuali conditional comments)
        $html = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $html) ?? $html;

        // 2. Rapatkan spasi antar tag HTML (> < menjadi ><)
        $html = preg_replace('/>\s+</', '><', $html) ?? $html;

        // 3. Gabungkan multi-line breaks berlebih
        $html = preg_replace('/(\r?\n){2,}/', "\n", $html) ?? $html;

        return $html;
    }
}
