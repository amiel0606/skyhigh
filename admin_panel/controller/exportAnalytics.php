<?php
session_start();
include_once('./dbCon.php');
include_once('./getFunctions.php');

// Check if user is admin
if (!isset($_SESSION['admin_id'])) {
    http_response_code(403);
    exit('Unauthorized');
}

$format = isset($_GET['format']) ? $_GET['format'] : 'excel';
$view = isset($_GET['view']) ? $_GET['view'] : 'charts';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'month';
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;

// Get the data based on current filters
$appointmentsData = getExportData('appointments', $filter, $startDate, $endDate);
$revenueData = getExportData('revenue', $filter, $startDate, $endDate);
$serviceBookingsData = getExportData('serviceBookings', $filter, $startDate, $endDate);

// Get summary metrics
$analyticsData = [
    'totalOrders' => getTotalOrders(),
    'totalRevenue' => getTotalRevenue(),
    'topSellingItem' => getTopSellingItem(),
    'topService' => getTopService(),
    'mostScheduledTime' => getMostScheduledTime(),
    'mostScheduledDay' => getMostScheduledDay(),
    'totalAppointments' => getTotalAppointments(),
    'activeUsers' => getActiveUsersCount(),
    'walkInAppointments' => getWalkInAppointmentsCount()
];

if ($format === 'excel') {
    exportToExcel($appointmentsData, $revenueData, $serviceBookingsData, $analyticsData, $filter, $startDate, $endDate);
} else {
    exportToPDF($appointmentsData, $revenueData, $serviceBookingsData, $analyticsData, $filter, $startDate, $endDate);
}

function getExportData($type, $filter, $startDate, $endDate) {
    if ($startDate && $endDate) {
        switch ($type) {
            case 'appointments':
                return getDetailedAppointmentsData($startDate, $endDate);
            case 'revenue':
                return getDetailedRevenueData($startDate, $endDate);
            case 'serviceBookings':
                return getDetailedServiceBookingsData($startDate, $endDate);
        }
    } else {
        switch ($type) {
            case 'appointments':
                return getDetailedAppointmentsData();
            case 'revenue':
                return getDetailedRevenueData();
            case 'serviceBookings':
                return getDetailedServiceBookingsData();
        }
    }
    return [];
}

function exportToExcel($appointmentsData, $revenueData, $serviceBookingsData, $analyticsData, $filter, $startDate, $endDate) {
    // Set headers for Excel download
    $filename = 'analytics_export_' . date('Y-m-d_H-i-s') . '.csv';
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Expires: 0');

    $output = fopen('php://output', 'w');

    // Add BOM for UTF-8
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

    // Export Summary Metrics
    fputcsv($output, ['ANALYTICS SUMMARY REPORT']);
    fputcsv($output, ['Generated on: ' . date('Y-m-d H:i:s')]);
    if ($startDate && $endDate) {
        fputcsv($output, ['Date Range: ' . $startDate . ' to ' . $endDate]);
    } else {
        fputcsv($output, ['Filter: ' . ucfirst($filter)]);
    }
    fputcsv($output, []);

    // Summary metrics
    fputcsv($output, ['SUMMARY METRICS']);
    fputcsv($output, ['Metric', 'Value']);
    fputcsv($output, ['Total Orders', $analyticsData['totalOrders']]);
    fputcsv($output, ['Total Revenue', '₱' . number_format($analyticsData['totalRevenue'] / 100, 2)]);
    fputcsv($output, ['Top Selling Item', $analyticsData['topSellingItem']]);
    
    $topService = $analyticsData['topService'];
    if (isset($topService['services']) && !empty($topService['services'])) {
        fputcsv($output, ['Top Service', implode(', ', $topService['services'])]);
    } else {
        fputcsv($output, ['Top Service', $topService['message'] ?? 'No data']);
    }
    
    fputcsv($output, ['Most Scheduled Time', $analyticsData['mostScheduledTime']]);
    fputcsv($output, ['Most Scheduled Day', $analyticsData['mostScheduledDay']]);
    fputcsv($output, ['Total Appointments', $analyticsData['totalAppointments']]);
    fputcsv($output, ['Active Users', $analyticsData['activeUsers']]);
    fputcsv($output, ['Walk-in Appointments', $analyticsData['walkInAppointments']]);
    fputcsv($output, []);

    // Appointments Data
    if (!empty($appointmentsData)) {
        fputcsv($output, ['APPOINTMENTS DATA']);
        fputcsv($output, ['Date', 'Name', 'Username', 'Service', 'Vehicle', 'Time', 'Status', 'Type']);
        foreach ($appointmentsData as $appointment) {
            fputcsv($output, [
                $appointment['appointment_date'],
                $appointment['name'],
                $appointment['username'],
                $appointment['service'],
                $appointment['vehicle'],
                $appointment['time'],
                $appointment['status'],
                $appointment['type']
            ]);
        }
        fputcsv($output, []);
    }

    // Revenue Data
    if (!empty($revenueData)) {
        fputcsv($output, ['REVENUE DATA']);
        fputcsv($output, ['Date', 'Transaction ID', 'Customer Name', 'Username', 'Amount', 'Status']);
        foreach ($revenueData as $transaction) {
            fputcsv($output, [
                $transaction['transaction_date'],
                $transaction['payment_intent_id'],
                $transaction['name'],
                $transaction['username'],
                '₱' . number_format($transaction['total'] / 100, 2),
                $transaction['status']
            ]);
        }
        fputcsv($output, []);
    }

    // Service Bookings Data
    if (!empty($serviceBookingsData)) {
        fputcsv($output, ['SERVICE BOOKINGS DATA']);
        fputcsv($output, ['Service', 'Total Bookings', 'Confirmed', 'Completed', 'Pending', 'Declined']);
        foreach ($serviceBookingsData as $service) {
            fputcsv($output, [
                $service['service'],
                $service['total_bookings'],
                $service['confirmed'],
                $service['completed'],
                $service['pending'],
                $service['declined']
            ]);
        }
    }

    fclose($output);
}

function exportToPDF($appointmentsData, $revenueData, $serviceBookingsData, $analyticsData, $filter, $startDate, $endDate) {
    require_once __DIR__ . '/../../vendor/autoload.php';

    if (!class_exists('TCPDF')) {
        die('TCPDF library not found.');
    }

    exportWithTCPDF($appointmentsData, $revenueData, $serviceBookingsData, $analyticsData, $filter, $startDate, $endDate);
}

function exportWithTCPDF($appointmentsData, $revenueData, $serviceBookingsData, $analyticsData, $filter, $startDate, $endDate) {
    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // Set document information
    $pdf->SetCreator('SkyHigh Analytics');
    $pdf->SetAuthor('Admin');
    $pdf->SetTitle('Analytics Report');
    $pdf->SetSubject('Analytics Export');
    
    // Set default header data
    $pdf->SetHeaderData('', 0, 'Analytics Report', 'Generated on: ' . date('Y-m-d H:i:s'));
    
    // Set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    
    // Set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
    // Set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
    // Add a page
    $pdf->AddPage();
    
    // Set font
    $pdf->SetFont('helvetica', '', 12);
    
    // Title
    $pdf->Cell(0, 10, 'Analytics Summary Report', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
    $pdf->Ln(5);
    
    // Date range info
    if ($startDate && $endDate) {
        $pdf->Cell(0, 10, 'Date Range: ' . $startDate . ' to ' . $endDate, 0, 1, 'C', 0, '', 0, false, 'M', 'M');
    } else {
        $pdf->Cell(0, 10, 'Filter: ' . ucfirst($filter), 0, 1, 'C', 0, '', 0, false, 'M', 'M');
    }
    $pdf->Ln(10);
    
    // Summary Metrics
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, 'Summary Metrics', 0, 1, 'L', 0, '', 0, false, 'M', 'M');
    $pdf->SetFont('helvetica', '', 10);
    
    $metrics = [
        ['Total Orders', $analyticsData['totalOrders']],
        ['Total Revenue', '₱' . number_format($analyticsData['totalRevenue'] / 100, 2)],
        ['Top Selling Item', $analyticsData['topSellingItem']],
        ['Most Scheduled Time', $analyticsData['mostScheduledTime']],
        ['Most Scheduled Day', $analyticsData['mostScheduledDay']],
        ['Total Appointments', $analyticsData['totalAppointments']],
        ['Active Users', $analyticsData['activeUsers']],
        ['Walk-in Appointments', $analyticsData['walkInAppointments']]
    ];
    
    // Handle top service
    $topService = $analyticsData['topService'];
    if (isset($topService['services']) && !empty($topService['services'])) {
        $metrics[] = ['Top Service', implode(', ', $topService['services'])];
    } else {
        $metrics[] = ['Top Service', $topService['message'] ?? 'No data'];
    }
    
    // Summary metrics table with proper alignment
    $summaryColWidths = [
        'label' => 90,  // Metric label column
        'value' => 90   // Metric value column
    ];
    
    foreach ($metrics as $metric) {
        $pdf->Cell($summaryColWidths['label'], 12, $metric[0] . ':', 1, 0, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell($summaryColWidths['value'], 12, $metric[1], 1, 1, 'L', 0, '', 0, false, 'M', 'M');
    }
    
    $pdf->Ln(10);
    
    // Appointments Data
    if (!empty($appointmentsData)) {
        $pdf->AddPage(); // Start appointments on new page
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Appointments Data', 0, 1, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->SetFont('helvetica', 'B', 9);
        
        // Calculate available width (210mm - margins = ~180mm = 180 units)
        $colWidths = [
            'date' => 25,      // Date
            'name' => 30,      // Name  
            'username' => 25,  // Username
            'service' => 35,   // Service
            'vehicle' => 25,   // Vehicle
            'time' => 15,      // Time
            'status' => 15,    // Status
            'type' => 10       // Type
        ];
        
        // Table headers
        $pdf->Cell($colWidths['date'], 10, 'Date', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell($colWidths['name'], 10, 'Name', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell($colWidths['username'], 10, 'Username', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell($colWidths['service'], 10, 'Service', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell($colWidths['vehicle'], 10, 'Vehicle', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell($colWidths['time'], 10, 'Time', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell($colWidths['status'], 10, 'Status', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell($colWidths['type'], 10, 'Type', 1, 1, 'C', 0, '', 0, false, 'M', 'M');
        
        $pdf->SetFont('helvetica', '', 8);
        
        // Table data with proper text truncation
        $count = 0;
        foreach ($appointmentsData as $appointment) {
            if ($count >= 30) break; // Limit rows
            
            // Check if we need a new page
            if ($pdf->GetY() > 250) {
                $pdf->AddPage();
                // Repeat headers
                $pdf->SetFont('helvetica', 'B', 9);
                $pdf->Cell($colWidths['date'], 10, 'Date', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell($colWidths['name'], 10, 'Name', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell($colWidths['username'], 10, 'Username', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell($colWidths['service'], 10, 'Service', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell($colWidths['vehicle'], 10, 'Vehicle', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell($colWidths['time'], 10, 'Time', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell($colWidths['status'], 10, 'Status', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell($colWidths['type'], 10, 'Type', 1, 1, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->SetFont('helvetica', '', 8);
            }
            
            // Truncate text to fit columns
            $date = substr($appointment['appointment_date'], 0, 10);
            $name = substr($appointment['name'], 0, 20);
            $username = substr($appointment['username'], 0, 15);
            $service = substr($appointment['service'], 0, 25);
            $vehicle = substr($appointment['vehicle'], 0, 18);
            $time = $appointment['time'];
            $status = substr($appointment['status'], 0, 10);
            $type = substr($appointment['type'], 0, 8);
            
            $pdf->Cell($colWidths['date'], 8, $date, 1, 0, 'L', 0, '', 0, false, 'T', 'M');
            $pdf->Cell($colWidths['name'], 8, $name, 1, 0, 'L', 0, '', 0, false, 'T', 'M');
            $pdf->Cell($colWidths['username'], 8, $username, 1, 0, 'L', 0, '', 0, false, 'T', 'M');
            $pdf->Cell($colWidths['service'], 8, $service, 1, 0, 'L', 0, '', 0, false, 'T', 'M');
            $pdf->Cell($colWidths['vehicle'], 8, $vehicle, 1, 0, 'L', 0, '', 0, false, 'T', 'M');
            $pdf->Cell($colWidths['time'], 8, $time, 1, 0, 'C', 0, '', 0, false, 'T', 'M');
            $pdf->Cell($colWidths['status'], 8, $status, 1, 0, 'C', 0, '', 0, false, 'T', 'M');
            $pdf->Cell($colWidths['type'], 8, $type, 1, 1, 'C', 0, '', 0, false, 'T', 'M');
            $count++;
        }
        
        if (count($appointmentsData) > 30) {
            $pdf->Ln(5);
            $pdf->SetFont('helvetica', 'I', 9);
            $pdf->Cell(0, 6, '... and ' . (count($appointmentsData) - 30) . ' more records (showing first 30)', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        }
    }
    
    // Revenue Data
    if (!empty($revenueData)) {
        $pdf->AddPage(); // Start revenue on new page
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Revenue Data', 0, 1, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->SetFont('helvetica', 'B', 9);
        
        // Column widths for revenue table
        $revColWidths = [
            'date' => 25,
            'transaction' => 45,
            'customer' => 35,
            'username' => 25,
            'amount' => 25,
            'status' => 25
        ];
        
        // Table headers
        $pdf->Cell($revColWidths['date'], 10, 'Date', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell($revColWidths['transaction'], 10, 'Transaction ID', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell($revColWidths['customer'], 10, 'Customer', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell($revColWidths['username'], 10, 'Username', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell($revColWidths['amount'], 10, 'Amount', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell($revColWidths['status'], 10, 'Status', 1, 1, 'C', 0, '', 0, false, 'M', 'M');
        
        $pdf->SetFont('helvetica', '', 8);
        
        $count = 0;
        foreach ($revenueData as $transaction) {
            if ($count >= 30) break;
            
            // Check if we need a new page
            if ($pdf->GetY() > 250) {
                $pdf->AddPage();
                // Repeat headers
                $pdf->SetFont('helvetica', 'B', 9);
                $pdf->Cell($revColWidths['date'], 10, 'Date', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell($revColWidths['transaction'], 10, 'Transaction ID', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell($revColWidths['customer'], 10, 'Customer', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell($revColWidths['username'], 10, 'Username', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell($revColWidths['amount'], 10, 'Amount', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell($revColWidths['status'], 10, 'Status', 1, 1, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->SetFont('helvetica', '', 8);
            }
            
            // Truncate text to fit columns
            $date = substr($transaction['transaction_date'], 0, 10);
            $transactionId = substr($transaction['payment_intent_id'], 0, 30);
            $customer = substr($transaction['name'], 0, 25);
            $username = substr($transaction['username'], 0, 15);
            $amount = '₱' . number_format($transaction['total'] / 100, 2);
            $status = $transaction['status'];
            
            $pdf->Cell($revColWidths['date'], 8, $date, 1, 0, 'L', 0, '', 0, false, 'T', 'M');
            $pdf->Cell($revColWidths['transaction'], 8, $transactionId, 1, 0, 'L', 0, '', 0, false, 'T', 'M');
            $pdf->Cell($revColWidths['customer'], 8, $customer, 1, 0, 'L', 0, '', 0, false, 'T', 'M');
            $pdf->Cell($revColWidths['username'], 8, $username, 1, 0, 'L', 0, '', 0, false, 'T', 'M');
            $pdf->Cell($revColWidths['amount'], 8, $amount, 1, 0, 'R', 0, '', 0, false, 'T', 'M');
            $pdf->Cell($revColWidths['status'], 8, $status, 1, 1, 'C', 0, '', 0, false, 'T', 'M');
            $count++;
        }
        
        if (count($revenueData) > 30) {
            $pdf->Ln(5);
            $pdf->SetFont('helvetica', 'I', 9);
            $pdf->Cell(0, 6, '... and ' . (count($revenueData) - 30) . ' more records (showing first 30)', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        }
    }
    
    // Service Bookings Data
    if (!empty($serviceBookingsData)) {
        $pdf->AddPage(); // Start service bookings on new page
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Service Bookings Data', 0, 1, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->SetFont('helvetica', 'B', 9);
        
        // Column widths for service bookings table
        $serviceColWidths = [
            'service' => 60,
            'total' => 20,
            'confirmed' => 20,
            'completed' => 20,
            'pending' => 20,
            'declined' => 20
        ];
        
        // Table headers
        $pdf->Cell($serviceColWidths['service'], 10, 'Service', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell($serviceColWidths['total'], 10, 'Total', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell($serviceColWidths['confirmed'], 10, 'Confirmed', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell($serviceColWidths['completed'], 10, 'Completed', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell($serviceColWidths['pending'], 10, 'Pending', 1, 0, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell($serviceColWidths['declined'], 10, 'Declined', 1, 1, 'C', 0, '', 0, false, 'M', 'M');
        
        $pdf->SetFont('helvetica', '', 8);
        
        foreach ($serviceBookingsData as $service) {
            $serviceName = substr($service['service'], 0, 45);
            
            $pdf->Cell($serviceColWidths['service'], 8, $serviceName, 1, 0, 'L', 0, '', 0, false, 'T', 'M');
            $pdf->Cell($serviceColWidths['total'], 8, $service['total_bookings'], 1, 0, 'C', 0, '', 0, false, 'T', 'M');
            $pdf->Cell($serviceColWidths['confirmed'], 8, $service['confirmed'], 1, 0, 'C', 0, '', 0, false, 'T', 'M');
            $pdf->Cell($serviceColWidths['completed'], 8, $service['completed'], 1, 0, 'C', 0, '', 0, false, 'T', 'M');
            $pdf->Cell($serviceColWidths['pending'], 8, $service['pending'], 1, 0, 'C', 0, '', 0, false, 'T', 'M');
            $pdf->Cell($serviceColWidths['declined'], 8, $service['declined'], 1, 1, 'C', 0, '', 0, false, 'T', 'M');
        }
    }
    
    // Set filename and output
    $filename = 'analytics_export_' . date('Y-m-d_H-i-s') . '.pdf';
    
    // Output PDF
    $pdf->Output($filename, 'D');
}

function exportHTMLForPrint($appointmentsData, $revenueData, $serviceBookingsData, $analyticsData, $filter, $startDate, $endDate) {
    // Set headers for HTML download with print instructions
    $filename = 'analytics_report_' . date('Y-m-d_H-i-s') . '.html';
    header('Content-Type: text/html; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Analytics Report - Print to PDF</title>
        <style>
            body { 
                font-family: Arial, sans-serif; 
                margin: 20px; 
                line-height: 1.4;
            }
            .print-instructions {
                background: #e3f2fd;
                border: 2px solid #2196f3;
                padding: 15px;
                margin-bottom: 20px;
                border-radius: 5px;
                text-align: center;
            }
            .print-instructions h3 {
                margin: 0 0 10px 0;
                color: #1976d2;
            }
            .header { 
                text-align: center; 
                margin-bottom: 30px; 
                border-bottom: 2px solid #333;
                padding-bottom: 10px;
            }
            .section { 
                margin-bottom: 30px; 
                page-break-inside: avoid;
            }
            .section h2 { 
                color: #333; 
                border-bottom: 2px solid #3273dc; 
                padding-bottom: 5px; 
                margin-bottom: 15px;
            }
            table { 
                width: 100%; 
                border-collapse: collapse; 
                margin-bottom: 20px; 
                font-size: 12px;
            }
            th, td { 
                border: 1px solid #ddd; 
                padding: 8px; 
                text-align: left; 
            }
            th { 
                background-color: #f5f5f5; 
                font-weight: bold; 
            }
            .summary-grid { 
                display: grid; 
                grid-template-columns: repeat(2, 1fr); 
                gap: 10px; 
                margin-bottom: 20px;
            }
            .summary-item { 
                padding: 10px; 
                background-color: #f9f9f9; 
                border-radius: 5px; 
                border: 1px solid #ddd;
            }
            .summary-label { 
                font-weight: bold; 
                color: #666; 
                margin-bottom: 5px;
            }
            .summary-value { 
                font-size: 1.2em; 
                color: #333; 
            }
            @media print {
                .print-instructions { display: none; }
                body { margin: 0; font-size: 12px; }
                .section { page-break-inside: avoid; }
                table { font-size: 10px; }
            }
            @page {
                margin: 1cm;
                size: A4;
            }
        </style>
    </head>
    <body>
        <div class="print-instructions">
            <h3>📄 How to Save as PDF</h3>
            <p><strong>Press Ctrl+P (Windows) or Cmd+P (Mac)</strong> to open print dialog, then select <strong>"Save as PDF"</strong> or <strong>"Microsoft Print to PDF"</strong> as the destination.</p>
            <p>This page is optimized for A4 printing and PDF generation.</p>
        </div>
        
        <div class="header">
            <h1>Analytics Report</h1>
            <p><strong>Generated on:</strong> ' . date('Y-m-d H:i:s') . '</p>';
    
    if ($startDate && $endDate) {
        echo '<p><strong>Date Range:</strong> ' . $startDate . ' to ' . $endDate . '</p>';
    } else {
        echo '<p><strong>Filter:</strong> ' . ucfirst($filter) . '</p>';
    }
    
    echo '</div>';

    // Summary Metrics
    echo '<div class="section">
            <h2>Summary Metrics</h2>
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-label">Total Orders</div>
                    <div class="summary-value">' . $analyticsData['totalOrders'] . '</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Total Revenue</div>
                    <div class="summary-value">₱' . number_format($analyticsData['totalRevenue'] / 100, 2) . '</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Top Selling Item</div>
                    <div class="summary-value">' . htmlspecialchars($analyticsData['topSellingItem']) . '</div>
                </div>';
    
    $topService = $analyticsData['topService'];
    $topServiceText = '';
    if (isset($topService['services']) && !empty($topService['services'])) {
        $topServiceText = implode(', ', $topService['services']);
    } else {
        $topServiceText = $topService['message'] ?? 'No data';
    }
    
    echo '      <div class="summary-item">
                    <div class="summary-label">Top Service</div>
                    <div class="summary-value">' . htmlspecialchars($topServiceText) . '</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Most Scheduled Time</div>
                    <div class="summary-value">' . htmlspecialchars($analyticsData['mostScheduledTime']) . '</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Most Scheduled Day</div>
                    <div class="summary-value">' . htmlspecialchars($analyticsData['mostScheduledDay']) . '</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Total Appointments</div>
                    <div class="summary-value">' . $analyticsData['totalAppointments'] . '</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Active Users</div>
                    <div class="summary-value">' . $analyticsData['activeUsers'] . '</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Walk-in Appointments</div>
                    <div class="summary-value">' . $analyticsData['walkInAppointments'] . '</div>
                </div>
            </div>
        </div>';

    // Appointments Data
    if (!empty($appointmentsData)) {
        echo '<div class="section">
                <h2>Appointments Data</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Service</th>
                            <th>Vehicle</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        foreach ($appointmentsData as $appointment) {
            echo '<tr>
                    <td>' . htmlspecialchars($appointment['appointment_date']) . '</td>
                    <td>' . htmlspecialchars($appointment['name']) . '</td>
                    <td>' . htmlspecialchars($appointment['username']) . '</td>
                    <td>' . htmlspecialchars($appointment['service']) . '</td>
                    <td>' . htmlspecialchars($appointment['vehicle']) . '</td>
                    <td>' . htmlspecialchars($appointment['time']) . '</td>
                    <td>' . htmlspecialchars($appointment['status']) . '</td>
                    <td>' . htmlspecialchars($appointment['type']) . '</td>
                  </tr>';
        }
        
        echo '    </tbody>
                </table>
              </div>';
    }

    // Revenue Data
    if (!empty($revenueData)) {
        echo '<div class="section">
                <h2>Revenue Data</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Transaction ID</th>
                            <th>Customer Name</th>
                            <th>Username</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        foreach ($revenueData as $transaction) {
            echo '<tr>
                    <td>' . htmlspecialchars($transaction['transaction_date']) . '</td>
                    <td>' . htmlspecialchars($transaction['payment_intent_id']) . '</td>
                    <td>' . htmlspecialchars($transaction['name']) . '</td>
                    <td>' . htmlspecialchars($transaction['username']) . '</td>
                    <td>₱' . number_format($transaction['total'] / 100, 2) . '</td>
                    <td>' . htmlspecialchars($transaction['status']) . '</td>
                  </tr>';
        }
        
        echo '    </tbody>
                </table>
              </div>';
    }

    // Service Bookings Data
    if (!empty($serviceBookingsData)) {
        echo '<div class="section">
                <h2>Service Bookings Data</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Total Bookings</th>
                            <th>Confirmed</th>
                            <th>Completed</th>
                            <th>Pending</th>
                            <th>Declined</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        foreach ($serviceBookingsData as $service) {
            echo '<tr>
                    <td>' . htmlspecialchars($service['service']) . '</td>
                    <td>' . $service['total_bookings'] . '</td>
                    <td>' . $service['confirmed'] . '</td>
                    <td>' . $service['completed'] . '</td>
                    <td>' . $service['pending'] . '</td>
                    <td>' . $service['declined'] . '</td>
                  </tr>';
        }
        
        echo '    </tbody>
                </table>
              </div>';
    }

    echo '<script>
            // Auto-open print dialog after page loads
            window.onload = function() {
                setTimeout(function() {
                    window.print();
                }, 1000);
            };
          </script>
    </body>
    </html>';
}
?> 