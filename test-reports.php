<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DEBUG FEATURED REPORTS ===\n\n";

// 1. Check if data exists at all
$totalReports = \App\Models\ReportPublicationData::count();
echo "1. Total reports in database: {$totalReports}\n";

if ($totalReports === 0) {
    echo "   ❌ No data found! Running seeder...\n";
    \Artisan::call('db:seed', ['--class' => 'ReportPublicationSeeder', '--force' => true]);
    $totalReports = \App\Models\ReportPublicationData::count();
    echo "   ✅ After seeding: {$totalReports} reports\n";
}

// 2. Check sample data
echo "\n2. Sample data:\n";
$sample = \App\Models\ReportPublicationData::first();
if ($sample) {
    echo "   ID: {$sample->id}\n";
    echo "   Judul: {$sample->judul}\n";
    echo "   Kategori: {$sample->kategori}\n";
    echo "   File Path: " . ($sample->file_path ?? 'NULL') . "\n";
    echo "   Waktu Terbit: " . ($sample->waktu_terbit ?? 'NULL') . "\n";
} else {
    echo "   ❌ No sample data found\n";
}

// 3. Check different query conditions
echo "\n3. Testing query conditions:\n";

// Step by step debugging
echo "   All reports: " . \App\Models\ReportPublicationData::count() . "\n";

$withFilePath = \App\Models\ReportPublicationData::whereNotNull('file_path')->count();
echo "   With file_path: {$withFilePath}\n";

$featuredCategories = ['annual_report', 'financial_report', 'village_profile'];
$withCategories = \App\Models\ReportPublicationData::whereIn('kategori', $featuredCategories)->count();
echo "   With featured categories: {$withCategories}\n";

$withBoth = \App\Models\ReportPublicationData::whereNotNull('file_path')
    ->whereIn('kategori', $featuredCategories)
    ->count();
echo "   With both conditions: {$withBoth}\n";

// 4. Test the exact query from controller
echo "\n4. Testing exact controller query:\n";
try {
    $featuredReports = \App\Models\ReportPublicationData::whereNotNull('file_path')
        ->whereIn('kategori', ['annual_report', 'financial_report', 'village_profile'])
        ->orderBy('waktu_terbit', 'desc')
        ->take(3)
        ->get();

    echo "   Featured reports found: {$featuredReports->count()}\n";

    foreach ($featuredReports as $report) {
        echo "   - {$report->judul} ({$report->kategori})\n";
    }
} catch (Exception $e) {
    echo "   ❌ Query error: " . $e->getMessage() . "\n";
}

// 5. Test without file_path constraint
echo "\n5. Testing without file_path constraint:\n";
try {
    $allFeatured = \App\Models\ReportPublicationData::whereIn('kategori', ['annual_report', 'financial_report', 'village_profile'])
        ->orderBy('waktu_terbit', 'desc')
        ->take(3)
        ->get();

    echo "   All featured (no file_path check): {$allFeatured->count()}\n";

    foreach ($allFeatured as $report) {
        echo "   - {$report->judul} ({$report->kategori}) - File: " . ($report->file_path ?? 'NULL') . "\n";
    }
} catch (Exception $e) {
    echo "   ❌ Query error: " . $e->getMessage() . "\n";
}

// 6. Check file_path values
echo "\n6. Checking file_path values:\n";
$reportsWithPaths = \App\Models\ReportPublicationData::select('judul', 'kategori', 'file_path')
    ->limit(5)
    ->get();

foreach ($reportsWithPaths as $report) {
    $hasPath = !is_null($report->file_path) && !empty($report->file_path);
    echo "   - {$report->judul}: " . ($hasPath ? "✅ {$report->file_path}" : "❌ NULL/Empty") . "\n";
}

// 7. Test controller method directly
echo "\n7. Testing controller method:\n";
try {
    $controller = new \App\Http\Controllers\PageRouting();
    $response = $controller->daftarData();

    if ($response instanceof \Illuminate\View\View) {
        $data = $response->getData();
        $featuredReports = $data['featuredReports'] ?? collect();
        echo "   Controller returns: " . gettype($featuredReports) . "\n";
        echo "   Featured reports count: {$featuredReports->count()}\n";

        if ($featuredReports->count() > 0) {
            foreach ($featuredReports as $report) {
                echo "   - " . ($report['title'] ?? 'No title') . "\n";
            }
        }
    } else {
        echo "   ❌ Controller returned unexpected type\n";
    }
} catch (Exception $e) {
    echo "   ❌ Controller error: " . $e->getMessage() . "\n";
    echo "   Stack trace: " . $e->getTraceAsString() . "\n";
}

// 8. Raw SQL debug
echo "\n8. Raw SQL debug:\n";
try {
    \DB::enableQueryLog();

    $result = \App\Models\ReportPublicationData::whereNotNull('file_path')
        ->whereIn('kategori', ['annual_report', 'financial_report', 'village_profile'])
        ->orderBy('waktu_terbit', 'desc')
        ->take(3)
        ->get();

    $queries = \DB::getQueryLog();
    echo "   SQL Query: " . $queries[0]['query'] . "\n";
    echo "   Bindings: " . json_encode($queries[0]['bindings']) . "\n";
    echo "   Result count: " . $result->count() . "\n";
} catch (Exception $e) {
    echo "   ❌ SQL debug error: " . $e->getMessage() . "\n";
}

echo "\n=== DEBUG COMPLETED ===\n";
echo "\nPossible causes if still empty:\n";
echo "1. file_path column contains empty strings instead of NULL\n";
echo "2. kategori values don't match exactly\n";
echo "3. waktu_terbit sorting issue\n";
echo "4. Database connection issue\n";
echo "5. Model accessor/mutator interference\n";
