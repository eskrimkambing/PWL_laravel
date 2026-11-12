<?php

namespace App\Support;

use RuntimeException;

/**
 * Pembuat PDF tabel sederhana (tanpa library tambahan).
 *
 * - Ukuran kertas A4 portrait, font Helvetica (bawaan PDF).
 * - Teks dikonversi ke Windows-1252: huruf latin & aksen aman,
 *   emoji / karakter di luar itu tampil sebagai "?".
 * - Tabel otomatis pindah halaman dan header tabel diulang.
 */
class SimplePdf
{
    private const PAGE_W = 595.28;
    private const PAGE_H = 841.89;
    private const MARGIN_X = 40;
    private const MARGIN_TOP = 40;
    private const MARGIN_BOTTOM = 50;

    private const FONT = 9;      // ukuran font isi tabel
    private const LINE = 12;     // tinggi satu baris teks
    private const PAD = 4;       // padding sel

    // Lebar karakter Helvetica (per 1000 unit) untuk kode 32..255
    private const W_REG = [278,278,355,556,556,889,667,191,333,333,389,584,278,333,278,278,556,556,556,556,556,556,556,556,556,556,278,278,584,584,584,556,1015,667,667,722,722,667,611,778,722,278,500,667,556,833,722,778,667,778,722,667,611,722,667,944,667,667,611,278,278,278,469,556,333,556,556,500,556,556,278,556,556,222,222,500,222,833,556,556,556,556,333,500,278,556,500,722,500,500,500,334,260,334,584,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,278,333,556,556,556,556,260,556,333,737,370,556,584,333,737,333,400,584,333,333,333,556,537,278,333,333,365,556,834,834,834,611,667,667,667,667,667,667,1000,722,667,667,667,667,278,278,278,278,722,722,778,778,778,778,778,584,778,722,722,722,722,667,667,611,556,556,556,556,556,556,889,500,556,556,556,556,278,278,278,278,556,556,556,556,556,556,556,584,611,556,556,556,556,500,556,500];
    private const W_BOLD = [278,333,474,556,556,889,722,238,333,333,389,584,278,333,278,278,556,556,556,556,556,556,556,556,556,556,333,333,584,584,584,611,975,722,722,722,722,667,611,778,722,278,556,722,611,833,722,778,667,778,722,667,611,722,667,944,667,667,611,333,278,333,584,556,333,556,611,556,611,556,333,611,611,278,278,556,278,889,611,611,611,611,389,556,333,611,556,778,556,556,500,389,280,389,584,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,556,278,333,556,556,556,556,280,556,333,737,370,556,584,333,737,333,400,584,333,333,333,611,556,278,333,333,365,556,834,834,834,611,722,722,722,722,722,722,1000,722,667,667,667,667,278,278,278,278,722,722,778,778,778,778,778,584,778,722,722,722,722,667,667,611,556,556,556,556,556,556,889,556,556,556,556,556,278,278,278,278,611,611,611,611,611,611,611,584,611,611,611,611,611,556,611,556];

    private array $pages = [];   // isi stream tiap halaman
    private int $cur = -1;       // indeks halaman aktif
    private float $y = 0;        // posisi y (dari atas halaman)
    private array $lebar = [];   // lebar kolom (pt)

    public function __construct(
        private string $judul,
        private array $info,
        private array $kolom,
        private string $footerKiri = ''
    ) {
        $isi = self::PAGE_W - 2 * self::MARGIN_X;
        $total = array_sum(array_column($kolom, 'lebar')) ?: 1;

        foreach ($kolom as $k) {
            $this->lebar[] = $k['lebar'] / $total * $isi;
        }

        $this->halamanBaru(true);
    }

    /**
     * Baris data. Tiap sel berupa string, atau array string
     * (beberapa "blok" yang tingginya disejajarkan antar kolom array).
     */
    public function baris(array $sel): static
    {
        $this->gambarBaris(array_map(fn($s, $i) => [
            'teks' => $s,
            'span' => 1,
            'rata' => $this->kolom[$i]['rata'] ?? 'L',
        ], $sel, array_keys($sel)), false);

        return $this;
    }

    /**
     * Baris total. Tiap item: ['teks' => ..., 'span' => n, 'rata' => 'L|C|R'].
     */
    public function barisTotal(array $sel): static
    {
        $this->gambarBaris($sel, true);

        return $this;
    }

    public function output(): string
    {
        $jumlah = count($this->pages);

        // Footer tiap halaman
        foreach ($this->pages as $i => &$stream) {
            $kanan = 'Halaman ' . ($i + 1) . ' dari ' . $jumlah;
            $stream .= $this->teks(self::MARGIN_X, 28, $this->footerKiri, false, 8, [0.4, 0.4, 0.4]);
            $lebarKanan = $this->lebarTeks($this->enc($kanan), false, 8);
            $stream .= $this->teks(self::PAGE_W - self::MARGIN_X - $lebarKanan, 28, $kanan, false, 8, [0.4, 0.4, 0.4]);
        }
        unset($stream);

        $objek = [];
        $objek[1] = '<< /Type /Catalog /Pages 2 0 R >>';

        $kids = [];
        for ($i = 0; $i < $jumlah; $i++) {
            $kids[] = (5 + $i * 2) . ' 0 R';
        }
        $objek[2] = '<< /Type /Pages /Kids [' . implode(' ', $kids) . '] /Count ' . $jumlah . ' >>';
        $objek[3] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica /Encoding /WinAnsiEncoding >>';
        $objek[4] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold /Encoding /WinAnsiEncoding >>';

        foreach ($this->pages as $i => $stream) {
            $idHal = 5 + $i * 2;
            $idIsi = $idHal + 1;

            $objek[$idHal] = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 ' . self::PAGE_W . ' ' . self::PAGE_H . '] '
                . '/Resources << /Font << /F1 3 0 R /F2 4 0 R >> >> /Contents ' . $idIsi . ' 0 R >>';

            if (function_exists('gzcompress')) {
                $data = gzcompress($stream, 6);
                $objek[$idIsi] = '<< /Length ' . strlen($data) . ' /Filter /FlateDecode >>' . "\nstream\n" . $data . "\nendstream";
            } else {
                $objek[$idIsi] = '<< /Length ' . strlen($stream) . ' >>' . "\nstream\n" . $stream . "\nendstream";
            }
        }

        $pdf = "%PDF-1.4\n%\xE2\xE3\xCF\xD3\n";
        $offset = [];

        ksort($objek);
        foreach ($objek as $no => $isi) {
            $offset[$no] = strlen($pdf);
            $pdf .= $no . " 0 obj\n" . $isi . "\nendobj\n";
        }

        $xref = strlen($pdf);
        $n = count($objek) + 1;
        $pdf .= "xref\n0 " . $n . "\n0000000000 65535 f \n";
        foreach ($offset as $o) {
            $pdf .= sprintf("%010d 00000 n \n", $o);
        }
        $pdf .= "trailer\n<< /Size " . $n . " /Root 1 0 R >>\nstartxref\n" . $xref . "\n%%EOF";

        return $pdf;
    }

    public function unduh(string $namaFile)
    {
        return response($this->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $namaFile . '"',
        ]);
    }

    // ------------------------------------------------------------------
    // Layout
    // ------------------------------------------------------------------

    private function halamanBaru(bool $pertama = false): void
    {
        $this->pages[] = '';
        $this->cur = count($this->pages) - 1;
        $this->y = self::MARGIN_TOP;

        if ($pertama) {
            $this->tulis($this->teks(self::MARGIN_X, self::PAGE_H - $this->y - 15, $this->judul, true, 15));
            $this->y += 24;

            foreach ($this->info as $baris) {
                $this->tulis($this->teks(self::MARGIN_X, self::PAGE_H - $this->y - 10, $baris, false, 10));
                $this->y += 15;
            }

            $this->y += 8;
        }

        $this->gambarHeader();
    }

    private function gambarHeader(): void
    {
        // Hitung tinggi header dari label yang di-wrap
        $baris = [];
        $maks = 1;
        foreach ($this->kolom as $i => $k) {
            $baris[$i] = $this->bungkus($this->enc($k['label']), $this->lebar[$i] - 2 * self::PAD, true);
            $maks = max($maks, count($baris[$i]));
        }
        $tinggi = $maks * self::LINE + 2 * self::PAD + 2;

        $x = self::MARGIN_X;
        foreach ($this->kolom as $i => $k) {
            $w = $this->lebar[$i];

            // latar oranye + garis tepi
            $this->tulis($this->kotak($x, $this->y, $w, $tinggi, [0.871, 0.471, 0.004], true));
            $this->tulis($this->kotak($x, $this->y, $w, $tinggi, [0.73, 0.73, 0.73], false));

            // teks putih, rata tengah
            $offY = ($tinggi - count($baris[$i]) * self::LINE) / 2;
            foreach ($baris[$i] as $j => $ln) {
                $tw = $this->lebarTeks($ln, true, self::FONT);
                $this->tulis($this->teksMentah(
                    $x + ($w - $tw) / 2,
                    self::PAGE_H - ($this->y + $offY + $j * self::LINE + self::FONT + 1),
                    $ln,
                    true,
                    self::FONT,
                    [1, 1, 1]
                ));
            }

            $x += $w;
        }

        $this->y += $tinggi;
    }

    private function gambarBaris(array $sel, bool $total): void
    {
        // Petakan sel -> kolom (mendukung span)
        $peta = [];
        $kol = 0;
        foreach ($sel as $s) {
            $span = $s['span'] ?? 1;
            $w = array_sum(array_slice($this->lebar, $kol, $span));
            $peta[] = ['x' => self::MARGIN_X + array_sum(array_slice($this->lebar, 0, $kol)), 'w' => $w] + $s;
            $kol += $span;
        }

        // Bungkus teks, hitung tinggi
        $tinggiBlok = [];      // tinggi tiap blok untuk kolom multi-blok
        $tinggiTunggal = 0;
        foreach ($peta as &$p) {
            $maxW = $p['w'] - 2 * self::PAD;

            if (is_array($p['teks'])) {
                $blok = $p['teks'] ?: ['-'];
                $p['blok'] = [];
                foreach ($blok as $bi => $b) {
                    $lines = $this->bungkus($this->enc((string) $b), $maxW, $total);
                    $p['blok'][$bi] = $lines;
                    $tinggiBlok[$bi] = max($tinggiBlok[$bi] ?? 0, count($lines) * self::LINE);
                }
            } else {
                $p['lines'] = $this->bungkus($this->enc((string) $p['teks']), $maxW, $total);
                $tinggiTunggal = max($tinggiTunggal, count($p['lines']) * self::LINE);
            }
        }
        unset($p);

        $tinggi = max($tinggiTunggal, array_sum($tinggiBlok), self::LINE) + 2 * self::PAD;

        // Pindah halaman bila tidak muat
        if ($this->y + $tinggi > self::PAGE_H - self::MARGIN_BOTTOM) {
            $this->halamanBaru();
        }

        foreach ($peta as $p) {
            if ($total) {
                $this->tulis($this->kotak($p['x'], $this->y, $p['w'], $tinggi, [0.969, 0.851, 0.569], true));
            }
            $this->tulis($this->kotak($p['x'], $this->y, $p['w'], $tinggi, [0.73, 0.73, 0.73], false));

            if (isset($p['blok'])) {
                $yy = $this->y + self::PAD;
                foreach ($p['blok'] as $bi => $lines) {
                    foreach ($lines as $li => $ln) {
                        $this->tulisBaris($p, $ln, $yy + $li * self::LINE, $total);
                    }
                    $yy += $tinggiBlok[$bi];
                }
            } else {
                foreach ($p['lines'] as $li => $ln) {
                    $this->tulisBaris($p, $ln, $this->y + self::PAD + $li * self::LINE, $total);
                }
            }
        }

        $this->y += $tinggi;
    }

    private function tulisBaris(array $p, string $ln, float $yAtas, bool $tebal): void
    {
        if ($ln === '') {
            return;
        }

        $tw = $this->lebarTeks($ln, $tebal, self::FONT);
        $rata = $p['rata'] ?? 'L';

        $x = match ($rata) {
            'R'     => $p['x'] + $p['w'] - self::PAD - $tw,
            'C'     => $p['x'] + ($p['w'] - $tw) / 2,
            default => $p['x'] + self::PAD,
        };

        $this->tulis($this->teksMentah($x, self::PAGE_H - ($yAtas + self::FONT + 1), $ln, $tebal, self::FONT, [0.1, 0.1, 0.1]));
    }

    // ------------------------------------------------------------------
    // Teks & gambar dasar
    // ------------------------------------------------------------------

    private function tulis(string $op): void
    {
        $this->pages[$this->cur] .= $op;
    }

    /** Teks UTF-8 -> operator PDF (dikonversi dulu). Koordinat y dari BAWAH halaman. */
    private function teks(float $x, float $y, string $teks, bool $tebal, float $ukuran, array $warna = [0, 0, 0]): string
    {
        return $this->teksMentah($x, $y, $this->enc($teks), $tebal, $ukuran, $warna);
    }

    /** Teks yang sudah dalam Windows-1252. Koordinat y dari BAWAH halaman. */
    private function teksMentah(float $x, float $y, string $enc, bool $tebal, float $ukuran, array $warna = [0, 0, 0]): string
    {
        $esc = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $enc);

        return sprintf(
            "BT /%s %.2f Tf %.3f %.3f %.3f rg %.2f %.2f Td (%s) Tj ET\n",
            $tebal ? 'F2' : 'F1',
            $ukuran,
            $warna[0],
            $warna[1],
            $warna[2],
            $x,
            $y,
            $esc
        );
    }

    private function kotak(float $x, float $yAtas, float $w, float $h, array $warna, bool $isi): string
    {
        $yPdf = self::PAGE_H - $yAtas - $h;

        if ($isi) {
            return sprintf("%.3f %.3f %.3f rg %.2f %.2f %.2f %.2f re f\n", $warna[0], $warna[1], $warna[2], $x, $yPdf, $w, $h);
        }

        return sprintf("%.3f %.3f %.3f RG 0.5 w %.2f %.2f %.2f %.2f re S\n", $warna[0], $warna[1], $warna[2], $x, $yPdf, $w, $h);
    }

    private function enc(string $s): string
    {
        $s = preg_replace('/\s+/u', ' ', $s) ?? $s;
        $s = trim($s);

        if (function_exists('mb_convert_encoding')) {
            return mb_convert_encoding($s, 'Windows-1252', 'UTF-8');
        }

        if (function_exists('iconv')) {
            return (string) @iconv('UTF-8', 'Windows-1252//TRANSLIT//IGNORE', $s);
        }

        throw new RuntimeException('Ekstensi PHP "mbstring" atau "iconv" dibutuhkan untuk membuat PDF.');
    }

    private function lebarTeks(string $enc, bool $tebal, float $ukuran): float
    {
        $tabel = $tebal ? self::W_BOLD : self::W_REG;
        $jumlah = 0;

        for ($i = 0, $n = strlen($enc); $i < $n; $i++) {
            $kode = ord($enc[$i]);
            $jumlah += $kode >= 32 ? ($tabel[$kode - 32] ?? 556) : 0;
        }

        return $jumlah * $ukuran / 1000;
    }

    /** Potong teks menjadi beberapa baris sesuai lebar maksimum. */
    private function bungkus(string $enc, float $maxW, bool $tebal): array
    {
        if ($enc === '') {
            return [''];
        }

        $baris = [];
        $sekarang = '';

        foreach (explode(' ', $enc) as $kata) {
            $coba = $sekarang === '' ? $kata : $sekarang . ' ' . $kata;

            if ($this->lebarTeks($coba, $tebal, self::FONT) <= $maxW) {
                $sekarang = $coba;
                continue;
            }

            if ($sekarang !== '') {
                $baris[] = $sekarang;
                $sekarang = '';
            }

            // Kata yang lebih panjang dari kolom dipotong per karakter
            while ($this->lebarTeks($kata, $tebal, self::FONT) > $maxW && strlen($kata) > 1) {
                $potong = '';
                foreach (str_split($kata) as $ch) {
                    if ($this->lebarTeks($potong . $ch, $tebal, self::FONT) > $maxW) {
                        break;
                    }
                    $potong .= $ch;
                }
                if ($potong === '') {
                    $potong = $kata[0];
                }
                $baris[] = $potong;
                $kata = substr($kata, strlen($potong));
            }

            $sekarang = $kata;
        }

        if ($sekarang !== '' || !$baris) {
            $baris[] = $sekarang;
        }

        return $baris;
    }
}