{{-- sellerdashboard.blade.php --}}
@extends('layouts.seller')

@section('title', 'LastBite • Dashboard Operasional')

@php
    $productsList = $products ?? collect();
    $storeName = $storeData['name'] ?? 'Toko LastBite';
    $rescuedItems = max(0, (int) ($stats['rescued_items'] ?? 0));
    $flashReadyPct = max(0, min(100, (int) ($stats['flash_ready_pct'] ?? 0)));
    $ordersList = $orders ?? ($recentOrders ?? collect());

    $mapToBoard = function ($raw) {
        $s = strtolower((string) $raw);
        if (in_array($s, ['unpaid', 'belum_bayar', 'pending_payment', 'menunggu_pembayaran', 'pending'])) {
            return 'unpaid';
        }
        if (in_array($s, ['processing', 'diproses', 'paid', 'perlu_diproses'])) {
            return 'processing';
        }
        if (in_array($s, ['shipped', 'dikirim', 'shipping', 'sent'])) {
            return 'shipped';
        }
        if (in_array($s, ['done', 'completed', 'selesai', 'delivered'])) {
            return 'done';
        }
        return 'processing';
    };

    $countUnpaid = 0;
    $countProcessing = 0;
    $countShipped = 0;
    $countDone = 0;
    foreach ($ordersList as $o) {
        $k = $mapToBoard($o->status ?? '');
        if ($k === 'unpaid') {
            $countUnpaid++;
        } elseif ($k === 'processing') {
            $countProcessing++;
        } elseif ($k === 'shipped') {
            $countShipped++;
        } elseif ($k === 'done') {
            $countDone++;
        }
    }

    $categoryOptions =
        $categories ??
        collect([
            (object) ['name' => 'Roti & Bakery'],
            (object) ['name' => 'Makanan Siap Saji'],
            (object) ['name' => 'Minuman'],
            (object) ['name' => 'Snack'],
            (object) ['name' => 'Frozen'],
            (object) ['name' => 'Sembako'],
        ]);

    $totalOrders = $ordersList->count();
    $storeRating = number_format((float) ($storeData['rating'] ?? 4.5), 1);
    $averageOrderValue = $ordersList->isNotEmpty() ? $ordersList->avg('total') ?? 0 : 0;

    $hour = (int) now()->format('H');
    $greet =
        $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 19 ? 'Selamat sore' : 'Selamat malam'));
    $today = now()->translatedFormat('l, d F Y');

    $sum = max(1, $countUnpaid + $countProcessing + $countShipped + $countDone);
    $pUnpaid = round(($countUnpaid / $sum) * 100);
    $pProcessing = round(($countProcessing / $sum) * 100);
    $pShipped = round(($countShipped / $sum) * 100);
    $pDone = max(0, 100 - ($pUnpaid + $pProcessing + $pShipped));
@endphp

@section('nav_orders_count', $ordersList->count())
@section('nav_products_count', $productsList->count())

@push('styles')
    <style>
        /* ======================================================
           AIRY / SIMPLE (lebih dekat referensi 1)
           - background soft + glass
           - card lebih “clean”, shadow halus
           - spacing lebih lega
           - typography lebih rapi (bold/light kontras tapi calm)
        ====================================================== */

        :root {
            --font-primary: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            --font-accent: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;

            --bg: #eef2f6;
            --bg2: #f6f8fb;

            --surface: rgba(255, 255, 255, .78);
            --surface-2: rgba(255, 255, 255, .86);
            --border: rgba(15, 23, 42, .10);

            --text: rgba(15, 23, 42, .92);
            --muted: rgba(51, 65, 85, .72);
            --muted2: rgba(100, 116, 139, .78);

            /* Accent “lime” ala referensi */
            --accent: #D7FF1E;
            --accent-2: #B8FF36;

            --r-xl: 26px;
            --r-lg: 22px;
            --r-md: 18px;

            --shadow-sm: 0 10px 24px rgba(15, 23, 42, .06);
            --shadow-md: 0 18px 50px rgba(15, 23, 42, .08);
            --shadow-lg: 0 26px 80px rgba(15, 23, 42, .10);

            --gap-1: 10px;
            --gap-2: 14px;
            --gap-3: 18px;
            --gap-4: 22px;
            --gap-5: 30px;

            --fs-2xs: 11px;
            --fs-xs: 12px;
            --fs-sm: 13px;
            --fs-base: 14px;
            --fs-md: 15px;
            --fs-lg: 18px;
            --fs-xl: 22px;
            --fs-2xl: 28px;

            --fw-light: 350;
            --fw-regular: 400;
            --fw-medium: 520;
            --fw-semibold: 650;
            --fw-bold: 750;
            --fw-black: 850;
        }

        /* Page background */
        .pageWrap {
            position: relative;
            padding-bottom: 8px;
        }

        .pageBg {
            position: absolute;
            inset: -20px -20px auto -20px;
            height: 460px;
            border-radius: 42px;
            background:
                radial-gradient(900px 340px at 18% 18%, rgba(215, 255, 30, .55), transparent 58%),
                radial-gradient(900px 340px at 82% 26%, rgba(56, 189, 248, .20), transparent 60%),
                radial-gradient(900px 340px at 72% 92%, rgba(167, 139, 250, .16), transparent 62%),
                linear-gradient(180deg, rgba(255, 255, 255, .70), transparent 70%);
            filter: blur(0px);
            pointer-events: none;
            z-index: 0;
        }

        .page {
            position: relative;
            z-index: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: var(--gap-5);
            font-family: var(--font-primary);
        }

        /* Universal card */
        .card {
            border-radius: var(--r-xl);
            border: 1px solid var(--border);
            background: var(--surface);
            box-shadow: var(--shadow-md);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            overflow: hidden;
            min-width: 0;
        }

        /* ======================================================
           HERO (lebih airy)
        ====================================================== */
        .hero {
            padding: 22px 24px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: var(--gap-4);
            flex-wrap: wrap;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, .72), rgba(255, 255, 255, .60)),
                radial-gradient(860px 300px at 26% 18%, rgba(215, 255, 30, .34), transparent 60%),
                radial-gradient(860px 300px at 86% 28%, rgba(56, 189, 248, .14), transparent 62%);
        }

        .hTitle {
            margin: 0;
            font-family: var(--font-accent);
            font-size: var(--fs-2xl);
            line-height: 1.12;
            letter-spacing: -.02em;
            color: var(--text);
            font-weight: var(--fw-black);
        }

        .hTitle span {
            font-weight: var(--fw-bold);
            opacity: .98;
        }

        .hSub {
            margin: 10px 0 0;
            font-size: var(--fs-base);
            line-height: 1.65;
            color: var(--muted);
            font-weight: var(--fw-regular);
            max-width: 900px;
        }

        .hMetaRow {
            margin-top: 16px;
            display: flex;
            gap: var(--gap-2);
            flex-wrap: wrap;
            align-items: center;
        }

        .pillMini {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 999px;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .82);
            box-shadow: 0 10px 18px rgba(15, 23, 42, .05);
            color: rgba(15, 23, 42, .82);
            font-size: var(--fs-sm);
            font-weight: var(--fw-medium);
            white-space: nowrap;
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }

        .pillMini i {
            opacity: .9;
        }

        .pillMini b {
            font-family: var(--font-accent);
            font-weight: var(--fw-black);
            color: var(--text);
            letter-spacing: -.01em;
        }

        .pillMini:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(15, 23, 42, .07);
            border-color: rgba(15, 23, 42, .14);
        }

        .heroActions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
        }

        .btn2 {
            height: 44px;
            padding: 0 16px;
            border-radius: 999px;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .86);
            color: rgba(15, 23, 42, .92);
            font-weight: var(--fw-semibold);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            box-shadow: 0 12px 24px rgba(15, 23, 42, .06);
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease, background .18s ease;
            font-family: var(--font-primary);
            font-size: var(--fs-sm);
            letter-spacing: -.01em;
            user-select: none;
        }

        .btn2:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 36px rgba(15, 23, 42, .09);
            border-color: rgba(15, 23, 42, .14);
            background: rgba(255, 255, 255, .94);
        }

        .btn2:active {
            transform: translateY(0);
        }

        /* primary ala “lime” */
        .btn2.primary {
            border: 0;
            background:
                radial-gradient(280px 120px at 30% 40%, rgba(255, 255, 255, .35), transparent 60%),
                linear-gradient(135deg, var(--accent), var(--accent-2));
            color: rgba(15, 23, 42, .92);
            box-shadow: 0 18px 44px rgba(215, 255, 30, .24);
            font-weight: var(--fw-black);
        }

        .btn2.primary:hover {
            box-shadow: 0 22px 60px rgba(215, 255, 30, .30);
        }

        .btnSm {
            height: 36px;
            padding: 0 12px;
            font-size: var(--fs-xs);
        }

        /* ======================================================
           KPI (lebih compact & airy)
        ====================================================== */
        .kpis {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: var(--gap-4);
            align-items: stretch;
        }

        .kpi {
            grid-column: span 3;
            padding: 16px 16px 14px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            height: 100%;
            border-radius: var(--r-xl);
            position: relative;
            overflow: hidden;
            background: var(--surface-2);
            border: 1px solid rgba(15, 23, 42, .10);
            box-shadow: var(--shadow-sm);
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }

        .kpi:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 46px rgba(15, 23, 42, .09);
            border-color: rgba(15, 23, 42, .14);
        }

        /* top row (mini icon button ala referensi) */
        .kTop {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .kIcoBtn {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .88);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 20px rgba(15, 23, 42, .06);
            color: rgba(15, 23, 42, .75);
        }

        .kVal {
            margin: 0;
            font-family: var(--font-accent);
            font-size: 30px;
            line-height: 1.05;
            letter-spacing: -.02em;
            color: var(--text);
            font-weight: var(--fw-black);
        }

        .kLbl {
            margin-top: 4px;
            font-size: var(--fs-sm);
            color: var(--muted2);
            font-weight: var(--fw-medium);
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-radius: 999px;
            font-size: var(--fs-2xs);
            font-weight: var(--fw-bold);
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .82);
            color: rgba(15, 23, 42, .78);
            white-space: nowrap;
            width: fit-content;
        }

        .chip.success {
            background: rgba(16, 185, 129, .14);
            border-color: rgba(16, 185, 129, .22);
            color: #0F766E;
        }

        .chip.warn {
            background: rgba(245, 158, 11, .14);
            border-color: rgba(245, 158, 11, .22);
            color: #92400E;
        }

        .chip.danger {
            background: rgba(239, 68, 68, .14);
            border-color: rgba(239, 68, 68, .22);
            color: #991B1B;
        }

        .chip.neu {
            background: rgba(100, 116, 139, .10);
            border-color: rgba(100, 116, 139, .18);
            color: rgba(15, 23, 42, .76);
            font-weight: var(--fw-semibold);
        }

        /* Accent highlight only for one KPI (mirip referensi: 1 card “popping”) */
        .kpi.kAccent {
            background:
                radial-gradient(520px 200px at 10% 0%, rgba(215, 255, 30, .55), transparent 58%),
                rgba(255, 255, 255, .90);
            border-color: rgba(215, 255, 30, .60);
            box-shadow: 0 24px 70px rgba(215, 255, 30, .20);
        }

        /* ======================================================
           SPLIT
        ====================================================== */
        .split {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: var(--gap-4);
            align-items: stretch;
        }

        .colOrders {
            grid-column: span 7;
        }

        .colChart {
            grid-column: span 5;
        }

        .panel {
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 18px;
        }

        .panelHead {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: var(--gap-3);
            flex-wrap: wrap;
            margin-bottom: 14px;
        }

        .panelTitle {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            min-width: 0;
        }

        .bico {
            width: 42px;
            height: 42px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .86);
            box-shadow: 0 10px 20px rgba(15, 23, 42, .06);
            flex: 0 0 auto;
            color: rgba(15, 23, 42, .75);
        }

        .panelTitle h2 {
            margin: 0;
            font-family: var(--font-accent);
            font-size: var(--fs-xl);
            font-weight: var(--fw-black);
            letter-spacing: -.01em;
            color: var(--text);
        }

        .panelTitle p {
            margin: 6px 0 0;
            font-size: var(--fs-sm);
            color: var(--muted);
            font-weight: var(--fw-regular);
            line-height: 1.5;
        }

        /* Orders list */
        .orders {
            display: grid;
            gap: var(--gap-3);
            flex: 1;
            min-height: 0;
        }

        .order {
            border-radius: var(--r-xl);
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .86);
            box-shadow: 0 14px 34px rgba(15, 23, 42, .06);
            padding: 16px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: var(--gap-3);
            align-items: start;
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }

        .order:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 44px rgba(15, 23, 42, .08);
            border-color: rgba(15, 23, 42, .14);
        }

        .oMain {
            display: flex;
            gap: 14px;
            min-width: 0;
            align-items: flex-start;
        }

        .avatar {
            width: 46px;
            height: 46px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .92);
            border: 1px solid rgba(15, 23, 42, .10);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-accent);
            font-weight: var(--fw-black);
            color: rgba(15, 23, 42, .80);
            flex: 0 0 auto;
            font-size: var(--fs-md);
            box-shadow: 0 10px 20px rgba(15, 23, 42, .05);
        }

        .oName {
            margin: 0;
            font-weight: var(--fw-black);
            font-family: var(--font-accent);
            font-size: var(--fs-base);
            line-height: 1.3;
            color: var(--text);
            letter-spacing: -.01em;
        }

        .oMeta {
            margin-top: 6px;
            color: rgba(100, 116, 139, .86);
            font-size: var(--fs-xs);
            font-weight: var(--fw-medium);
        }

        .pillRow {
            display: flex;
            gap: var(--gap-2);
            flex-wrap: wrap;
            margin-top: 12px;
        }

        .pill {
            padding: 10px 12px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .90);
            border: 1px solid rgba(15, 23, 42, .10);
            min-width: 152px;
        }

        .pill small {
            display: block;
            text-transform: uppercase;
            letter-spacing: .10em;
            font-weight: var(--fw-bold);
            font-size: 10px;
            color: rgba(100, 116, 139, .84);
        }

        .pill b {
            display: block;
            margin-top: 4px;
            font-family: var(--font-accent);
            font-weight: var(--fw-black);
            color: var(--text);
            font-size: var(--fs-sm);
        }

        .oSide {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px;
            min-width: 180px;
        }

        .status {
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: var(--fw-black);
            letter-spacing: .10em;
            text-transform: uppercase;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .86);
            color: rgba(15, 23, 42, .78);
            white-space: nowrap;
            font-family: var(--font-accent);
        }

        .status.unpaid {
            background: rgba(239, 68, 68, .12);
            border-color: rgba(239, 68, 68, .20);
            color: #991B1B;
        }

        .status.processing {
            background: rgba(245, 158, 11, .12);
            border-color: rgba(245, 158, 11, .20);
            color: #92400E;
        }

        .status.shipped {
            background: rgba(59, 130, 246, .12);
            border-color: rgba(59, 130, 246, .20);
            color: #1D4ED8;
        }

        .status.done {
            background: rgba(16, 185, 129, .12);
            border-color: rgba(16, 185, 129, .20);
            color: #0F766E;
        }

        .oActs {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        /* ======================================================
           Chart panel (lebih clean)
        ====================================================== */
        .chartWrap {
            flex: 1;
            min-height: 0;
            display: flex;
            flex-direction: column;
            gap: 14px;
            padding: 16px;
            border-radius: var(--r-xl);
            border: 1px solid rgba(15, 23, 42, .10);
            background:
                linear-gradient(180deg, rgba(255, 255, 255, .86), rgba(255, 255, 255, .74));
            box-shadow: 0 14px 34px rgba(15, 23, 42, .06);
        }

        .chartTop {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: var(--gap-3);
        }

        .chartTitle {
            margin: 0;
            font-family: var(--font-accent);
            font-weight: var(--fw-black);
            font-size: var(--fs-lg);
            letter-spacing: -.01em;
            color: var(--text);
        }

        .chartSub {
            margin: 7px 0 0;
            font-size: var(--fs-sm);
            color: var(--muted);
            font-weight: var(--fw-regular);
            line-height: 1.55;
        }

        .chartBody {
            display: grid;
            grid-template-columns: 170px 1fr;
            gap: var(--gap-3);
            align-items: center;
        }

        .donut {
            width: 170px;
            height: 170px;
            border-radius: 999px;
            background:
                conic-gradient(rgba(239, 68, 68, .82) 0 calc(var(--pUnpaid) * 1%),
                    rgba(245, 158, 11, .82) 0 calc((var(--pUnpaid) + var(--pProcessing)) * 1%),
                    rgba(59, 130, 246, .80) 0 calc((var(--pUnpaid) + var(--pProcessing) + var(--pShipped)) * 1%),
                    rgba(16, 185, 129, .82) 0 100%);
            position: relative;
            border: 1px solid rgba(15, 23, 42, .10);
            box-shadow: 0 18px 46px rgba(15, 23, 42, .08);
            flex: 0 0 auto;
        }

        .donut::after {
            content: "";
            position: absolute;
            inset: 18px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .92);
            border: 1px solid rgba(15, 23, 42, .10);
        }

        .donutCenter {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            z-index: 1;
            text-align: center;
            padding: 22px;
        }

        .donutCenter b {
            font-family: var(--font-accent);
            font-size: 26px;
            font-weight: var(--fw-black);
            line-height: 1.05;
            color: var(--text);
            letter-spacing: -.02em;
        }

        .donutCenter span {
            margin-top: 8px;
            font-size: var(--fs-xs);
            font-weight: var(--fw-bold);
            color: rgba(100, 116, 139, .88);
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .legend {
            display: grid;
            gap: 10px;
        }

        .lg {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .86);
            border: 1px solid rgba(15, 23, 42, .10);
            box-shadow: 0 10px 20px rgba(15, 23, 42, .05);
        }

        .dot {
            width: 11px;
            height: 11px;
            border-radius: 999px;
            flex: 0 0 auto;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .10);
        }

        .lg strong {
            font-size: var(--fs-sm);
            font-weight: var(--fw-bold);
            color: rgba(15, 23, 42, .88);
        }

        .lg small {
            margin-left: auto;
            font-size: var(--fs-sm);
            font-weight: var(--fw-black);
            color: rgba(15, 23, 42, .78);
        }

        .chartHint {
            padding: 12px 12px;
            border-radius: 16px;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .80);
            color: rgba(51, 65, 85, .78);
            font-size: var(--fs-sm);
            font-weight: var(--fw-regular);
            line-height: 1.55;
        }

        .chartHint b {
            font-weight: var(--fw-black);
            color: var(--text);
        }

        .chartActions {
            margin-top: auto;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* ======================================================
           Help (lebih clean)
        ====================================================== */
        .helpWrap {
            padding: 18px;
        }

        .helpGrid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: var(--gap-4);
            margin-top: 16px;
        }

        .helpBox {
            grid-column: span 6;
            padding: 16px;
            border-radius: var(--r-xl);
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .84);
            box-shadow: var(--shadow-sm);
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }

        .helpBox:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 46px rgba(15, 23, 42, .08);
            border-color: rgba(15, 23, 42, .14);
        }

        .helpBox h3 {
            margin: 0;
            font-family: var(--font-accent);
            font-size: var(--fs-lg);
            font-weight: var(--fw-black);
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text);
        }

        .helpList {
            margin-top: 12px;
            display: grid;
            gap: 10px;
        }

        .helpItem {
            padding: 12px 12px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .90);
            border: 1px solid rgba(15, 23, 42, .10);
            cursor: pointer;
            font-weight: var(--fw-semibold);
            color: rgba(15, 23, 42, .86);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: var(--fs-sm);
            box-shadow: 0 10px 20px rgba(15, 23, 42, .05);
            transition: transform .16s ease, box-shadow .16s ease, border-color .16s ease;
        }

        .helpItem:hover {
            transform: translateX(3px);
            box-shadow: 0 14px 28px rgba(15, 23, 42, .07);
            border-color: rgba(15, 23, 42, .14);
        }

        /* ======================================================
           Modal + Toast (clean)
        ====================================================== */
        .ov {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .42);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 9999;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        .ov.show {
            display: flex;
        }

        .modal {
            width: min(560px, 100%);
            background: rgba(255, 255, 255, .92);
            border-radius: var(--r-xl);
            border: 1px solid rgba(15, 23, 42, .12);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .mHead {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 16px 18px;
            background: rgba(255, 255, 255, .86);
            border-bottom: 1px solid rgba(15, 23, 42, .10);
        }

        .mHead h4 {
            margin: 0;
            font-family: var(--font-accent);
            font-weight: var(--fw-black);
            font-size: var(--fs-lg);
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text);
        }

        .x {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            border: 1px solid rgba(15, 23, 42, .12);
            background: rgba(255, 255, 255, .92);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
            box-shadow: 0 10px 20px rgba(15, 23, 42, .06);
        }

        .x:hover {
            transform: rotate(90deg);
            border-color: rgba(15, 23, 42, .18);
            box-shadow: 0 14px 28px rgba(15, 23, 42, .09);
        }

        .mBody {
            padding: 18px;
        }

        .fg {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 14px;
        }

        .fg label {
            font-size: var(--fs-xs);
            font-weight: var(--fw-bold);
            color: rgba(100, 116, 139, .92);
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .ctl {
            height: 44px;
            border-radius: 16px;
            border: 1px solid rgba(15, 23, 42, .12);
            padding: 0 14px;
            background: rgba(255, 255, 255, .96);
            outline: none;
            font-family: var(--font-primary);
            font-size: var(--fs-sm);
            font-weight: var(--fw-regular);
            transition: box-shadow .18s ease, border-color .18s ease;
        }

        .ctl:focus {
            border-color: rgba(215, 255, 30, .70);
            box-shadow: 0 0 0 4px rgba(215, 255, 30, .18);
        }

        textarea.ctl {
            height: auto;
            padding: 12px 14px;
            line-height: 1.55;
        }

        .mActs {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 16px;
        }

        .toast {
            position: fixed;
            right: 20px;
            bottom: 20px;
            width: min(420px, calc(100vw - 40px));
            background: rgba(255, 255, 255, .94);
            border: 1px solid rgba(15, 23, 42, .12);
            border-radius: var(--r-xl);
            box-shadow: var(--shadow-lg);
            padding: 14px;
            display: flex;
            gap: 12px;
            z-index: 10000;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .tIco {
            width: 44px;
            height: 44px;
            border-radius: 16px;
            background:
                radial-gradient(120px 50px at 30% 30%, rgba(215, 255, 30, .50), transparent 60%),
                rgba(15, 23, 42, .04);
            border: 1px solid rgba(15, 23, 42, .10);
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            color: rgba(15, 23, 42, .78);
        }

        .tTitle {
            margin: 0;
            font-family: var(--font-accent);
            font-weight: var(--fw-black);
            font-size: var(--fs-base);
            color: var(--text);
            letter-spacing: -.01em;
        }

        .tMsg {
            margin: 6px 0 0;
            color: rgba(100, 116, 139, .86);
            font-size: var(--fs-sm);
            line-height: 1.45;
            font-weight: var(--fw-regular);
        }

        .tX {
            margin-left: auto;
            width: 38px;
            height: 38px;
            border-radius: 999px;
            border: 1px solid rgba(15, 23, 42, .12);
            background: rgba(255, 255, 255, .92);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform .18s ease, box-shadow .18s ease;
            box-shadow: 0 10px 20px rgba(15, 23, 42, .06);
        }

        .tX:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(15, 23, 42, .09);
        }

        /* ======================================================
           Responsive
        ====================================================== */
        @media (max-width: 1200px) {
            .kpi {
                grid-column: span 6;
            }

            .colOrders {
                grid-column: span 12;
            }

            .colChart {
                grid-column: span 12;
            }

            .helpBox {
                grid-column: span 12;
            }

            .chartBody {
                grid-template-columns: 170px 1fr;
            }
        }

        @media (max-width: 768px) {
            .kpi {
                grid-column: span 12;
            }

            .order {
                grid-template-columns: 1fr;
            }

            .oSide {
                align-items: flex-start;
                min-width: 0;
                margin-top: 14px;
                padding-top: 14px;
                border-top: 1px solid rgba(15, 23, 42, .10);
            }

            .oActs {
                justify-content: flex-start;
            }

            .heroActions .btn2 {
                width: 100%;
            }

            .chartBody {
                grid-template-columns: 1fr;
                gap: var(--gap-4);
            }

            .donut {
                margin: 0 auto;
            }
        }
    </style>
@endpush

@section('content')
    <div class="pageWrap">
        <div class="pageBg"></div>

        <div class="page">

            {{-- HERO --}}
            <div class="card hero">
                <div style="min-width:0">
                    <h1 class="hTitle">{{ $greet }}, <span>{{ $storeName }}</span></h1>
                    <p class="hSub">
                        {{ $today }} • Monitor performa toko, kelola pesanan, dan optimalkan penjualan dari satu
                        dashboard yang terintegrasi.
                    </p>

                    <div class="hMetaRow">
                        <div class="pillMini">
                            <i class="fa-solid fa-bag-shopping"></i>
                            Pesanan hari ini <b>{{ $countProcessing + $countUnpaid }}</b>
                        </div>
                        <div class="pillMini">
                            <i class="fa-solid fa-box"></i>
                            Produk aktif <b>{{ $productsList->count() }}</b>
                        </div>
                        <div class="pillMini">
                            <i class="fa-solid fa-coins"></i>
                            Nilai rata-rata <b>Rp{{ number_format($averageOrderValue, 0, ',', '.') }}</b>
                        </div>
                    </div>
                </div>

                <div class="heroActions">
                    <button class="btn2 primary" type="button" onclick="LB.open('addProduct')">
                        <i class="fa-solid fa-plus"></i> Tambah Produk
                    </button>
                    <a class="btn2" href="{{ route('seller.orders.index') }}">
                        <i class="fa-solid fa-list-check"></i> Kelola Pesanan
                    </a>
                </div>
            </div>

            {{-- KPI --}}
            <div class="kpis">
                <div class="card kpi">
                    <div class="kTop">
                        <div class="kIcoBtn" title="Ringkasan">
                            <i class="fa-solid fa-leaf"></i>
                        </div>
                        <span class="chip success"><i class="fa-solid fa-arrow-up"></i> +12% MoM</span>
                    </div>
                    <div>
                        <p class="kVal">{{ $rescuedItems }}</p>
                        <div class="kLbl">Produk Terselamatkan</div>
                    </div>
                </div>

                <div class="card kpi kAccent">
                    <div class="kTop">
                        <div class="kIcoBtn" title="Flash">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        @php
                            $c = $flashReadyPct > 70 ? 'success' : ($flashReadyPct < 30 ? 'danger' : 'neu');
                            $t =
                                $flashReadyPct > 70
                                    ? 'Siap jual cepat'
                                    : ($flashReadyPct < 30
                                        ? 'Perlu perhatian'
                                        : 'Normal');
                            $i =
                                $flashReadyPct > 70
                                    ? 'fa-arrow-up'
                                    : ($flashReadyPct < 30
                                        ? 'fa-arrow-down'
                                        : 'fa-minus');
                        @endphp
                        <span class="chip {{ $c }}"><i class="fa-solid {{ $i }}"></i>
                            {{ $t }}</span>
                    </div>
                    <div>
                        <p class="kVal">{{ $flashReadyPct }}%</p>
                        <div class="kLbl">Flash Ready</div>
                    </div>
                </div>

                <div class="card kpi">
                    <div class="kTop">
                        <div class="kIcoBtn" title="Pesanan">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <span class="chip neu"><i class="fa-solid fa-minus"></i> Stabil</span>
                    </div>
                    <div>
                        <p class="kVal">{{ $totalOrders }}</p>
                        <div class="kLbl">Total Pesanan</div>
                    </div>
                </div>

                <div class="card kpi">
                    <div class="kTop">
                        <div class="kIcoBtn" title="Rating">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="chip success"><i class="fa-solid fa-arrow-up"></i> Excellent</span>
                    </div>
                    <div>
                        <p class="kVal">{{ $storeRating }}</p>
                        <div class="kLbl">Rating Toko</div>
                    </div>
                </div>
            </div>

            {{-- SPLIT --}}
            <div class="split">
                {{-- ORDERS --}}
                <div class="card colOrders">
                    <div class="panel">
                        <div class="panelHead">
                            <div class="panelTitle">
                                <div class="bico">
                                    <i class="fa-solid fa-truck-fast"></i>
                                </div>
                                <div>
                                    <h2>Pesanan Terbaru</h2>
                                    <p>{{ $ordersList->count() }} pesanan memerlukan perhatian Anda</p>
                                </div>
                            </div>

                            <a class="btn2 btnSm" href="{{ route('seller.orders.index') }}">
                                Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>

                        @if ($ordersList->count() > 0)
                            <div class="orders">
                                @foreach ($ordersList->take(3) as $order)
                                    @php
                                        $rawStatus = $order->status ?? '';
                                        $boardStatus = $mapToBoard($rawStatus);
                                        $total = (float) ($order->total ?? 0);
                                        $created = $order->created_at
                                            ? \Carbon\Carbon::parse($order->created_at)
                                            : null;
                                        $customerName = $order->customer_name ?? 'Pelanggan';
                                        $customerInitial = strtoupper(substr($customerName, 0, 1));
                                        $itemsCount = $order->items_count ?? 1;
                                    @endphp

                                    <div class="order" data-order="{{ $order->id }}">
                                        <div class="oMain">
                                            <div class="avatar">{{ $customerInitial }}</div>
                                            <div style="min-width:0">
                                                <p class="oName">{{ $customerName }}</p>
                                                <div class="oMeta">
                                                    <b style="color: rgba(15,23,42,.92)">#ORD{{ $order->id }}</b>
                                                    • {{ $created ? $created->format('d M Y, H:i') : '-' }}
                                                </div>

                                                <div class="pillRow">
                                                    <div class="pill">
                                                        <small>Total</small>
                                                        <b>Rp{{ number_format($total, 0, ',', '.') }}</b>
                                                    </div>
                                                    <div class="pill">
                                                        <small>Items</small>
                                                        <b>{{ $itemsCount }} produk</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="oSide">
                                            <div class="status {{ $boardStatus }}">
                                                @if ($boardStatus === 'unpaid')
                                                    Belum Bayar
                                                @elseif($boardStatus === 'processing')
                                                    Diproses
                                                @elseif($boardStatus === 'shipped')
                                                    Dikirim
                                                @elseif($boardStatus === 'done')
                                                    Selesai
                                                @endif
                                            </div>

                                            <div class="oActs">
                                                <a class="btn2 btnSm" href="{{ route('seller.orders.show', $order->id) }}">
                                                    <i class="fa-regular fa-eye"></i> Detail
                                                </a>

                                                @if ($boardStatus === 'processing')
                                                    <button class="btn2 primary btnSm" type="button"
                                                        onclick="LB.updateOrderStatus({{ $order->id }}, 'shipped')">
                                                        <i class="fa-solid fa-truck"></i> Kirim
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="chartHint" style="margin-top: 8px;">
                                <b>Belum ada pesanan.</b>
                                Pesanan dari pelanggan akan muncul di sini.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- CHART --}}
                <div class="card colChart">
                    <div class="panel">
                        <div class="chartWrap">
                            <div class="chartTop">
                                <div>
                                    <p class="chartTitle">Ringkasan Status Pesanan</p>
                                    <p class="chartSub">Distribusi status untuk membantu memprioritaskan proses hari ini.
                                    </p>
                                </div>
                                <span class="chip neu" style="margin-top:2px;">
                                    <i class="fa-solid fa-signal"></i> Live
                                </span>
                            </div>

                            <div class="chartBody">
                                <div class="donut"
                                    style="--pUnpaid:{{ $pUnpaid }}; --pProcessing:{{ $pProcessing }}; --pShipped:{{ $pShipped }};">
                                    <div class="donutCenter">
                                        <b>{{ $totalOrders }}</b>
                                        <span>Total Pesanan</span>
                                    </div>
                                </div>

                                <div class="legend">
                                    <div class="lg">
                                        <span class="dot" style="background: rgba(239,68,68,.82)"></span>
                                        <strong>Belum Bayar</strong>
                                        <small>{{ $countUnpaid }}</small>
                                    </div>
                                    <div class="lg">
                                        <span class="dot" style="background: rgba(245,158,11,.82)"></span>
                                        <strong>Diproses</strong>
                                        <small>{{ $countProcessing }}</small>
                                    </div>
                                    <div class="lg">
                                        <span class="dot" style="background: rgba(59,130,246,.80)"></span>
                                        <strong>Dikirim</strong>
                                        <small>{{ $countShipped }}</small>
                                    </div>
                                    <div class="lg">
                                        <span class="dot" style="background: rgba(16,185,129,.82)"></span>
                                        <strong>Selesai</strong>
                                        <small>{{ $countDone }}</small>
                                    </div>
                                </div>
                            </div>

                            <div class="chartHint">
                                <b>Saran cepat:</b>
                                Fokuskan dulu pesanan <b>Diproses</b>, lalu cek <b>Belum Bayar</b> untuk follow-up
                                pembayaran.
                            </div>

                            <div class="chartActions">
                                <a class="btn2 btnSm" href="{{ route('seller.orders.index') }}">
                                    <i class="fa-solid fa-filter"></i> Filter Pesanan
                                </a>
                                <button class="btn2 btnSm" type="button"
                                    onclick="LB.toast('Insight', 'Distribusi status membantu prioritas kerja hari ini.', 'fa-wand-magic-sparkles')">
                                    <i class="fa-solid fa-wand-magic-sparkles"></i> Insight
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- HELP --}}
            <div class="card helpWrap" id="help">
                <div class="panelHead" style="padding:0; margin-bottom:0;">
                    <div class="panelTitle">
                        <div class="bico">
                            <i class="fa-solid fa-circle-question"></i>
                        </div>
                        <div>
                            <h2>Pusat Bantuan</h2>
                            <p>Dukungan cepat untuk operasional toko</p>
                        </div>
                    </div>
                </div>

                <div class="helpGrid">
                    <div class="helpBox">
                        <h3><i class="fa-solid fa-lightbulb"></i> FAQ Cepat</h3>
                        <div class="helpList">
                            <div class="helpItem" onclick="LB.faq(1)"><i class="fa-solid fa-chevron-right"></i> Cara
                                produk dapat label Flash?</div>
                            <div class="helpItem" onclick="LB.faq(2)"><i class="fa-solid fa-chevron-right"></i> Kenapa
                                status pesanan harus diupdate?</div>
                            <div class="helpItem" onclick="LB.faq(3)"><i class="fa-solid fa-chevron-right"></i> Di mana
                                ubah kategori produk?</div>
                        </div>
                    </div>

                    <div class="helpBox">
                        <h3><i class="fa-solid fa-phone-volume"></i> Hubungi Kami</h3>
                        <div class="helpList">
                            <div class="helpItem" style="cursor: default;"><i class="fa-solid fa-envelope"></i>
                                support@lastbite.id</div>
                            <div class="helpItem" style="cursor: default;"><i class="fa-brands fa-whatsapp"></i> +62
                                812-3456-7890</div>
                            <button class="btn2 primary" type="button" onclick="LB.open('complaint')"
                                style="width:100%;">
                                <i class="fa-solid fa-headset"></i> Kirim Keluhan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MODAL: ADD PRODUCT --}}
            <div class="ov" id="addProduct" role="dialog" aria-modal="true">
                <div class="modal">
                    <div class="mHead">
                        <h4><i class="fa-solid fa-plus"></i> Tambah Produk Baru</h4>
                        <button class="x" type="button" onclick="LB.close('addProduct')" aria-label="Tutup">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="mBody">
                        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data"
                            id="addProductForm">
                            @csrf

                            <div class="fg">
                                <label>Nama Produk</label>
                                <input class="ctl" name="name" type="text"
                                    placeholder="Contoh: Roti Tawar Gandum" required>
                            </div>

                            <div class="fg">
                                <label>Kategori</label>
                                <select class="ctl" name="category" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categoryOptions as $category)
                                        <option
                                            value="{{ is_object($category) ? $category->name ?? '' : (string) $category }}">
                                            {{ is_object($category) ? $category->name ?? '' : (string) $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="fg">
                                <label>Harga (Rp)</label>
                                <input class="ctl" name="price" type="number" min="1000" step="1000"
                                    placeholder="15000" required>
                            </div>

                            <div class="fg">
                                <label>Tanggal Kadaluarsa</label>
                                <input class="ctl" name="expired_at" type="date" required>
                            </div>

                            <div class="fg">
                                <label>Foto Produk</label>
                                <input class="ctl" name="photo" type="file" accept="image/*" required>
                            </div>

                            <div class="fg">
                                <label>Deskripsi (Opsional)</label>
                                <textarea class="ctl" name="description" rows="3" placeholder="Deskripsikan produk..."></textarea>
                            </div>

                            <div class="mActs">
                                <button type="button" class="btn2" onclick="LB.close('addProduct')">Batal</button>
                                <button type="submit" class="btn2 primary"><i class="fa-solid fa-floppy-disk"></i>
                                    Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- MODAL: COMPLAINT --}}
            <div class="ov" id="complaint" role="dialog" aria-modal="true">
                <div class="modal">
                    <div class="mHead">
                        <h4><i class="fa-solid fa-headset"></i> Form Keluhan</h4>
                        <button class="x" type="button" onclick="LB.close('complaint')" aria-label="Tutup">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="mBody">
                        <form onsubmit="LB.submitComplaint(event)">
                            <div class="fg">
                                <label>Subjek</label>
                                <input class="ctl" type="text" placeholder="Contoh: Masalah pesanan #123" required>
                            </div>
                            <div class="fg">
                                <label>Detail Keluhan</label>
                                <textarea class="ctl" rows="4" placeholder="Jelaskan masalah Anda..." required></textarea>
                            </div>
                            <div class="mActs">
                                <button type="button" class="btn2" onclick="LB.close('complaint')">Batal</button>
                                <button type="submit" class="btn2 primary"><i class="fa-solid fa-paper-plane"></i>
                                    Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.LB = {
            open(id) {
                const el = document.getElementById(id);
                if (!el) return;
                el.classList.add('show');
                document.body.style.overflow = 'hidden';
            },
            close(id) {
                const el = document.getElementById(id);
                if (!el) return;
                el.classList.remove('show');
                document.body.style.overflow = '';
                if (id === 'addProduct') {
                    const f = document.getElementById('addProductForm');
                    if (f) f.reset();
                }
            },
            toast(title, msg, icon = 'fa-circle-info') {
                const old = document.querySelector('.toast');
                if (old) old.remove();
                const t = document.createElement('div');
                t.className = 'toast';
                t.innerHTML = `
                <div class="tIco"><i class="fa-solid ${icon}"></i></div>
                <div style="min-width:0">
                    <p class="tTitle">${title}</p>
                    <p class="tMsg">${msg}</p>
                </div>
                <button class="tX" type="button" aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
            `;
                t.querySelector('.tX').onclick = () => t.remove();
                document.body.appendChild(t);
                setTimeout(() => {
                    if (t && t.parentNode) t.remove();
                }, 4500);
            },
            faq(i) {
                const faqs = [
                    "Produk mendapat label <b>FLASH</b> jika kadaluarsa <b>0–3 hari</b>.",
                    "Update status penting untuk kejelasan pelanggan dan tracking.",
                    "Ubah kategori dari form Edit / Tambah Produk."
                ];
                this.toast('FAQ', faqs[i - 1] || 'FAQ tidak ditemukan', 'fa-circle-question');
            },
            updateOrderStatus(orderId, status) {
                const map = {
                    unpaid: 'Belum Bayar',
                    processing: 'Diproses',
                    shipped: 'Dikirim',
                    done: 'Selesai'
                };
                this.toast('Berhasil', `Pesanan <b>#${orderId}</b> diupdate ke <b>${map[status]||status}</b>.`,
                    'fa-circle-check');
            },
            submitComplaint(e) {
                e.preventDefault();
                this.toast('Terkirim', 'Keluhan berhasil dikirim. Tim support akan menghubungi Anda.',
                    'fa-circle-check');
                this.close('complaint');
                e.target.reset();
            }
        };

        document.addEventListener('click', (e) => {
            document.querySelectorAll('.ov.show').forEach(ov => {
                if (e.target === ov) LB.close(ov.id);
            });
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.ov.show').forEach(ov => LB.close(ov.id));
            }
        });
    </script>
@endpush
