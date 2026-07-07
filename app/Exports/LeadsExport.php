<?php
// app/Exports/LeadsExport.php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LeadsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    protected $status;
    protected $dateFrom;
    protected $dateTo;

    public function __construct($status = null, $dateFrom = null, $dateTo = null)
    {
        $this->status = $status;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function query()
    {
        return Lead::query()
            ->with('product')
            ->when($this->status, function ($q) {
                $q->where('status', $this->status);
            })
            ->when($this->dateFrom, function ($q) {
                $q->whereDate('created_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($q) {
                $q->whereDate('created_at', '<=', $this->dateTo);
            });
    }

    public function map($lead): array
    {
        return [
            $lead->id,
            $lead->name,
            $lead->phone ?? '',
            $lead->email ?? '',
            $lead->message ?? '',
            $lead->product?->name ?? 'Не указан',
            $lead->estimated_budget ?? '',
            $lead->delivery_city ?? '',
            Lead::getStatuses()[$lead->status] ?? $lead->status,
            $lead->created_at->format('d.m.Y H:i'),
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Имя',
            'Телефон',
            'Email',
            'Сообщение',
            'Товар',
            'Бюджет',
            'Город',
            'Статус',
            'Дата создания'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Получаем последнюю строку с данными
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Применяем стили ко всей таблице
        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ]);

        // Стили для заголовков (жирный, фон, выравнивание)
        $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => '1A1A1A'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E8E8E8'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Выравнивание для всех ячеек
        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Выравнивание для ID и чисел по центру
        $sheet->getStyle("A2:A{$highestRow}")->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Выравнивание для статуса по центру
        $sheet->getStyle("I2:I{$highestRow}")->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Дата по центру
        $sheet->getStyle("J2:J{$highestRow}")->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Текст с переносом для сообщения
        $sheet->getStyle("E2:E{$highestRow}")->applyFromArray([
            'alignment' => [
                'wrapText' => true,
            ],
        ]);

        // Высота строки для заголовка
        $sheet->getRowDimension(1)->setRowHeight(30);

        return [];
    }

    public function columnFormats(): array
    {
        return [
            'J' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}
