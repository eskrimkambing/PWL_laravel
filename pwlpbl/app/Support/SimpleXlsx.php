<?php

namespace App\Support;

use RuntimeException;
use ZipArchive;

/**
 * Pembuat file .xlsx sederhana (tanpa library tambahan).
 * Hanya membutuhkan ekstensi PHP "zip" (ZipArchive).
 */
class SimpleXlsx
{
    // Indeks style di styles.xml
    public const S_NORMAL = 0;
    public const S_HEADER = 1;
    public const S_ANGKA  = 2;  // #,##0
    public const S_JUDUL  = 3;
    public const S_WRAP   = 4;  // teks multi-baris
    public const S_TOTAL  = 5;  // tebal
    public const S_TOTAL_ANGKA = 6;
    public const S_CATATAN = 7; // teks biasa tanpa border

    private array $rows = [];
    private array $lebarKolom = [];
    private int $barisKe = 0;

    public function __construct(private string $namaSheet = 'Sheet1')
    {
    }

    public function lebarKolom(array $lebar): static
    {
        $this->lebarKolom = $lebar;

        return $this;
    }

    public function judul(string $teks): static
    {
        $this->barisKe++;
        $this->rows[$this->barisKe] = [['v' => $teks, 's' => self::S_JUDUL]];

        return $this;
    }

    public function catatan(string $teks): static
    {
        $this->barisKe++;
        $this->rows[$this->barisKe] = [['v' => $teks, 's' => self::S_CATATAN]];

        return $this;
    }

    public function kosong(): static
    {
        $this->barisKe++;

        return $this;
    }

    /**
     * @param array       $nilai   isi sel
     * @param string|null $gaya    'header' | 'total' | null
     * @param array       $kolom   gaya per kolom: [indeksKolom => 'angka'|'wrap']
     */
    public function baris(array $nilai, ?string $gaya = null, array $kolom = []): static
    {
        $this->barisKe++;
        $sel = [];

        foreach (array_values($nilai) as $i => $v) {
            $s = self::S_NORMAL;

            if ($gaya === 'header') {
                $s = self::S_HEADER;
            } elseif ($gaya === 'total') {
                $s = is_numeric($v) && !is_string($v) ? self::S_TOTAL_ANGKA : self::S_TOTAL;
            } elseif (($kolom[$i] ?? null) === 'angka') {
                $s = self::S_ANGKA;
            } elseif (($kolom[$i] ?? null) === 'wrap') {
                $s = self::S_WRAP;
            }

            $sel[] = ['v' => $v, 's' => $s];
        }

        $this->rows[$this->barisKe] = $sel;

        return $this;
    }

    public function unduh(string $namaFile)
    {
        $path = $this->simpan();

        return response()->download(
            $path,
            $namaFile,
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        )->deleteFileAfterSend(true);
    }

    public function simpan(?string $path = null): string
    {
        if (!class_exists(ZipArchive::class)) {
            throw new RuntimeException('Ekstensi PHP "zip" belum aktif. Aktifkan extension=zip di php.ini.');
        }

        $path ??= tempnam(sys_get_temp_dir(), 'xlsx');

        $zip = new ZipArchive();

        if ($zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new RuntimeException('Gagal membuat file Excel.');
        }

        $zip->addFromString('[Content_Types].xml', $this->contentTypes());
        $zip->addFromString('_rels/.rels', $this->rootRels());
        $zip->addFromString('xl/workbook.xml', $this->workbook());
        $zip->addFromString('xl/_rels/workbook.xml.rels', $this->workbookRels());
        $zip->addFromString('xl/styles.xml', $this->styles());
        $zip->addFromString('xl/worksheets/sheet1.xml', $this->sheet());
        $zip->close();

        return $path;
    }

    // ------------------------------------------------------------------

    private function esc(string $s): string
    {
        // Buang karakter kontrol yang tidak valid di XML, pertahankan \n dan \t
        $s = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/u', '', $s) ?? '';

        return htmlspecialchars($s, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }

    private function namaKolom(int $i): string
    {
        $n = '';
        for ($i++; $i > 0; $i = intdiv($i - 1, 26)) {
            $n = chr(65 + (($i - 1) % 26)) . $n;
        }

        return $n;
    }

    private function sheet(): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">';

        if ($this->lebarKolom) {
            $xml .= '<cols>';
            foreach (array_values($this->lebarKolom) as $i => $w) {
                $n = $i + 1;
                $xml .= '<col min="' . $n . '" max="' . $n . '" width="' . $w . '" customWidth="1"/>';
            }
            $xml .= '</cols>';
        }

        $xml .= '<sheetData>';

        foreach ($this->rows as $r => $sel) {
            $xml .= '<row r="' . $r . '">';

            foreach ($sel as $c => $cell) {
                $ref = $this->namaKolom($c) . $r;
                $v = $cell['v'];
                $s = $cell['s'];

                if (is_int($v) || is_float($v)) {
                    $xml .= '<c r="' . $ref . '" s="' . $s . '"><v>' . $v . '</v></c>';
                } elseif ($v === null || $v === '') {
                    $xml .= '<c r="' . $ref . '" s="' . $s . '"/>';
                } else {
                    $xml .= '<c r="' . $ref . '" s="' . $s . '" t="inlineStr"><is><t xml:space="preserve">'
                        . $this->esc((string) $v) . '</t></is></c>';
                }
            }

            $xml .= '</row>';
        }

        return $xml . '</sheetData></worksheet>';
    }

    private function styles(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<numFmts count="1"><numFmt numFmtId="164" formatCode="#,##0"/></numFmts>'
            . '<fonts count="4">'
            . '<font><sz val="11"/><name val="Calibri"/></font>'
            . '<font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font>'
            . '<font><b/><sz val="14"/><name val="Calibri"/></font>'
            . '<font><b/><sz val="11"/><name val="Calibri"/></font>'
            . '</fonts>'
            . '<fills count="3">'
            . '<fill><patternFill patternType="none"/></fill>'
            . '<fill><patternFill patternType="gray125"/></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFDE7801"/><bgColor indexed="64"/></patternFill></fill>'
            . '</fills>'
            . '<borders count="2">'
            . '<border><left/><right/><top/><bottom/><diagonal/></border>'
            . '<border><left style="thin"><color rgb="FFBBBBBB"/></left><right style="thin"><color rgb="FFBBBBBB"/></right>'
            . '<top style="thin"><color rgb="FFBBBBBB"/></top><bottom style="thin"><color rgb="FFBBBBBB"/></bottom><diagonal/></border>'
            . '</borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="8">'
            // 0 normal
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1"><alignment vertical="top"/></xf>'
            // 1 header
            . '<xf numFmtId="0" fontId="1" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>'
            // 2 angka
            . '<xf numFmtId="164" fontId="0" fillId="0" borderId="1" xfId="0" applyNumberFormat="1" applyBorder="1" applyAlignment="1"><alignment vertical="top"/></xf>'
            // 3 judul
            . '<xf numFmtId="0" fontId="2" fillId="0" borderId="0" xfId="0" applyFont="1"/>'
            // 4 wrap
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1" applyAlignment="1"><alignment vertical="top" wrapText="1"/></xf>'
            // 5 total (teks)
            . '<xf numFmtId="0" fontId="3" fillId="0" borderId="1" xfId="0" applyFont="1" applyBorder="1"/>'
            // 6 total (angka)
            . '<xf numFmtId="164" fontId="3" fillId="0" borderId="1" xfId="0" applyNumberFormat="1" applyFont="1" applyBorder="1"/>'
            // 7 catatan (tanpa border)
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'
            . '</cellXfs>'
            . '<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'
            . '</styleSheet>';
    }

    private function contentTypes(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            . '</Types>';
    }

    private function rootRels(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '</Relationships>';
    }

    private function workbook(): string
    {
        // Nama sheet maksimal 31 karakter dan tidak boleh berisi : \ / ? * [ ]
        $nama = mb_substr(preg_replace('/[:\\\\\/\?\*\[\]]/', '', $this->namaSheet) ?: 'Sheet1', 0, 31);

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" '
            . 'xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets><sheet name="' . $this->esc($nama) . '" sheetId="1" r:id="rId1"/></sheets>'
            . '</workbook>';
    }

    private function workbookRels(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            . '</Relationships>';
    }
}