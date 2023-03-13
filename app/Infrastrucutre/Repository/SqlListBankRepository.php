<?php

namespace App\Infrastrucutre\Repository;

use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\ListBank\ListBank;
use App\Core\Domain\Repository\ListBankRepositoryInterface;

class SqlListBankRepository implements ListBankRepositoryInterface
{
    public function find(int $list_bank_id): ?ListBank
    {
        $row = DB::table('list_bank')->where('id', $list_bank_id)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    private function constructFromRows(array $rows): array
    {
        $list_bank = [];
        foreach ($rows as $row) {
            $list_bank[] = new ListBank(
                $row->id,
                $row->name,
            );
        }
        return $list_bank;
    }
}
