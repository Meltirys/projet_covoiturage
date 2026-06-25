<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $table            = 'Report';
    protected $primaryKey       = 'id_report';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['reporter', 'reported', 'date', 'is_resolved', 'comment'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getReportInformations(bool $isResolved = false): array
    {
        return $this->select($this->table . ".*, 
                CONCAT(reporter.first_name, ' ', reporter.last_name) AS reporter_name,
                CONCAT(reported.first_name, ' ', reported.last_name) AS reported_name")
            ->join('Users AS reporter', 'reporter.id_user = Report.reporter')
            ->join('Users AS reported', 'reported.id_user = Report.reported')
            ->where('is_resolved', $isResolved)
            ->orderBy('date', 'DESC')
            ->findAll();
    }
}
