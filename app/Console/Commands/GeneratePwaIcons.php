<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GeneratePwaIcons extends Command
{
    protected $signature   = 'app:generate-icons';
    protected $description = 'Genera le icone PWA con sfondo verde';

    public function handle(): void
    {
        $logoPath = public_path('images/logo.png');

        if (! file_exists($logoPath)) {
            $this->error('Logo non trovato: ' . $logoPath);
            return;
        }

        foreach ([192, 512] as $size) {
            $canvas = imagecreatetruecolor($size, $size);

            // Sfondo verde scuro del sito
            $green = imagecolorallocate($canvas, 28, 46, 26);
            imagefill($canvas, 0, 0, $green);

            // Carica il logo preservando la trasparenza
            $logo = imagecreatefrompng($logoPath);
            imagealphablending($logo, true);

            $logoSize = (int) ($size * 0.58);
            $offset   = (int) (($size - $logoSize) / 2);

            imagecopyresampled(
                $canvas, $logo,
                $offset, $offset,
                0, 0,
                $logoSize, $logoSize,
                imagesx($logo), imagesy($logo)
            );

            $out = public_path("images/icon-{$size}.png");
            imagepng($canvas, $out);
            imagedestroy($canvas);
            imagedestroy($logo);

            $this->info("Creato: icon-{$size}.png");
        }

        $this->info('Icone generate con successo!');
    }
}
