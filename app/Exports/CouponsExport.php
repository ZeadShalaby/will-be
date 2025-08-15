<?php
namespace App\Exports;

use App\Models\Coupon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CouponsExport implements FromCollection, WithHeadings
{
    protected $start;
    protected $end;
    protected $createdAt;

    protected $companyId;


    public function __construct($start, $end, $createdAt = null, $companyId)
    {
        $this->start = $start;
        $this->end = $end;
        $this->createdAt = $createdAt;
        $this->companyId = $companyId;
    }

    public function collection()
    {

        $query = Coupon::with('company')
            ->whereRaw('DATE(start_date) >= ?', [$this->start])
            ->whereRaw('DATE(end_date) <= ?', [$this->end]);

        if ($this->createdAt) {
            $time24 = date("H:i:s", strtotime($this->createdAt));
            $query->whereTime('created_at', $time24);
        }

        if ($this->companyId) {
            $query->where('company_id', $this->companyId);
        }

        return $query->get()->map(function ($coupon) {
            return [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'value' => $coupon->value,
                'type' => $coupon->type,
                'discount_type' => $coupon->discount_type,
                'total_games' => $coupon->total_games,
                'active' => $coupon->active,
                'usage_limit' => $coupon->usage_limit,
                'usage_per_user' => $coupon->usage_per_user,
                'start_date' => $coupon->start_date,
                'end_date' => $coupon->end_date,
                'user_id' => $coupon->user_id,
                'created_at' => $coupon->created_at,
                'updated_at' => $coupon->updated_at,
                'company_name' => $coupon->company ? $coupon->company->name : null,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Code',
            'Value',
            'Type',
            'Discount Type',
            'Total Games',
            'Active',
            'Usage Limit',
            'Usage Per User',
            'Start Date',
            'End Date',
            'User ID',
            'Created At',
            'Updated At',
            'Company Name'
        ];
    }
}
