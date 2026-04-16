<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GeneratePwaIcons extends Command
{
    protected $signature   = 'app:generate-icons';
    protected $description = 'Genera le icone PWA con sfondo verde (normale + admin)';

    public function handle(): void
    {
        $logoPath = public_path('images/logo.png');

        if (! file_exists($logoPath)) {
            $this->error('Logo non trovato: ' . $logoPath);
            return;
        }

        foreach ([192, 512] as $size) {
            $this->generate($logoPath, $size, false);
            $this->generate($logoPath, $size, true);
        }

        $this->info('Icone generate con successo!');
    }

    private function generate(string $logoPath, int $size, bool $admin): void
    {
        $canvas = imagecreatetruecolor($size, $size);

        $green = imagecolorallocate($canvas, 28, 46, 26);
        imagefill($canvas, 0, 0, $green);

        $logo = imagecreatefrompng($logoPath);
        imagealphablending($logo, true);

        // Se admin, lascia spazio in basso per il testo
        $logoSize = $admin ? (int) ($size * 0.50) : (int) ($size * 0.58);
        $offsetX  = (int) (($size - $logoSize) / 2);
        $offsetY  = $admin ? (int) ($size * 0.12) : (int) (($size - $logoSize) / 2);

        imagecopyresampled(
            $canvas, $logo,
            $offsetX, $offsetY,
            0, 0,
            $logoSize, $logoSize,
            imagesx($logo), imagesy($logo)
        );

        if ($admin) {
            $white    = imagecolorallocate($canvas, 168, 212, 171); // verde chiaro
            $fontSize = max(2, (int) ($size / 38));
            $text     = 'ADMIN';
            $textW    = imagefontwidth($fontSize) * strlen($text);
            $textX    = (int) (($size - $textW) / 2);
            $textY    = (int) ($size * 0.78);
            imagestring($canvas, $fontSize, $textX, $textY, $text, $white);
        }

        $suffix = $admin ? '-admin' : '';
        $out    = public_path("images/icon-{$size}{$suffix}.png");
        imagepng($canvas, $out);
        imagedestroy($canvas);
        imagedestroy($logo);

        $this->info("Creato: icon-{$size}{$suffix}.png");
    }
}
