<style>
    .qr-batch,
    .qr-page,
    .letter-size {
        width: 8.5in;
        height: 11in;
    }
    .qr-batch {
        margin: 0 auto;
    }
    .qr-page {
        position: relative;
        box-sizing: border-box;
        padding: 1.5cm;
        border: 1px dashed gray;
    }
    .qr-row {
        float: left;
        clear: both;
        padding-bottom: 1.5cm;
    }
    .qr-page .qr-row:last-of-type(1) {
        padding-bottom: 0;
    }
    .qr-row:after,
    .qr-page:after {
        content: "";
        display: table;
        clear: both;
    }
    img {
        width: 2in;
        height: 2in;
        padding-right: 1.6cm;
    }
    .qr-row img:nth-of-type(3) {
        padding-right: 0;
    }
    @media print {
        .no-print {
            display: none;
        }
        .qr-page {
            border: 0;
        }
    }

</style>
<p class="no-print" style="text-align: center; margin: 0"><?php echo "QR Batch Generation Complete: {$count}x \"{$data}\" @ {$size}x{$size}px"?></p>
