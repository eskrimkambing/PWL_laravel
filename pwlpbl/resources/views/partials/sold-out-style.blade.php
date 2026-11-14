{{-- Gaya "Sold Out" dipakai bersama oleh halaman Menu, Dashboard Pembeli, dan Produk Pembeli. --}}
<style>
    .product-media {
        position: relative;
        overflow: hidden;
    }

    /* Badge merah di kanan atas foto */
    .sold-out-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 3;
        background: #C62828;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .3px;
        line-height: 1;
        padding: 6px 12px;
        border-radius: 999px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .25);
    }

    /* Foto dibuat pudar dengan lapisan abu-abu */
    .is-sold-out .product-image {
        filter: grayscale(1);
        opacity: .8;
    }

    .is-sold-out .product-media::after {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 2;
        background: rgba(110, 110, 110, .45);
    }

    /* Nama, harga, dan deskripsi tetap terbaca tapi redup */
    .is-sold-out .sold-dim {
        color: #9C928A !important;
    }

    .is-sold-out {
        cursor: not-allowed !important;
    }

    .is-sold-out:hover {
        transform: none !important;
        box-shadow: none !important;
    }

    /* Tombol "Stok Habis" abu-abu dan nonaktif */
    .btn-soldout,
    .is-sold-out .btn-soldout,
    .is-sold-out:hover .btn-soldout {
        display: block;
        width: 100%;
        text-align: center;
        padding: 10px;
        border: 2px solid #BDBDBD !important;
        border-radius: 9px;
        background: #BDBDBD !important;
        color: #fff !important;
        font-weight: 700;
        font-size: 14px;
        cursor: not-allowed;
        pointer-events: none;
        opacity: 1;
    }

    .btn-soldout.btn-sm {
        width: auto;
        padding: 5px 12px;
        font-size: 13px;
    }

    /* Pemberitahuan di dashboard pembeli */
    .sold-out-notice {
        background: #FDECEA;
        border: 1px solid #E5A19A;
        border-left: 5px solid #C62828;
        color: #6A0801;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 14px;
    }
</style>
