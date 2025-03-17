<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Shuchkin\SimpleXLSXGen;

class ReportController extends Controller
{
	const REPORT_AUTHOR                     = 'Belmar Alberto <dispersion,mx@gmail.com>';
	const REPORT_COMPANY                    = 'Custom Web Vitals <dispersion,mx@gmail.com>';
	const REPORT_LANGUAGE                   = 'es-MX';

    public function quotation_report()
    {
		$xlsx                               = IOFactory::load(storage_path('app/public/reportes/layout_reporte_cotizaciones.xlsx'));
		$sheet                              = $xlsx->getActiveSheet();
		$dataset                            = self::quotation_report_get_dataset();

		$r                                  = 2;
		foreach ($dataset as $data)
		{
			$sheet->setCellValue("A$r", $data->id);
			$sheet->setCellValue("B$r", $data->ejercicio);
			$sheet->setCellValue("C$r", $data->periodo);
			$sheet->setCellValue("D$r", $data->cliente_empresa);
			$sheet->setCellValue("E$r", $data->cliente_nombre);
			$sheet->setCellValue("F$r", $data->cliente_email);
			$sheet->setCellValue("G$r", $data->cliente_estado);
			$sheet->setCellValue("H$r", $data->estatus);
			$sheet->setCellValue("I$r", $data->atendio);
			$sheet->setCellValue("J$r", $data->recibido);
			$sheet->setCellValue("K$r", $data->atendido);
			$sheet->setCellValue("L$r", $data->dias_despues);
			$sheet->setCellValue("M$r", $data->total_original);
			$sheet->setCellValue("N$r", $data->total_descuento);
			$sheet->setCellValue("O$r", $data->total_final);
			$r=$r+1;
		}


	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header('Content-Disposition: attachment;filename="'.date('YmdHis').'_reporte_cotizaciones.xlsx"');
	    header('Cache-Control: max-age=0');
	    $writter                            = IOFactory::createWriter($xlsx, 'Xlsx');
		$writter->setPreCalculateFormulas(false);
		$writter->save('php://output');
    }

	private static function quotation_report_get_dataset()
	{
		return DB::select("SELECT F.id, YEAR(F.created_at) AS ejercicio, MONTH(F.created_at) AS periodo,
		       UPPER(C.company) AS cliente_empresa, C.name AS cliente_nombre, C.email AS cliente_email, S.name AS cliente_estado,
		       IF(F.status='approved', 'Aprobado', 'Rechazado') AS estatus,
		       U.name AS atendio, F.created_at AS recibido, IF(F.status = 'approved', F.approved_at , F.rejected_at) AS atendido,
		       DATEDIFF(IF(F.status = 'approved', F.approved_at , F.rejected_at), F.created_at) AS dias_despues,
		       SUM(D.original_price) AS total_original, SUM(D.discount) AS total_descuento, SUM(D.total) AS total_final
		FROM form_submits AS F
		JOIN users AS U
		    ON U.id = IF(F.status = 'approved', F.approved_by_user_id , F.rejected_by_user_id)
		JOIN form_contacts AS C
		    ON C.id = F.form_contact_id
		JOIN form_quotation_details AS D
		    ON D.form_submit_id = F.id AND D.deleted_at IS NULL
		JOIN states AS S
		    ON C.state_id = S.id
		WHERE type='quotation' AND status <> 'pending' AND F.created_at BETWEEN '2024-01-01' AND NOW()
		    AND C.email NOT IN ('dispersion.mx@gmail.com', 'caja@equi-par.com', 'atencionaclientes@equi-par.com', 'lguzman@equi-par.com')
		    AND F.deleted_at IS NULL
		GROUP BY F.id, F.created_at
		ORDER BY F.created_at DESC");
	}
}
