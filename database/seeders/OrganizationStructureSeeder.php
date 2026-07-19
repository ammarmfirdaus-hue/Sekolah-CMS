<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrganizationStructure;

class OrganizationStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            [
                'id' => 1,
                'position' => 'Pembina',
                'sort_order' => 1,
                'is_active' => true,
                'name' => '' // Provide empty string to satisfy NOT NULL constraint if applicable
            ],
            [
                'id' => 2,
                'position' => 'Ketua Yayasan',
                'sort_order' => 2,
                'is_active' => true,
                'name' => ''
            ],
            [
                'id' => 3,
                'position' => 'Sekretaris',
                'sort_order' => 3,
                'is_active' => true,
                'name' => ''
            ],
            [
                'id' => 4,
                'position' => 'Bendahara',
                'sort_order' => 4,
                'is_active' => true,
                'name' => ''
            ],
            [
                'id' => 5,
                'position' => 'Ketua PKBM',
                'sort_order' => 5,
                'is_active' => true,
                'name' => ''
            ],
            [
                'id' => 6,
                'position' => 'Kepala Sekolah SPS',
                'sort_order' => 6,
                'is_active' => true,
                'name' => ''
            ],
        ];

        foreach ($positions as $positionData) {
            $existing = OrganizationStructure::find($positionData['id']);
            
            if (!$existing) {
                OrganizationStructure::create($positionData);
            } else {
                // If it exists, let's just make sure position and sort order are correct.
                // We do NOT overwrite the name or photo if it's already filled.
                $existing->update([
                    'position' => $positionData['position'],
                    'sort_order' => $positionData['sort_order'],
                ]);
            }
        }
    }
}
