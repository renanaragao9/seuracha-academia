<?php

namespace App\Helpers;

class IaExtractHelper
{
    public static function extractJsonFromContent(string $content): string
    {
        $content = trim($content);

        if (preg_match('/```(?:json)?\s*\n(.*?)\n```/s', $content, $matches)) {
            $content = trim($matches[1]);
        }

        $firstBrace = strpos($content, '{');
        if ($firstBrace !== false && $firstBrace > 0) {
            $content = substr($content, $firstBrace);
        }

        $json = self::extractFirstJsonObject($content);

        return $json !== null ? $json : $content;
    }

    public static function extractFirstJsonObject(string $content): ?string
    {
        $depth = 0;
        $start = strpos($content, '{');

        if ($start === false) {
            return null;
        }

        for ($i = $start; $i < strlen($content); $i++) {
            $char = $content[$i];

            if ($char === '{') {
                $depth++;
            } elseif ($char === '}') {
                $depth--;
                if ($depth === 0) {
                    return substr($content, $start, $i - $start + 1);
                }
            } elseif ($char === '"') {
                $i++;
                while ($i < strlen($content) && $content[$i] !== '"') {
                    if ($content[$i] === '\\') $i++;
                    $i++;
                }
            }
        }

        return null;
    }
}
